using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.Models
{
    public class IndividualProfile : Profile
    {
        [DefaultValue("")]
        [MaxLength(32)]
        public string FirstName { get; set; }

        [DefaultValue("")]
        [MaxLength(32)]
        public string LastName { get; set; }

        [DefaultValue("")]
        [MaxLength(32)]
        public string MiddleName { get; set; }
    }
}
