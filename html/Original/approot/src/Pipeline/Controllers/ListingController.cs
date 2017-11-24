using System;
using System.Threading.Tasks;
using Microsoft.AspNet.Mvc;
using Pipeline.Models;
using Microsoft.AspNet.Authorization;
using Pipeline.ViewModels;
using Microsoft.Data.Entity;
using Microsoft.AspNet.Http;
using Microsoft.AspNet.Hosting;
using Microsoft.Net.Http.Headers;
using System.Net.Mime;
using System.Collections.Generic;
using System.Globalization;
using System.Linq;
using System.Data.SqlClient;
using Microsoft.AspNet.Identity;

namespace Pipeline.Controllers
{
    [Authorize]
    [Produces("application/json")]
    [Route("/Listing")]
    public class ListingController : Controller
    {
        private readonly IHostingEnvironment _hostEnvironment;
        private readonly PipelineDbContext _context;
        private readonly UserManager<User> _userManager;


        public ListingController(IHostingEnvironment hostEnvironment, PipelineDbContext context, UserManager<User> userManager)
        {
            _hostEnvironment = hostEnvironment;
            _context = context;
            _userManager = userManager;
        }

        [HttpPost("AllInvestments")]
        public async Task<IActionResult> AllInvestments(string email)
        {
            try
            {
                User user = await _userManager.FindByEmailAsync(email);

                var listings = (await _context.Listings
                    .Include(x => x.Images)
                    .Join(
                       _context.Profiles,
                       l => l.Email,
                       i => i.Email,
                       (l, i) => new { listing = l, profile = i }
                    )
                    .Where(x => x.listing is ListingInvestment)
                    .ToListAsync())
                    .GroupJoin(
                        _context.SavedListings,
                        li => li.listing.ID,
                        sl => sl.ListingId,
                        (li, sl) => new { listing = li.listing, profile = li.profile, savedlisting = sl }
                    )
                    .SelectMany(
                        sl => sl.savedlisting.DefaultIfEmpty(),
                        (li, sl) => new { listing = li.listing, profile = li.profile, savedlisting = sl, saved = sl != null && sl.UserId.Equals(user.Id) ? true : false }
                    );
                 

                return Json(new
                {
                    Succeeded = true,
                    Listings = listings
                });
            }
            catch (Exception ex)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "Internal Server Error" } }
                });
            }
        }

        [HttpPost("AllFinances")]
        public async Task<IActionResult> AllFinances(string email)
        {
            try
            {
                User user = await _userManager.FindByEmailAsync(email);

                var listings = (await _context.Listings
                    .Include(x => x.Images)
                    .Join(
                       _context.Profiles,
                       l => l.Email,
                       i => i.Email,
                       (l, i) => new { listing = l, profile = i }
                    )
                    .Where(x => x.listing is ListingFinance)
                    .ToListAsync())
                    .GroupJoin(
                        _context.SavedListings,
                        li => li.listing.ID,
                        sl => sl.ListingId,
                        (li, sl) => new { listing = li.listing, profile = li.profile, savedlisting = sl }
                    )
                    .SelectMany(
                        sl => sl.savedlisting.DefaultIfEmpty(),
                        (li, sl) => new { listing = li.listing, profile = li.profile, savedlisting = sl, saved = sl != null && sl.UserId.Equals(user.Id) ? true : false }
                    );

                return Json(new
                {
                    Succeeded = true,
                    Listings = listings
                });
            }
            catch (Exception ex)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "Internal Server Error" } }
                });
            }
        }

        [HttpPost("Find")]
        public async Task<IActionResult> Find(Guid ID)
        {
            try
            {
                Listing listing = await _context.Listings.Include(x => x.Contact).Include(x => x.Images).SingleOrDefaultAsync(x => x.ID.Equals(ID));

                if (listing != null)
                {
                    return Json(new
                    {
                        Succeeded = true,
                        Listing = listing
                    });
                }
            }
            catch (Exception ex)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "Internal Server Error." } }
                });
            }

            return Json(new
            {
                Succeeded = false,
                Errors = new object[] { new { Description = "Listing not found." } }
            });
        }

        [HttpPost("UploadImage")]
        public async Task<IActionResult> UploadImage(IFormFile img, string Id)
        {
            string filename = ContentDispositionHeaderValue.Parse(img.ContentDisposition).FileName.Trim('"');
            string[] delim = new string[] { "." };
            string[] parsed = filename.Split(delim, StringSplitOptions.RemoveEmptyEntries);
            Guid ID = Guid.Parse(Id);
            ListingImage image = new ListingImage();
            image.ID = Guid.NewGuid();
            image.photo = image.ID.ToString() + "." + parsed[1];
            try
            {
                Listing listing = await _context.Listings.Include(x => x.Images).FirstOrDefaultAsync(x => x.ID == ID);
                listing.Images.Add(image);
                _context.Entry(listing).State = EntityState.Modified;
                await _context.SaveChangesAsync();

                await img.SaveAsAsync(_hostEnvironment.WebRootPath + "\\imgs\\listings\\" + image.photo);
            }
            catch (Exception e)
            {
                return Json(e);
            }
            return Json(new
            {
                Succeeded = true,
                Message = new string[] { "Images Saved" }
            });
        }

        [HttpPost("Create")]
        public async Task<IActionResult> Create([FromBody]CreateListing _listing)
        {
            Listing listing;
            try
            {
                if (_listing.Type.Equals("investment"))
                {
                    listing = new ListingInvestment();
                }
                else {
                    listing = new ListingFinance();
                }

                listing.ID = Guid.NewGuid();
                listing.DatePosted = DateTime.Today;
                listing.StartDate = DateTime.ParseExact(_listing.StartDate, "dd-mm-yyyy", CultureInfo.InvariantCulture);
                listing.EndingDate = DateTime.ParseExact(_listing.EndDate, "dd-mm-yyyy", CultureInfo.InvariantCulture);
                listing.Email = _listing.User;
                listing.Tags = new List<ListingTag>();
                listing.Images = new List<ListingImage>();

                listing.Title = _listing.Title;
                listing.Summary = _listing.Summary;
                listing.Description = _listing.Description;
                listing.Jurisdiction = _listing.Jurisdiction;
                listing.Category = _listing.Category;

                if (_listing.Contact)
                {
                    listing.Contact = await _context.ContactInformations.FirstOrDefaultAsync(x => x.Email.Equals(_listing.User));
                    listing.Contact.FirstName = _listing.FirstName;
                    listing.Contact.LastName = _listing.LastName;
                    listing.Contact.Email = _listing.Email;
                    listing.Contact.MainPhone = _listing.MainPhone.Replace("-", string.Empty);
                    listing.Contact.SecondPhone = _listing.SecondPhone != null ? _listing.SecondPhone.Replace("-", string.Empty) : "";
                    listing.Contact.MiddleName = _listing.MiddleName != null ? _listing.MiddleName: "";
                    _context.Entry(listing.Contact).State = EntityState.Modified;
                    await _context.SaveChangesAsync();
                }
                else
                {
                    listing.Contact = new ContactInformation();
                    listing.Contact.Email = _listing.Email;
                    listing.Contact.FirstName = _listing.FirstName;
                    listing.Contact.LastName = _listing.LastName;
                    _listing.MainPhone = _listing.MainPhone.Replace("-", string.Empty);

                    listing.Contact.SecondPhone = _listing.SecondPhone != null ? _listing.SecondPhone.Replace("-", string.Empty) : "";
                    listing.Contact.MiddleName = _listing.MiddleName != null ? _listing.MiddleName : "";

                    listing.Contact.MainPhone = _listing.MainPhone;
                    listing.Contact.SecondPhone = _listing.SecondPhone;

                    _context.ContactInformations.Add(listing.Contact);
                    await _context.SaveChangesAsync();
                }
                if (_listing.Type.Equals("investment"))
                {
                    (listing as ListingInvestment).SeekingPrice = _listing.SeekPrice;
                    (listing as ListingInvestment).InvestmentType = _listing.InvestmentType;
                }
                else {
                    (listing as ListingFinance).LowestCapital = _listing.LowestCapital;
                    (listing as ListingFinance).HighestCapital = _listing.HighestCapital;
                }

                _context.Listings.Add(listing);

                await _context.SaveChangesAsync();
            }
            catch (Exception e)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "Internal server error." } }
                });
            }

            return Json(new
            {
                Succeeded = true,
                Listing = listing
            });
        }

        [HttpPost("SaveListing")]
        public async Task<IActionResult> SaveListing([FromBody]SavedListingViewModel model)
        {
            if (ModelState.IsValid)
            {
                try
                {
                    User user = await _userManager.FindByEmailAsync(model.Email);

                    SavedListing sl = new SavedListing
                    {
                        UserId = user.Id,
                        ListingId = model.ListingId
                    };

                    _context.SavedListings.Add(sl);
                    int result = await _context.SaveChangesAsync();

                    if (result == 1)
                    {
                        return Json(new
                        {
                            Succeeded = true,
                            Message = "Listing Saved"
                        });
                    }
                }
                catch (Exception ex)
                {
                    if (ex.HResult == -2146233088)
                    {
                        return Json(new
                        {
                            Succeeded = false,
                            Errors = new object[] { new { Description = "Listing already saved." } }
                        });
                    }

                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "Internal Server Error." } }
                    });
                }

                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "Internal Server Error." } }
                });
            }

            return Json(new
            {
                Succeeded = false,
                Errors = new object[] { new { Description = "Invalid email or listing id." } }
            });
        }

        [HttpPost("UnsaveListing")]
        public async Task<IActionResult> UnsaveListing([FromBody]SavedListingViewModel model)
        {
            if (ModelState.IsValid)
            {
                try
                {
                    SavedListing sl = await _context.SavedListings.Where(x => x.user.Email.Equals(model.Email) && x.ListingId.Equals(model.ListingId)).SingleAsync();

                    _context.SavedListings.Remove(sl);
                    
                    int result = await _context.SaveChangesAsync();

                    if (result == 1)
                    {
                        return Json(new
                        {
                            Succeeded = true,
                            Message = "Listing Unsaved"
                        });
                    }
                }
                catch (Exception ex)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "Internal Server Error." } }
                    });
                }
            }

            return Json(new
            {
                Succeeded = false,
                Errors = new object[] { new { Description = "Invalid email or listing id." } }
            });
        }

        [HttpPost("GetSavedListings")]
        public async Task<IActionResult> GetSavedListings(string email)
        {
            if (email != null)
            {
                try
                {
                    User user = await _userManager.FindByEmailAsync(email);

                    var result = (await _context.Listings.Include(x => x.Images).Join(_context.SavedListings, l => l.ID, sl => sl.ListingId, (l, sl) => new { l, sl })
                        .Where(x => x.sl.UserId.Equals(user.Id))
                        .ToListAsync())
                        .Join(_context.Profiles, l => l.l.Email, p => p.Email, (l, p) => new { listing = l.l, profile = p });

                    return Json(new
                    {
                        Succeeded = true,
                        Listings = result
                    });

                }
                catch (Exception ex)
                {
                    return Json(new
                    {
                        Succeeded = true,
                        Errors = new object[] { new { Description = "Internal server error" } }
                    });
                }
            }

            return Json(new
            {
                Succeeded = true,
                Errors = new object[] { new { Description = "Email cannot be null" } }
            });
        }

        [HttpPost("GetUserListings")]
        public async Task<IActionResult> GetUserListings(string email)
        {
            try
            {
                var result = await _context.Listings
                    .Include(x => x.Images)
                    .Where(x => x.Email.Equals(email))
                    .Join(_context.Profiles, l => l.Email, p => p.Email, (l, p) => new { listing = l, profile = p })
                    .ToListAsync();

                if (result.Count > 0)
                {
                    return Json(new
                    {
                        Succeeded = true,
                        Listings = result
                    });
                }
                else
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "No listings found for user." } }
                    });
                }
            }
            catch (Exception ex)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "Internal server error." } }
                });
            }
        }

        [HttpPost("DeleteListing")]
        public async Task<IActionResult> DeleteListing([FromBody]SavedListingViewModel model)
        {
            if (ModelState.IsValid)
            {
                try
                {
                    var savedListings = await _context.SavedListings.Where(sl => sl.ListingId.Equals(model.ListingId)).ToArrayAsync();
                    _context.RemoveRange(savedListings);
                    await _context.SaveChangesAsync();

                    var listing = await _context.Listings.Include(l => l.Images).SingleOrDefaultAsync(l => l.ID.Equals(model.ListingId));
                    _context.Remove(listing);
                    await _context.SaveChangesAsync();

                    return Json(new
                    {
                        Succeeded = true,
                        Message = "Listing successfully deleted."
                    });
                }
                catch (Exception ex)
                {
                    return Json(new
                    {
                        Succeeded = false,
                        Errors = new object[] { new { Description = "Internal Server Error" } }
                    });
                }
            }

            return Json(new
            {
                Succeeded = false,
                Errors = new object[] { new { Description = "Listing ID and user email cannot be null." } }
            });
        }

        [HttpPost("EditListing")] 
        public async Task<IActionResult> EditListing([FromBody] EditListing _listing)
        {
            try
            {
                Listing listing = await _context.Listings.Where(x => x.ID.Equals(_listing.ID)).SingleOrDefaultAsync();

                if (listing == null)
                {
                    return Json(new
                    {
                        Succeeded = true,
                        Errors = new object[] { new { Description = "Listing not found." } }
                    });
                }

                listing.StartDate = DateTime.ParseExact(_listing.StartDate, "dd-mm-yyyy", CultureInfo.InvariantCulture);
                listing.EndingDate = DateTime.ParseExact(_listing.EndDate, "dd-mm-yyyy", CultureInfo.InvariantCulture);

                listing.Title = _listing.Title;
                listing.Summary = _listing.Summary;
                listing.Description = _listing.Description;
                listing.Jurisdiction = _listing.Jurisdiction;
                listing.Category = _listing.Category;

                if (_listing.Contact)
                {
                    listing.Contact = await _context.ContactInformations.FirstOrDefaultAsync(x => x.Email.Equals(_listing.User));
                    listing.Contact.FirstName = _listing.FirstName;
                    listing.Contact.LastName = _listing.LastName;
                    listing.Contact.Email = _listing.Email;
                    listing.Contact.MainPhone = _listing.MainPhone.Replace("-", string.Empty);
                    listing.Contact.SecondPhone = _listing.SecondPhone != null ? _listing.SecondPhone.Replace("-", string.Empty) : "";
                    listing.Contact.MiddleName = _listing.MiddleName != null ? _listing.MiddleName : "";
                    _context.Entry(listing.Contact).State = EntityState.Modified;
                    await _context.SaveChangesAsync();
                }
                else
                {
                    listing.Contact = new ContactInformation();
                    listing.Contact.Email = _listing.Email;
                    listing.Contact.FirstName = _listing.FirstName;
                    listing.Contact.LastName = _listing.LastName;
                    _listing.MainPhone = _listing.MainPhone.Replace("-", string.Empty);

                    listing.Contact.SecondPhone = _listing.SecondPhone != null ? _listing.SecondPhone.Replace("-", string.Empty) : "";
                    listing.Contact.MiddleName = _listing.MiddleName != null ? _listing.MiddleName : "";

                    listing.Contact.MainPhone = _listing.MainPhone;
                    listing.Contact.SecondPhone = _listing.SecondPhone;

                    _context.ContactInformations.Add(listing.Contact);
                    await _context.SaveChangesAsync();
                }

                if (_listing.Type.Equals("investment"))
                {
                    (listing as ListingInvestment).SeekingPrice = _listing.SeekPrice;
                    (listing as ListingInvestment).InvestmentType = _listing.InvestmentType;
                }
                else {
                    (listing as ListingFinance).LowestCapital = _listing.LowestCapital;
                    (listing as ListingFinance).HighestCapital = _listing.HighestCapital;
                }


                _context.Update(listing);
                await _context.SaveChangesAsync();


                return Json(new
                {
                    Succeeded = true,
                    Listing = listing
                });
            }
            catch (Exception e)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "Internal server error." } }
                });
            }
        }
    }
}
