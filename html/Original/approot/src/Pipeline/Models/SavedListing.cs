using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.Models
{
    public class SavedListing
    {
        [Key]
        public Guid ListingId { get; set; }

        [Key]
        public string UserId { get; set; }

        [ForeignKey("UserId")]
        public User user { get; set; }

        [ForeignKey("ListingId")]
        public Listing listing { get; set; }
    }
}
