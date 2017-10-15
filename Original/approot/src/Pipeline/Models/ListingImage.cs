using System;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace Pipeline.Models
{
    [Table("ListingImages")]
    public class ListingImage
    {
        [Key]
        public Guid ID { get; set; }
        public string photo { get; set; }
    }
}
