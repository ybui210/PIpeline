using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.ViewModels
{
    public class CreateListing
    {
        //[Required]
        //[MaxLength(64)]
        public string Title { get; set; }

        //[Required]
        //[MaxLength(512)]
        public string Summary { get; set; }

        //[Required]
        public string Description { get; set; }

        //[Required]
        [MaxLength(64)]
        public string Jurisdiction { get; set; }

        //[Required]
        //[MaxLength(64)]
        public string Category { get; set; }


        //[Required]
        //[MaxLength(64)]
        public string StartDate { get; set; }

        //[Required]
        //[MaxLength(64)]
        public string EndDate { get; set; }

        //[Required]
        //[MaxLength(256)]
        public string Email { get; set; }

        //[Required]
        //[MaxLength(256)]
        public string User { get; set; }

        //[Required]
        //[MaxLength(32)]
        public string FirstName { get; set; }

        //[MaxLength(32)]
        public string MiddleName { get; set; }

        //[Required]
        //[MaxLength(32)]
        public string LastName { get; set; }

        //[Required]
        //[MaxLength(32)]
        public string MainPhone { get; set; }

        //[MaxLength(32)]
        public string SecondPhone { get; set; }

        //[Required]
        public bool Contact { get; set; }

        //[Required]
        //[MaxLength(32)]
        public string Type { get; set; }

        public double LowestCapital { get; set; }

        public double HighestCapital { get; set; }

        public double SeekPrice { get; set; }

        //[MaxLength(32)]
        public string InvestmentType { get; set; }
    }
}
