using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.Models
{
    [Table("ListingInvestments")]
    public class ListingInvestment : Listing
    {

        [Required]
        public double SeekingPrice { get; set; }

        [Required]
        [MaxLength(32)]
        public string InvestmentType { get; set; }
    }
}
