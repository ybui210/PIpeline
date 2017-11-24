using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.Models
{
    [Table("ListingFinances")]
    public class ListingFinance : Listing
    {
        [Required]
        public double LowestCapital { get; set; }

        [Required]  
        public double HighestCapital { get; set; }
    }
}
