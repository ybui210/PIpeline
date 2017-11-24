using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNet.Mvc;
using Microsoft.AspNet.Authorization;
using Pipeline.Helpers;
using Pipeline.ViewModels;

// For more information on enabling MVC for empty projects, visit http://go.microsoft.com/fwlink/?LinkID=397860

namespace Pipeline.Controllers
{
    [Produces("application/json")]
    [Route("/Landing")]
    [Authorize]
    public class LandingController : Controller
    {
        private readonly string _adminEmail = Startup.Configuration["Pipeline:Email:Admin"];
        private readonly string _contactEmail = Startup.Configuration["Pipeline:Email:ContactForm"];

        [HttpPost("ContactMessage")]
        [AllowAnonymous]
        public ActionResult ContactMessage(ContactForm Contactform)
        {
            try
            {
                EmailHelper emailHelper = EmailHelper.Instance;

                string emailTitle = "New Inquery by " + Contactform.Name;
                string emailMsg = "Requester Name: " + Contactform.Name;
                emailMsg += "\nRequesert Email: " + Contactform.Email;
                emailMsg += "\nRequester Message: \n";
                string[] lines = Contactform.Message.Split(new string[] { "<br />" }, StringSplitOptions.None);
                foreach(string line in lines)
                {
                    emailMsg += line + "\n";
                }
                emailHelper.sendMessage(_contactEmail, _adminEmail, emailTitle, emailMsg);

            }
            catch (Exception ex)
            {
                return Json(new
                {
                    Succeeded = false,
                    Message = new object[] { new { Description = "Email failed to send" } }
                });
            }
            return Json(new
            {
                Succeeded = true,
                Message = new object[] { new { Description = "Email Sent" } }
            });
        }
    }
}
