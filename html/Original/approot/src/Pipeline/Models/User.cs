using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.Linq;
using System.Threading.Tasks;
using System.ComponentModel.DataAnnotations.Schema;
using Microsoft.AspNet.Identity.EntityFramework;


namespace Pipeline.Models
{
    [Table("Users")]
    public class User : IdentityUser
    {
        [Required]
        public AccountStatus AccountStatus { get; set; }
    }

    public enum AccountStatus
    {
        Pending,
        Approved,
        Active,
        Suspended,
        Disabled
    }

    public enum Roles
    {
        Admin,
        Individual,
        Organization
    }
}
