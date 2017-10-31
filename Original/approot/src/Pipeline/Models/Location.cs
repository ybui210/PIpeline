using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.Models
{
    [Table("Locations")]
    public class Location
    {
        [Key]
        public Guid ID { get; set; }

        [Required]
        [MaxLength(64)]
        public string Street1 { get; set; }

        [MaxLength(64)]
        public string Street2 { get; set; }

        [Required]
        [MaxLength(32)]
        public string City { get; set; }

        [Required]
        [MaxLength(8)]
        public string ZipPostal { get; set; }

        [Required]
        [MaxLength(16)]
        public string StateProvince { get; set; }

        [Required]
        [MaxLength(16)]
        public string Country { get; set; }

        public Location()
        {
            ID = Guid.NewGuid();
        }
    }
}
