using Pipeline.Models;
using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.ViewModels
{
    public class InviteRequest
    {
        [Required]
        [EmailAddress]
        public string Email { get; set; }
        public string FirstName { get; set; }
        public string LastName { get; set; }
        public string MiddleName { get; set; }
        public string Organization { get; set; }
        public string Purpose { get; set; }
        public string BusinessCategories { get; set; }
        public string LinkedinUrl { get; set; }
        public string WebsiteUrl { get; set; }
        [Required]
        public string Type { get; set; }
    }
}
