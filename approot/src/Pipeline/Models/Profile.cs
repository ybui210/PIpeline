using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Linq;
using System.Threading.Tasks;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Security.Cryptography.X509Certificates;

namespace Pipeline.Models
{
    [Table("Profiles")]
    public abstract class Profile
    {
        [Key]
        [MaxLength(256)]
        public string Email { get; set; }

        public User User { get; set; }

        [Required]
        public ContactInformation ContactInfo { get; set; }

        [DefaultValue("")]
        public string Purpose { get; set; }

        [MaxLength(64)]
        public string Avatar { get; set; }

        [MaxLength(256)]
        public string Bio { get; set; }

        [MaxLength(64)]
        public string WebsiteUrl { get; set; }

        [MaxLength(64)]
        public string LinkedinUrl { get; set; }
    }

}
