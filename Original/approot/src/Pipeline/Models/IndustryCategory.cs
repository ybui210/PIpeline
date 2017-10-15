using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.Models
{
    public class IndustryCategory
    {
        [Key]
        public int ID { get; set; }

        public string Category { get; set; }

        public bool UserInput { get; set; }
    }

    public enum BusinessCategories
    {
        Agriculture = 1,
        BusinessDevelopment = 2,
        Electricity = 3,
        Energy = 4,
        Franchise = 5,
        Forestry = 6,
        Gas = 7, 
        Medicine = 8,
        Mining = 9,
        Oil = 10,
        PropertyDevelopment = 11,
        Research = 12,
        Technology = 13,
       

    }
}
