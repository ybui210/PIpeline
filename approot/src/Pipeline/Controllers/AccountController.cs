using System;
using System.Collections.Generic;
using System.Linq;
using System.Security.Claims;
using System.Threading.Tasks;
using Microsoft.AspNet.Authorization;
using Microsoft.AspNet.Identity;
using Microsoft.AspNet.Mvc;
using Microsoft.AspNet.Mvc.Rendering;
using Microsoft.Data.Entity;
using Microsoft.Extensions.Logging;
using Pipeline.Models;
using Pipeline.ViewModels;
using Newtonsoft.Json;
using Microsoft.AspNet.Http;
using Pipeline.Helpers;
using System.Net;

namespace Pipeline.Controllers
{
    [Authorize]
    [Produces("application/json")]
    [Route("/Account")]
    public class AccountController : Controller
    {
        private readonly UserManager<User> _userManager;
        private readonly SignInManager<User> _signInManager;
        private readonly PipelineDbContext _context;
        private readonly string _adminEmail = Startup.Configuration["Pipeline:Email:Admin"];
        private readonly string _verficationEmail = Startup.Configuration["Pipeline:Email:VerificationFrom"];
        private readonly string _url = Startup.Configuration["Pipeline:Url"];

        public AccountController(
            UserManager<User> userManager,
            SignInManager<User> signInManager)
        {
            _userManager = userManager;
            _signInManager = signInManager;
            _context = new PipelineDbContext();
        }

        [HttpPost("Login")]
        [AllowAnonymous]
        public async Task<IActionResult> Login([FromBody]Login model)
        {
            SignInResult result = null;
            User user = null;

            if (ModelState.IsValid)
            {
                result = await _signInManager.PasswordSignInAsync(model.Username, model.Password, model.RememberMe, lockoutOnFailure: false);

                if (result.Succeeded)
                {
                    try
                    {
                        user = await _userManager.FindByEmailAsync(model.Username);
                        return await ReturnJsonUser(user);
                    }
                    catch (Exception)
                    {
                        return Json(new {
                            Succeeded = false,
                            Confirmed = false,
                            Errors = new object[] { new { Description = "There was an internal server error." } }
                        });
                    }
                }
                else
                {
                    return Json(result);
                }
            }

            // If we got this far, something failed, redisplay form
            Response.StatusCode = 500;
            return Json(ModelState);
        }

        [HttpPost("ResetPW")]
        [AllowAnonymous]
        public async Task<IActionResult> ResetPassword(string email)
        {
            EmailHelper em = EmailHelper.Instance;
            User user = new User();
            
            try
            {
                user = await _userManager.FindByEmailAsync(email);
                if (user != null)
                {
                    string resetToken = await _userManager.GeneratePasswordResetTokenAsync(user);
                    //ForgotPassword fpw = new ForgotPassword()
                    //{
                    //    email = user.Email,
                    //    token = resetToken
                    //};
                    //_context.ForgotPasswords.Add(fpw);
                    //await _context.SaveChangesAsync();

                    string emailTitle = "Reset Your Password";
                    string emailMessage = "You've requested to reset your password. You have 24 hours to change it. Click here:";
                    string emailUrl = _url + "changepassword?verification=" + resetToken + "&email=" + user.Email;
                    emailUrl = emailUrl.Replace("+", "%2B");
                    emailMessage += emailUrl;

                    em.sendMessage(_adminEmail, email, emailTitle, emailMessage);
                }

            } catch (Exception e)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "Yous not the right guy" } }
                });
            }
            return Json(new
            {
                Succeeded = true,
                Message = new object[] { new { Description = "Yous the right guy" } }
            });

        }

        [AllowAnonymous]
        [HttpPost("ChangeFPassword")]
        public async Task<IActionResult> ChangePassword(string email, PasswordHolder model, string token)
        {
            token = token.Replace("%2B", "+");
            User user = null;
            user = await _userManager.FindByEmailAsync(email);
            if (await _userManager.CheckPasswordAsync(user, model.CurrentPassword))
            {
                try
                {
                    IdentityResult passwordChangeResult = await _userManager.ResetPasswordAsync(user, token, model.NewPassword);
                } catch (Exception e)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "Yous not the right guy, guy. inside exception" } }
                    });
                }
                

                return Json(new
                {
                    Succeeded = true,
                    Message = new object[] { new { Description = "Yous the right guy" } }
                });
            }
            else
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "Yous not the right guy, guy. outside exception" } }
                });
            }

        }

        [HttpPost("ChangePassword")]
        public async Task<IActionResult> ChangePassword(string email, PasswordHolder model)
        {
            User user = null;
            if (HttpContext.User.Identity.IsAuthenticated)
            {
                user = await _userManager.FindByEmailAsync(email);
            }
            if(await _userManager.CheckPasswordAsync(user, model.CurrentPassword))
            {
                string resetToken = await _userManager.GeneratePasswordResetTokenAsync(user);
                IdentityResult passwordChangeResult = await _userManager.ResetPasswordAsync(user, resetToken, model.NewPassword);

                return Json(new
                {
                    Succeeded = true,
                    Message = new object[] { new { Description = "Yous the right guy" } }
                });
            }
            else
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "Yous not the right guy" } }
                });
            }

        }

        [HttpPost("Register")]
        [AllowAnonymous]
        public async Task<IActionResult> Register(Registration model)
        {
            int results = -1;
            IdentityResult result = null;
            Profile profile = await _context.Profiles.SingleOrDefaultAsync(x => x.Email == model.Email);

            if (model.Type.Equals("company"))
            {
                model.FirstName = "";
                model.LastName = "";
                model.MiddleName = "";

                // veirfy organization name
                if ((profile as OrganizationProfile).OrganizationName != model.Organization)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "Cannot change organization name." } }
                    });
                }

            }
            else if (model.Type.Equals("individual"))
            {
                model.Organization = "";

                // verify first name
                if ((profile as IndividualProfile).FirstName != model.FirstName)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "Cannot change first name" } }
                    });
                }

                // verify middle name
                if ((profile as IndividualProfile).MiddleName != model.MiddleName)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description =  "Cannot change middle name" } }
                    });
                }

                // verify last name
                if ((profile as IndividualProfile).LastName != model.LastName)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "Cannot change last name" } }
                    });
                }

            }

            if (ModelState.IsValid && model.ValidTypeValues())
            {
                User user = new User
                {
                    UserName = model.Email,
                    Email = model.Email,
                    AccountStatus = AccountStatus.Active
                };

                ContactInformation contactInfo = await _context.ContactInformations.FirstOrDefaultAsync(x => x.Email.Equals(model.Email));

                if (contactInfo == null)
                {
                    contactInfo = new ContactInformation
                    {
                        Email = model.Email,
                        FirstName = model.FirstName,
                        LastName = model.LastName,
                        MiddleName = model.MiddleName,
                        
                    };

                    _context.Add(contactInfo);
                }

                try
                {
                    result = await _userManager.CreateAsync(user, model.Password);

                    InvitationRequest inviteReuqest = await _context.InvitationRequests.FirstAsync(x => (x.Email == model.Email));

                    if (result.Succeeded)
                    {
                        if (model.Type.Equals("individual"))
                        {
                            await _userManager.AddToRoleAsync(user, Roles.Individual.ToString());
                        }
                        else if (model.Type.Equals("company"))
                        {
                            await _userManager.AddToRoleAsync(user, Roles.Organization.ToString());
                        }

                        // change code in invitation table to used
                        inviteReuqest.CodeUsed = true;
                        _context.Entry(inviteReuqest).State = EntityState.Modified;

                        results = await _context.SaveChangesAsync();

                        // send out email confirmation		
                        // confirmation email
                        EmailHelper emailHelper = EmailHelper.Instance;

                        var code = await _userManager.GenerateEmailConfirmationTokenAsync(user);
                        code = code.Replace("+", "%2B");
                        string emailTitle = "Please confirm your email";
                        string emailMsg = "Please confirm your email address by clicking this link:" + _url
                            + "register?Verification=" + code
                            + "&email=" + user.Email;
                        emailHelper.sendMessage(_verficationEmail, user.Email, emailTitle, emailMsg);
                    }
                    else
                    {
                        return Json(result);
                    }
                    
                    if (result.Succeeded && results == 1)
                    {
                         await _signInManager.SignInAsync(user, isPersistent: true);

                        return await ReturnJsonUser(user);
                    }

                }
                catch (Exception ex)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "Internal server error" } }
                    });
                }
            }

            return Json(result);
        }

        [AllowAnonymous]
        [HttpPost("Validate")]
        public async Task<JsonResult> ValidateEmail(string Verification, string Email)
        {
            try
            {
                var user = await _userManager.FindByEmailAsync(Email);
                var result = await _userManager.ConfirmEmailAsync(user, Verification);

                await _userManager.UpdateAsync(user);
            }
            catch (Exception ex)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "Email was not valided successfully" } }
                });
            }

            return Json(new
            {
                Succeeded = true,
                Errors = new object[] { new { Description = "Email successully validated" } }
            });
        }

        [AllowAnonymous]
        [HttpPost("Propogate")]
        public async Task<JsonResult> Propogate(InvitationRequest invite)
        {
            var email = invite.Email;
            var code = invite.Code;
            InvitationRequest inviteRequest;
            Profile profile;

            try
            {
                inviteRequest = await _context.InvitationRequests.Where(x => (x.Email == email))
                                .Where(x => (x.Code == code))
                                .Where(x => (x.CodeUsed == false))
                                .SingleOrDefaultAsync();

                profile = await _context.Profiles.Where(x => x.Email == email).SingleOrDefaultAsync();
            }
            catch (Exception ex)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "There was an internal server error." } }
                });
            }

            // no invitation found
            if (inviteRequest == null)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "No invitation was found for " + email + "." } }
                });
            }
            else if (profile == null)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "No profile was found for " + email + "." } }
                });
            }
            else
            {
                var codeExpiration = invite.Expiry;

                // invitation is expired
                if (inviteRequest.Expiry < DateTime.Now)
                {
                    return Json(new {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "The invitation for " + email + "has expired." } }
                    });
                }
                // invitation is valid
                else
                {
                    try
                    {
                        return Json(new
                        {
                            Succeeded = true,
                            FirstName = (profile is IndividualProfile) ? (profile as IndividualProfile).FirstName : "",
                            LastName = (profile is IndividualProfile) ? (profile as IndividualProfile).LastName : "",
                            MiddleName = (profile is IndividualProfile) ? (profile as IndividualProfile).MiddleName : "",
                            OrganizationName = (profile is OrganizationProfile) ? (profile as OrganizationProfile).OrganizationName : "",
                            UserType = inviteRequest.UserType,
                            Email = email
                        });
                    }
                    catch (Exception ex)
                    {
                        return Json(new
                        {
                            Succeeded = false,
                            Errors = new object[] { new { Description = "There was an internal server error." } }
                        });
                    }
                }
            }
        }

        [HttpPost("IsAuthenticated")]
        public async Task<IActionResult> IsAuthenticated(string email) {
            if (HttpContext.User.Identity.IsAuthenticated)
            {
                User user = await _userManager.FindByEmailAsync(email);
                return await ReturnJsonUser(user);            
            }
      
            return Json(new {
                Succeeded = false
            }); 
        }

        private async Task<IActionResult> ReturnJsonUser(User user)
        {
            Profile profile = await _context.Profiles.FirstAsync(x => x.Email.Equals(user.Email));

            if (await _userManager.IsInRoleAsync(user, Roles.Admin.ToString()))
            {
                return Json(new
                {
                    firstName = (profile as IndividualProfile).FirstName,
                    lastName = (profile as IndividualProfile).LastName,
                    middleName = (profile as IndividualProfile).MiddleName,
                    avatar = profile.Avatar,
                    email = user.Email,
                    role = Roles.Admin.ToString(),
                    Succeeded = true,
                    Confirmed = user.EmailConfirmed
                });
            }
            else if (await _userManager.IsInRoleAsync(user, Roles.Individual.ToString()))
            {
                return Json(new
                {
                    firstName = (profile as IndividualProfile).FirstName,
                    lastName = (profile as IndividualProfile).LastName,
                    middleName = (profile as IndividualProfile).MiddleName,
                    avatar = profile.Avatar,
                    email = user.Email,
                    role = Roles.Individual.ToString(),
                    Succeeded = true,
                    Confirmed = user.EmailConfirmed
                });
            }
            else if (await _userManager.IsInRoleAsync(user, Roles.Organization.ToString()))
            {
                return Json(new
                {
                    organizationName = (profile as OrganizationProfile).OrganizationName,
                    avatar = profile.Avatar,
                    email = user.Email,
                    role = Roles.Organization.ToString(),
                    Succeeded = true,
                    Confirmed = user.EmailConfirmed
                });
            }

            return Json(new
            {
                Succeeded = false
            });
        }

        [HttpPost("LogOff")]
        public async Task<IActionResult> LogOff()
        {
            try
            {
                await _signInManager.SignOutAsync();
            }
            catch (Exception ex)
            {
                Response.StatusCode = 500;
                return Json(ex);
            }

            return Json(new {
                Succeeded = true
            });
        }
    }
}
