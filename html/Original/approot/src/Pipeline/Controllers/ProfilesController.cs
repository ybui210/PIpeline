using System.Linq;
using Microsoft.AspNet.Mvc;
using Microsoft.AspNet.Mvc.Rendering;
using Microsoft.Data.Entity;
using Pipeline.Models;
using Microsoft.AspNet.Authorization;
using System.Threading.Tasks;
using Pipeline.ViewModels;

namespace Pipeline.Controllers
{
    [Authorize]
    [Produces("application/json")]
    [Route("/Profiles")]
    public class ProfilesController : Controller
    {
        private PipelineDbContext _context;

        public ProfilesController(PipelineDbContext context)
        {
            _context = context;    
        }

        [HttpPost("Find")]
        public async Task<IActionResult> Find(string email)
        {
            Profile profile = null;

            profile = await _context.Profiles.Include(x => x.ContactInfo).Include(x => x.ContactInfo.Location).FirstOrDefaultAsync(x => x.Email.Equals(email));

            if (profile != null)
            {
                return Json(new
                {
                    Avatar = profile.Avatar,
                    Bio = profile.Bio,
                    FirstName = profile is IndividualProfile ? (profile as IndividualProfile).FirstName : profile.ContactInfo.FirstName,
                    LastName = profile is IndividualProfile ? (profile as IndividualProfile).LastName : profile.ContactInfo.LastName,
                    MiddleName = profile is IndividualProfile ? (profile as IndividualProfile).MiddleName : profile.ContactInfo.MiddleName,
                    OrganizationName = profile is OrganizationProfile ? (profile as OrganizationProfile).OrganizationName : "",
                    Street1 = profile.ContactInfo.Location.Street1,
                    Street2 = profile.ContactInfo.Location.Street2,
                    City = profile.ContactInfo.Location.City,
                    StateProvince = profile.ContactInfo.Location.StateProvince,
                    ZipPostal = profile.ContactInfo.Location.ZipPostal,
                    Country = profile.ContactInfo.Location.Country,
                    Email = profile.Email,
                    MainPhone = profile.ContactInfo.MainPhone,
                    SecondPhone = profile.ContactInfo.SecondPhone,
                    UserRole = profile is IndividualProfile ? Roles.Individual.ToString() : Roles.Organization.ToString(),
                    Succeeded = true
                });
            }

            return Json(new
            {
                Succeeded = false,
                Errors = new object[] { new { Description = "No profile found for " + email } }
            });
        }

        // POST: Profiles/Edit/5
        [HttpPost("Edit")]
        public async Task<IActionResult> Edit(ProfileContact profileContact)
        {
            if (ModelState.IsValid)
            {
                Profile profile = await _context.Profiles.Include(x => x.ContactInfo)
                    .Include(x => x.ContactInfo.Location)
                    .SingleOrDefaultAsync(x => x.Email.Equals(profileContact.Email));

                if (profile != null && profile.ContactInfo != null && profile.ContactInfo.Location != null)
                {
                    profile.Bio = profileContact.Bio;
                    profile.ContactInfo.FirstName = profileContact.FirstName;
                    profile.ContactInfo.MiddleName = profileContact.MiddleName;
                    profile.ContactInfo.LastName = profileContact.LastName;
                    profile.ContactInfo.MainPhone = profileContact.MainPhone;
                    profile.ContactInfo.SecondPhone = profileContact.SecondPhone;
                    profile.ContactInfo.Location.Street1 = profileContact.Street1;
                    profile.ContactInfo.Location.Street2 = profileContact.Street2;
                    profile.ContactInfo.Location.City = profileContact.City;
                    profile.ContactInfo.Location.StateProvince = profileContact.StateProvince;
                    profile.ContactInfo.Location.ZipPostal = profileContact.ZipPostal;
                    profile.ContactInfo.Location.Country = profileContact.Country;
                }

                _context.Update(profile);
                await _context.SaveChangesAsync();

                return Json(new {
                    Succeeded = true,
                    Message = "Successfully saved changes."
                });
            }

            return Json(new
            {
                Succeeded = false,
                Errors = new object[] { new { Description = "Internal server error." } }
            });
        }
    }
}
