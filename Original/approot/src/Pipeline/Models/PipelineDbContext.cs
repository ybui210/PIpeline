using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.Data.Entity;
using Microsoft.AspNet.Identity.EntityFramework;
using Microsoft.Extensions.Configuration;
using Microsoft.AspNet.Builder;

namespace Pipeline.Models
{
    public class PipelineDbContext : IdentityDbContext<User>
    {
        public DbSet<Profile> Profiles { get; set; }
        public DbSet<AccountSetting> AccountSettings { get; set; }
        public DbSet<InvitationRequest> InvitationRequests { get; set; }
        public DbSet<ListingImage> ListingImages { get; set; }
        public DbSet<Listing> Listings { get; set; }
        public DbSet<ContactInformation> ContactInformations { get; set; }
        public DbSet<IndustryCategory> IndustryCategories { get; set; }
        public DbSet<Location> Locations { get; set; }
        public DbSet<UserIndustryPreference> UserIndustryPreferences { get; set; }
        public DbSet<SavedListing> SavedListings { get; set; }

        protected override void OnModelCreating(ModelBuilder builder)
        {
            builder.Entity<InvitationRequest>().ToTable("InvitationRequests");
            builder.Entity<AccountSetting>().ToTable("AccountSettings");
            builder.Entity<ContactInformation>().ToTable("ContactInformations");
            builder.Entity<IndustryCategory>().ToTable("IndustryCategories");
            builder.Entity<Location>().ToTable("Locations");
            builder.Entity<UserIndustryPreference>().ToTable("UserIndustryPreferences");
            builder.Entity<SavedListing>().ToTable("SavedListings");

            builder.Entity<IndividualProfile>().ToTable("IndividualProfiles");
            builder.Entity<OrganizationProfile>().ToTable("OrganizationProfiles");

            builder.Entity<ListingInvestment>().ToTable("ListingInvestments");
            builder.Entity<ListingFinance>().ToTable("ListingFinances");
            builder.Entity<ListingImage>().ToTable("ListingImages");

            builder.Entity<SavedListing>().HasKey(s => new { s.UserId, s.ListingId });

            base.OnModelCreating(builder);
        }

        protected override void OnConfiguring(DbContextOptionsBuilder optionsBuilder)
        {
            optionsBuilder.UseSqlServer(Startup.Configuration["Data:DefaultConnection:ConnectionString"]);
        }
    }
}
