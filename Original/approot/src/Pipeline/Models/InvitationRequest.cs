using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.Models
{
    public class InvitationRequest
    {
        [Key]
        [MaxLength(256)]
        public string Email { get; set; }

        [DefaultValue("")]
        [MaxLength(8)]
        public string Code { get; set; }

        [Required]
        [DisplayFormat(ApplyFormatInEditMode = true, DataFormatString = "{0:G}")]
        public DateTime DateRequested { get; set; }

        [Required]
        [DisplayFormat(ApplyFormatInEditMode = true, DataFormatString = "{0:G}")]
        public DateTime DateApproved { get; set; }

        [Required]
        [DisplayFormat(ApplyFormatInEditMode = true, DataFormatString = "{0:G}")]
        public DateTime Expiry { get; set; }

        [Required]
        [DefaultValue(false)]
        public bool CodeUsed { get; set; }

        [Required]
        public string UserType { get; set; }

        [DefaultValue(false)]
        public bool Approved { get; set; }
    }
}
