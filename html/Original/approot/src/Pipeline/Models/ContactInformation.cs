using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.Models
{
    [Table("ContactInformations")]
    public class ContactInformation
    {
        public Guid ID { get; set; }

        [DefaultValue("")]
        [MaxLength(32)]
        public string FirstName { get; set; }

        [DefaultValue("")]
        [MaxLength(32)]
        public string LastName { get; set; }

        [DefaultValue("")]
        [MaxLength(32)]
        public string MiddleName { get; set; }

        [Required]
        [MaxLength(256)]
        public string Email { get; set; }

        [MaxLength(16)]
        [DataType(DataType.PhoneNumber)]
        public string MainPhone { get; set; }

        [MaxLength(16)]
        [DataType(DataType.PhoneNumber)]
        public string SecondPhone { get; set; }

        public Location Location { get; set; }

        public ContactInformation()
        {
            ID = Guid.NewGuid();
        }
    }
}
