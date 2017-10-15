    using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace Pipeline.Models
{
    public abstract class Listing
    {
        [Key]
        public Guid ID { get; set; }
        
        [Required]
        [MaxLength(256)]
        public string Email { get; set; }

        [Required]
        public DateTime StartDate { get; set; }

        [Required]
        public DateTime EndingDate { get; set; }

        [Required]
        public DateTime DatePosted { get; set; }

        [Required]
        [MaxLength(64)]
        public string Title { get; set; }

        [Required]
        [MaxLength(1024)]
        public string Summary { get; set; }

        [Required]
        public ContactInformation Contact { get; set; }

        public ICollection<ListingTag> Tags { get; set; }

        public ICollection<ListingImage> Images { get; set; }

        [Required]
        public string Description { get; set; }

        [Required]
        [MaxLength(64)]
        public string Jurisdiction { get; set; }

        [Required]
        [MaxLength(64)]
        public string Category { get; set; }
    }
}
