using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;
using System.Linq;
using System.Threading.Tasks;

namespace Pipeline.Models
{
    [Table("ListingTags")]
    public class ListingTag
    {
        [Key]
        public Guid ID { get; set; }

        public string TagName { get; set; }
    }
}
