using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.Models
{
    public class OrganizationProfile : Profile
    {
        [DefaultValue("")]
        [MaxLength(64)]
        public string OrganizationName { get; set; }
    }
}
