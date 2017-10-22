using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.Models
{
    public class UserIndustryPreference
    {
        [Key]
        public int ID { get; set; }

        public AccountSetting Settings { get; set; }

        public IndustryCategory IndustryCategory { get; set; }
    }
}
