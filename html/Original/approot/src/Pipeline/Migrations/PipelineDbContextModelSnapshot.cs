using System;
using Microsoft.Data.Entity;
using Microsoft.Data.Entity.Infrastructure;
using Microsoft.Data.Entity.Metadata;
using Microsoft.Data.Entity.Migrations;
using Pipeline.Models;

namespace Pipeline.Migrations
{
    [DbContext(typeof(PipelineDbContext))]
    partial class PipelineDbContextModelSnapshot : ModelSnapshot
    {
        protected override void BuildModel(ModelBuilder modelBuilder)
        {
            modelBuilder
                .HasAnnotation("ProductVersion", "7.0.0-rc1-16348")
                .HasAnnotation("SqlServer:ValueGenerationStrategy", SqlServerValueGenerationStrategy.IdentityColumn);

            modelBuilder.Entity("Microsoft.AspNet.Identity.EntityFramework.IdentityRole", b =>
                {
                    b.Property<string>("Id");

                    b.Property<string>("ConcurrencyStamp")
                        .IsConcurrencyToken();

                    b.Property<string>("Name")
                        .HasAnnotation("MaxLength", 256);

                    b.Property<string>("NormalizedName")
                        .HasAnnotation("MaxLength", 256);

                    b.HasKey("Id");

                    b.HasIndex("NormalizedName")
                        .HasAnnotation("Relational:Name", "RoleNameIndex");

                    b.HasAnnotation("Relational:TableName", "AspNetRoles");
                });

            modelBuilder.Entity("Microsoft.AspNet.Identity.EntityFramework.IdentityRoleClaim<string>", b =>
                {
                    b.Property<int>("Id")
                        .ValueGeneratedOnAdd();

                    b.Property<string>("ClaimType");

                    b.Property<string>("ClaimValue");

                    b.Property<string>("RoleId")
                        .IsRequired();

                    b.HasKey("Id");

                    b.HasAnnotation("Relational:TableName", "AspNetRoleClaims");
                });

            modelBuilder.Entity("Microsoft.AspNet.Identity.EntityFramework.IdentityUserClaim<string>", b =>
                {
                    b.Property<int>("Id")
                        .ValueGeneratedOnAdd();

                    b.Property<string>("ClaimType");

                    b.Property<string>("ClaimValue");

                    b.Property<string>("UserId")
                        .IsRequired();

                    b.HasKey("Id");

                    b.HasAnnotation("Relational:TableName", "AspNetUserClaims");
                });

            modelBuilder.Entity("Microsoft.AspNet.Identity.EntityFramework.IdentityUserLogin<string>", b =>
                {
                    b.Property<string>("LoginProvider");

                    b.Property<string>("ProviderKey");

                    b.Property<string>("ProviderDisplayName");

                    b.Property<string>("UserId")
                        .IsRequired();

                    b.HasKey("LoginProvider", "ProviderKey");

                    b.HasAnnotation("Relational:TableName", "AspNetUserLogins");
                });

            modelBuilder.Entity("Microsoft.AspNet.Identity.EntityFramework.IdentityUserRole<string>", b =>
                {
                    b.Property<string>("UserId");

                    b.Property<string>("RoleId");

                    b.HasKey("UserId", "RoleId");

                    b.HasAnnotation("Relational:TableName", "AspNetUserRoles");
                });

            modelBuilder.Entity("Pipeline.Models.AccountSetting", b =>
                {
                    b.Property<string>("Email");

                    b.Property<string>("Purpose");

                    b.HasKey("Email");

                    b.HasAnnotation("Relational:TableName", "AccountSettings");
                });

            modelBuilder.Entity("Pipeline.Models.ContactInformation", b =>
                {
                    b.Property<Guid>("ID")
                        .ValueGeneratedOnAdd();

                    b.Property<string>("Email")
                        .IsRequired()
                        .HasAnnotation("MaxLength", 256);

                    b.Property<string>("FirstName")
                        .HasAnnotation("MaxLength", 32);

                    b.Property<string>("LastName")
                        .HasAnnotation("MaxLength", 32);

                    b.Property<Guid?>("LocationID");

                    b.Property<string>("MainPhone")
                        .HasAnnotation("MaxLength", 16);

                    b.Property<string>("MiddleName")
                        .HasAnnotation("MaxLength", 32);

                    b.Property<string>("SecondPhone")
                        .HasAnnotation("MaxLength", 16);

                    b.HasKey("ID");

                    b.HasAnnotation("Relational:TableName", "ContactInformations");
                });

            modelBuilder.Entity("Pipeline.Models.IndustryCategory", b =>
                {
                    b.Property<int>("ID")
                        .ValueGeneratedOnAdd();

                    b.Property<string>("Category");

                    b.Property<bool>("UserInput");

                    b.HasKey("ID");

                    b.HasAnnotation("Relational:TableName", "IndustryCategories");
                });

            modelBuilder.Entity("Pipeline.Models.InvitationRequest", b =>
                {
                    b.Property<string>("Email")
                        .HasAnnotation("MaxLength", 256);

                    b.Property<bool>("Approved");

                    b.Property<string>("Code")
                        .HasAnnotation("MaxLength", 8);

                    b.Property<bool>("CodeUsed");

                    b.Property<DateTime>("DateApproved");

                    b.Property<DateTime>("DateRequested");

                    b.Property<DateTime>("Expiry");

                    b.Property<string>("UserType")
                        .IsRequired();

                    b.HasKey("Email");

                    b.HasAnnotation("Relational:TableName", "InvitationRequests");
                });

            modelBuilder.Entity("Pipeline.Models.Listing", b =>
                {
                    b.Property<Guid>("ID")
                        .ValueGeneratedOnAdd();

                    b.Property<string>("Category")
                        .IsRequired()
                        .HasAnnotation("MaxLength", 64);

                    b.Property<Guid?>("ContactID")
                        .IsRequired();

                    b.Property<DateTime>("DatePosted");

                    b.Property<string>("Description")
                        .IsRequired();

                    b.Property<string>("Discriminator")
                        .IsRequired();

                    b.Property<string>("Email")
                        .IsRequired()
                        .HasAnnotation("MaxLength", 256);

                    b.Property<DateTime>("EndingDate");

                    b.Property<string>("Jurisdiction")
                        .IsRequired()
                        .HasAnnotation("MaxLength", 64);

                    b.Property<DateTime>("StartDate");

                    b.Property<string>("Summary")
                        .IsRequired()
                        .HasAnnotation("MaxLength", 1024);

                    b.Property<string>("Title")
                        .IsRequired()
                        .HasAnnotation("MaxLength", 64);

                    b.HasKey("ID");

                    b.HasAnnotation("Relational:DiscriminatorProperty", "Discriminator");

                    b.HasAnnotation("Relational:DiscriminatorValue", "Listing");
                });

            modelBuilder.Entity("Pipeline.Models.ListingImage", b =>
                {
                    b.Property<Guid>("ID")
                        .ValueGeneratedOnAdd();

                    b.Property<Guid?>("ListingID");

                    b.Property<string>("photo");

                    b.HasKey("ID");

                    b.HasAnnotation("Relational:TableName", "ListingImages");
                });

            modelBuilder.Entity("Pipeline.Models.ListingTag", b =>
                {
                    b.Property<Guid>("ID")
                        .ValueGeneratedOnAdd();

                    b.Property<Guid?>("ListingID");

                    b.Property<string>("TagName");

                    b.HasKey("ID");

                    b.HasAnnotation("Relational:TableName", "ListingTags");
                });

            modelBuilder.Entity("Pipeline.Models.Location", b =>
                {
                    b.Property<Guid>("ID")
                        .ValueGeneratedOnAdd();

                    b.Property<string>("City")
                        .IsRequired()
                        .HasAnnotation("MaxLength", 32);

                    b.Property<string>("Country")
                        .IsRequired()
                        .HasAnnotation("MaxLength", 16);

                    b.Property<string>("StateProvince")
                        .IsRequired()
                        .HasAnnotation("MaxLength", 16);

                    b.Property<string>("Street1")
                        .IsRequired()
                        .HasAnnotation("MaxLength", 64);

                    b.Property<string>("Street2")
                        .HasAnnotation("MaxLength", 64);

                    b.Property<string>("ZipPostal")
                        .IsRequired()
                        .HasAnnotation("MaxLength", 8);

                    b.HasKey("ID");

                    b.HasAnnotation("Relational:TableName", "Locations");
                });

            modelBuilder.Entity("Pipeline.Models.Profile", b =>
                {
                    b.Property<string>("Email")
                        .HasAnnotation("MaxLength", 256);

                    b.Property<string>("Avatar")
                        .HasAnnotation("MaxLength", 64);

                    b.Property<string>("Bio")
                        .HasAnnotation("MaxLength", 256);

                    b.Property<Guid?>("ContactInfoID")
                        .IsRequired();

                    b.Property<string>("Discriminator")
                        .IsRequired();

                    b.Property<string>("LinkedinUrl")
                        .HasAnnotation("MaxLength", 64);

                    b.Property<string>("Purpose");

                    b.Property<string>("UserId");

                    b.Property<string>("WebsiteUrl")
                        .HasAnnotation("MaxLength", 64);

                    b.HasKey("Email");

                    b.HasAnnotation("Relational:DiscriminatorProperty", "Discriminator");

                    b.HasAnnotation("Relational:DiscriminatorValue", "Profile");

                    b.HasAnnotation("Relational:TableName", "Profiles");
                });

            modelBuilder.Entity("Pipeline.Models.SavedListing", b =>
                {
                    b.Property<string>("UserId");

                    b.Property<Guid>("ListingId");

                    b.HasKey("UserId", "ListingId");

                    b.HasAnnotation("Relational:TableName", "SavedListings");
                });

            modelBuilder.Entity("Pipeline.Models.User", b =>
                {
                    b.Property<string>("Id");

                    b.Property<int>("AccessFailedCount");

                    b.Property<int>("AccountStatus");

                    b.Property<string>("ConcurrencyStamp")
                        .IsConcurrencyToken();

                    b.Property<string>("Email")
                        .HasAnnotation("MaxLength", 256);

                    b.Property<bool>("EmailConfirmed");

                    b.Property<bool>("LockoutEnabled");

                    b.Property<DateTimeOffset?>("LockoutEnd");

                    b.Property<string>("NormalizedEmail")
                        .HasAnnotation("MaxLength", 256);

                    b.Property<string>("NormalizedUserName")
                        .HasAnnotation("MaxLength", 256);

                    b.Property<string>("PasswordHash");

                    b.Property<string>("PhoneNumber");

                    b.Property<bool>("PhoneNumberConfirmed");

                    b.Property<string>("SecurityStamp");

                    b.Property<bool>("TwoFactorEnabled");

                    b.Property<string>("UserName")
                        .HasAnnotation("MaxLength", 256);

                    b.HasKey("Id");

                    b.HasIndex("NormalizedEmail")
                        .HasAnnotation("Relational:Name", "EmailIndex");

                    b.HasIndex("NormalizedUserName")
                        .HasAnnotation("Relational:Name", "UserNameIndex");

                    b.HasAnnotation("Relational:TableName", "AspNetUsers");
                });

            modelBuilder.Entity("Pipeline.Models.UserIndustryPreference", b =>
                {
                    b.Property<int>("ID")
                        .ValueGeneratedOnAdd();

                    b.Property<int?>("IndustryCategoryID");

                    b.Property<string>("SettingsEmail");

                    b.HasKey("ID");

                    b.HasAnnotation("Relational:TableName", "UserIndustryPreferences");
                });

            modelBuilder.Entity("Pipeline.Models.ListingFinance", b =>
                {
                    b.HasBaseType("Pipeline.Models.Listing");

                    b.Property<double>("HighestCapital");

                    b.Property<double>("LowestCapital");

                    b.HasAnnotation("Relational:DiscriminatorValue", "ListingFinance");

                    b.HasAnnotation("Relational:TableName", "ListingFinances");
                });

            modelBuilder.Entity("Pipeline.Models.ListingInvestment", b =>
                {
                    b.HasBaseType("Pipeline.Models.Listing");

                    b.Property<string>("InvestmentType")
                        .IsRequired()
                        .HasAnnotation("MaxLength", 32);

                    b.Property<double>("SeekingPrice");

                    b.HasAnnotation("Relational:DiscriminatorValue", "ListingInvestment");

                    b.HasAnnotation("Relational:TableName", "ListingInvestments");
                });

            modelBuilder.Entity("Pipeline.Models.IndividualProfile", b =>
                {
                    b.HasBaseType("Pipeline.Models.Profile");

                    b.Property<string>("FirstName")
                        .HasAnnotation("MaxLength", 32);

                    b.Property<string>("LastName")
                        .HasAnnotation("MaxLength", 32);

                    b.Property<string>("MiddleName")
                        .HasAnnotation("MaxLength", 32);

                    b.HasAnnotation("Relational:DiscriminatorValue", "IndividualProfile");

                    b.HasAnnotation("Relational:TableName", "IndividualProfiles");
                });

            modelBuilder.Entity("Pipeline.Models.OrganizationProfile", b =>
                {
                    b.HasBaseType("Pipeline.Models.Profile");

                    b.Property<string>("OrganizationName")
                        .HasAnnotation("MaxLength", 64);

                    b.HasAnnotation("Relational:DiscriminatorValue", "OrganizationProfile");

                    b.HasAnnotation("Relational:TableName", "OrganizationProfiles");
                });

            modelBuilder.Entity("Microsoft.AspNet.Identity.EntityFramework.IdentityRoleClaim<string>", b =>
                {
                    b.HasOne("Microsoft.AspNet.Identity.EntityFramework.IdentityRole")
                        .WithMany()
                        .HasForeignKey("RoleId");
                });

            modelBuilder.Entity("Microsoft.AspNet.Identity.EntityFramework.IdentityUserClaim<string>", b =>
                {
                    b.HasOne("Pipeline.Models.User")
                        .WithMany()
                        .HasForeignKey("UserId");
                });

            modelBuilder.Entity("Microsoft.AspNet.Identity.EntityFramework.IdentityUserLogin<string>", b =>
                {
                    b.HasOne("Pipeline.Models.User")
                        .WithMany()
                        .HasForeignKey("UserId");
                });

            modelBuilder.Entity("Microsoft.AspNet.Identity.EntityFramework.IdentityUserRole<string>", b =>
                {
                    b.HasOne("Microsoft.AspNet.Identity.EntityFramework.IdentityRole")
                        .WithMany()
                        .HasForeignKey("RoleId");

                    b.HasOne("Pipeline.Models.User")
                        .WithMany()
                        .HasForeignKey("UserId");
                });

            modelBuilder.Entity("Pipeline.Models.ContactInformation", b =>
                {
                    b.HasOne("Pipeline.Models.Location")
                        .WithMany()
                        .HasForeignKey("LocationID");
                });

            modelBuilder.Entity("Pipeline.Models.Listing", b =>
                {
                    b.HasOne("Pipeline.Models.ContactInformation")
                        .WithMany()
                        .HasForeignKey("ContactID");
                });

            modelBuilder.Entity("Pipeline.Models.ListingImage", b =>
                {
                    b.HasOne("Pipeline.Models.Listing")
                        .WithMany()
                        .HasForeignKey("ListingID");
                });

            modelBuilder.Entity("Pipeline.Models.ListingTag", b =>
                {
                    b.HasOne("Pipeline.Models.Listing")
                        .WithMany()
                        .HasForeignKey("ListingID");
                });

            modelBuilder.Entity("Pipeline.Models.Profile", b =>
                {
                    b.HasOne("Pipeline.Models.ContactInformation")
                        .WithMany()
                        .HasForeignKey("ContactInfoID");

                    b.HasOne("Pipeline.Models.User")
                        .WithMany()
                        .HasForeignKey("UserId");
                });

            modelBuilder.Entity("Pipeline.Models.SavedListing", b =>
                {
                    b.HasOne("Pipeline.Models.Listing")
                        .WithMany()
                        .HasForeignKey("ListingId");

                    b.HasOne("Pipeline.Models.User")
                        .WithMany()
                        .HasForeignKey("UserId");
                });

            modelBuilder.Entity("Pipeline.Models.UserIndustryPreference", b =>
                {
                    b.HasOne("Pipeline.Models.IndustryCategory")
                        .WithMany()
                        .HasForeignKey("IndustryCategoryID");

                    b.HasOne("Pipeline.Models.AccountSetting")
                        .WithMany()
                        .HasForeignKey("SettingsEmail");
                });

            modelBuilder.Entity("Pipeline.Models.ListingFinance", b =>
                {
                });

            modelBuilder.Entity("Pipeline.Models.ListingInvestment", b =>
                {
                });

            modelBuilder.Entity("Pipeline.Models.IndividualProfile", b =>
                {
                });

            modelBuilder.Entity("Pipeline.Models.OrganizationProfile", b =>
                {
                });
        }
    }
}
