using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.Models
{
    public class AccountSetting
    {
        [Key]
        public string Email { get; set; }

        public virtual ICollection<UserIndustryPreference> IndustryPreferences { get; set; }

        public string Purpose { get; set; }
    }
}
