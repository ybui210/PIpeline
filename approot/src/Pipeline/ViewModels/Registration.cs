using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.ViewModels
{
    public class Registration
    {
        [Required]
        [EmailAddress]
        public string Email { get; set; }
        public string FirstName { get; set; }
        public string LastName { get; set; }
        public string MiddleName { get; set; }
        public string Organization { get; set; }         
        [Required]
        public string Password { get; set; }
        [Required]
        public string Type { get; set; }

        public bool ValidTypeValues()
        {
            if (Type.Equals("individual") && FirstName == null && LastName == null)
            {
                return false;
            }
            else if (Type.Equals("organization") && Organization == null)
            {
                return false;
            }

            return true;
        }
    }
}
