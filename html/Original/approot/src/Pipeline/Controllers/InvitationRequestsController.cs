using System.Collections.Generic;
using System.Linq;
using Microsoft.AspNet.Http;
using Microsoft.AspNet.Mvc;
using Microsoft.Data.Entity;
using Pipeline.Models;
using Microsoft.AspNet.Authorization;
using Microsoft.AspNet.Identity;
using System;
using System.Threading.Tasks;
using Pipeline.ViewModels;
using Pipeline.Helpers;
using Newtonsoft.Json;

namespace Pipeline.Controllers
{
    [Authorize]
    [Produces("application/json")]
    [Route("/InvitationRequests")]
    public class InvitationRequestsController : Controller
    {
        private PipelineDbContext _context;
        private readonly string _adminEmail = Startup.Configuration["Pipeline:Email:Admin"];
        private readonly string _inviteEmail = Startup.Configuration["Pipeline:Email:InviteFrom"];
        private readonly string _url = Startup.Configuration["Pipeline:Url"];

        public InvitationRequestsController(PipelineDbContext context)
        {
            _context = context;
        }

        [HttpGet("All")]
        public async Task<IActionResult> All()
        {
            try
            {
                var result = await _context.InvitationRequests.Join(
                                    _context.Profiles, 
                                    ir => ir.Email, 
                                    p => p.Email, 
                                    (ir, p) => new { request = ir, profile = p })
                            .Where(x => !x.request.Approved)
                            .ToListAsync();

                return Json(new {
                    Succeeded = true,
                    Results = result
                });
            }
            catch (Exception ex)
            {
                return Json(new {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "Internal Server Error" } }
                });
            }

        }

        [HttpPost("RequestInvite")]
        [AllowAnonymous]
        public async Task<IActionResult> RequestInvite(InviteRequest model)
        {
            int results = -1;
                Profile profile = null;
            InvitationRequest invitationReq = null;
            EmailHelper helper = EmailHelper.Instance;

            if (ModelState.IsValid)
            {
                try
                {
                    invitationReq = await _context.InvitationRequests.FirstOrDefaultAsync(x => x.Email == model.Email);

                    if (invitationReq != null && invitationReq.CodeUsed)
                    {
                        // Codeused true means the invitation has already been approved.
                        return Json(new
                        {
                            Succeeded = false,
                            Errors = new object[] { new { Description = model.Email + " has already been registered." } }
                        });
                    }
                    else if (invitationReq != null && !invitationReq.CodeUsed && (invitationReq.Expiry > DateTime.Now || invitationReq.Expiry == DateTime.MinValue))
                    {
                        // Invitation already exists, user hasn't registered yet, and invitation hasn't expired yet.
                        return Json(new
                        {
                            Succeeded = false,
                            Errors = new object[] { new { Description = "An invitation already exists for " + model.Email + "." } }
                        });
                    }

                    Location location = new Location()
                    {
                        Street1 = "",
                        Street2 = "",
                        City = "",
                        StateProvince = "",
                        ZipPostal = "",
                        Country = ""
                    };

                    _context.Locations.Add(location);

                    ContactInformation contactInfo = new ContactInformation()
                    {
                        Email = model.Email,
                        Location = location
                    };

                    if (model.Type.Equals("individual"))
                    {
                        contactInfo.FirstName = model.FirstName;
                        contactInfo.LastName = model.LastName;
                        contactInfo.MiddleName = model.MiddleName;

                        profile = new IndividualProfile
                        {
                            Email = model.Email,
                            FirstName = model.FirstName,
                            LastName = model.LastName,
                            MiddleName = model.MiddleName,
                            ContactInfo = contactInfo,
                            Avatar = "/imgs/default_avatars/default_user_avatar.png"
                        };

                    }
                    else if (model.Type.Equals("company"))
                    {
                        profile = new OrganizationProfile
                        {   
                            Email = model.Email,
                            OrganizationName = model.Organization,
                            ContactInfo = contactInfo,
                            Avatar = "/imgs/default_avatars/default_company_avatar.png"
                        };

                    }
                    else
                    {
                        return Json(new
                        {
                            Succeeded = false,
                            Errors = new object[] { new { Description = "User type needs to be individual or company." } }
                        });
                    }

                    _context.Profiles.Add(profile);

                    invitationReq = await _context.InvitationRequests.FirstOrDefaultAsync(x => x.Email == model.Email);

                    // If previous requet already exists
                    if (invitationReq != null)
                    {
                        if (invitationReq.CodeUsed)
                        {
                            // Codeused true means the invitation has already been approved.
                            return Json(new
                            {
                                Succeeded = false,
                                Errors = new object[] { new { Description = model.Email + " has already been registered." } }
                            });
                        }
                        else if (!invitationReq.CodeUsed && (invitationReq.Expiry > DateTime.Now || invitationReq.Expiry == DateTime.MinValue))
                        {
                            // Invitation already exists, user hasn't registered yet, and invitation hasn't expired yet.
                            return Json(new
                            {
                                Succeeded = false,
                                Errors = new object[] { new { Description = "An invitation already exists for " + model.Email + "." } }
                            });
                        }

                        // Previous invitation already exists, so just update the old invitation 
                        // instead of creating a brand new one.
                        invitationReq.DateRequested = DateTime.Now;
                        _context.Entry(profile).State = EntityState.Modified;
                        _context.Entry(invitationReq).State = EntityState.Modified;
                    }
                    else
                    {
                        // This is a brand new inviation so create brand new entiries
                        invitationReq = new InvitationRequest
                        {
                            Email = model.Email,
                            Code = null,
                            DateApproved = DateTime.MinValue,
                            CodeUsed = false,
                            Expiry = DateTime.MinValue,
                            UserType = model.Type,
                            Approved = false,
                            DateRequested = DateTime.Now
                        };

                        _context.ContactInformations.Add(contactInfo);
                        _context.InvitationRequests.Add(invitationReq);
                    }

                    results = await _context.SaveChangesAsync();

                }
                catch (Exception ex)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "There was an internal server error." } }
                    });
                }

                string adminEmailTitle = "Pending Invite Request";
                string adminEmailMessage = "An invite has been requested from:";

                string requesterEmail = model.Email;
                string requesterEmailTitle = "Thanks for requesting an invite to Pipeline";
                string requesterEmailMessage = "We have received your invite request, " + model.FirstName +
                    ".\n We are currently reviewing it, so please be patient in the meantime!";


                if (model.Type.Equals("individual"))
                {
                    adminEmailMessage += "\nFirst name: " + model.FirstName +
                                        "\nLast name: " + model.LastName +
                                        "\nEmail: " + model.Email;
                }
                else if (model.Type.Equals("company"))
                {
                    adminEmailMessage += "\nCompany Name: " + model.Organization + 
                                        "\nEmail: " + model.Email;
                }

                adminEmailMessage += "\n" + _url + "InvitationRequests/approverequest?Email=" + model.Email;

                try
                {
                    if (helper.sendMessage(_inviteEmail, _adminEmail, adminEmailTitle, adminEmailMessage) &&
                        helper.sendMessage(_inviteEmail, requesterEmail, requesterEmailTitle, requesterEmailMessage))
                    {
                        return Json(new
                        {
                            Succeeded = true,
                            responseText = "Invitation request processed and emails sent out successfully."
                        });
                    }
                    else
                    {
                        return Json(new
                        {
                            Succeeded = false,
                            Errors = new object[] { new { Description = "Errors occurred sending emails." } }
                        });
                    }
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

            Response.StatusCode = 500;
            return Json(ModelState);
        }

        protected override void Dispose(bool disposing)
        {
            if (disposing)
            {
                _context.Dispose();
            }
            base.Dispose(disposing);
        }

        [HttpPost("ApproveRequest")]
        public async Task<IActionResult> ApproveRequest(string Email)
        {
            string HtmlResult = "";
            string URI = _url + "register";
            InvitationRequest inv = null;

            try
            {
                inv = await _context.InvitationRequests.FirstOrDefaultAsync(x => x.Email == Email);

                if (inv == null)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "No invite request exists for " + Email + "." } }
                    });
                }
                if (inv.CodeUsed)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = Email + " has already registered." } }
                    });
                }
                else if (inv.Approved)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "The invititation has already been approved." } }
                    });
                }
                else
                {
                    inv.Code = RandomString(6);
                    inv.Expiry = DateTime.Today.AddDays(7);
                    inv.DateApproved = DateTime.Today;
                    inv.CodeUsed = false;
                    inv.Approved = true;

                    _context.Entry(inv).State = EntityState.Modified;
                    await _context.SaveChangesAsync();

                    HtmlResult += URI + "?";
                    HtmlResult += "Email=" + inv.Email;
                    HtmlResult += "&Code=" + inv.Code;

                    string msg = "Click the link below to register to PIPELINE!\n\n" + HtmlResult + "\n\nThe code will expire within 7 days!";
                    string title = "Your invitation has been approved!";
                    string email = Email;

                    EmailHelper helper = EmailHelper.Instance;

                    if (helper.sendMessage(_inviteEmail, inv.Email, title, msg))
                    {
                        return Json(new
                        {
                            Succeeded = true,
                            EmailSent = true,
                            responseText = "Approval email was successfuly sent."
                        });
                    }
                    else
                    {
                        return Json(new
                        {
                            Succeeded = true,
                            EmailSent = false,
                            responseText = "Approval email unsuccessfully sent."
                        });
                    }
                }
            }
            catch (Exception)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "There was an internal server error." } }
                });
            }
        }

        [HttpPost("DenyRequest")]
        public async Task<IActionResult> DenyRequest(string Email)
        {
            InvitationRequest inv = null;

            try
            {
                inv = await _context.InvitationRequests.FirstOrDefaultAsync(x => x.Email == Email);

                if (inv == null)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "No invite request exists for " + Email + "." } }
                    });
                }
                if (inv.CodeUsed)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = Email + " has already registered." } }
                    });
                }
                else if (inv.Approved)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "The invititation has already been approved." } }
                    });
                }
                else
                {
                    inv.Approved = true;

                    _context.Entry(inv).State = EntityState.Modified;
                    await _context.SaveChangesAsync();

                    string msg = "Unfortunately your request to pipeline has been denied.";
                    string title = "Your invitation has been denied.";
                    string email = Email;

                    EmailHelper helper = EmailHelper.Instance;

                    if (helper.sendMessage(_inviteEmail, inv.Email, title, msg))
                    {
                        return Json(new
                        {
                            Succeeded = true,
                            EmailSent = true,
                            responseText = "Approval email was successfuly sent."
                        });
                    }
                    else
                    {
                        return Json(new
                        {
                            Succeeded = true,
                            EmailSent = false,
                            responseText = "Approval email unsuccessfully sent."
                        });
                    }
                }
            }
            catch (Exception)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "There was an internal server error." } }
                });
            }
        }

        private string RandomString(int length)
        {
            const string chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefhijklmnopqrstuvwxyz0123456789";
            var random = new Random();
            return new string(Enumerable.Repeat(chars, length)
              .Select(s => s[random.Next(s.Length)]).ToArray());
        }
    }
}