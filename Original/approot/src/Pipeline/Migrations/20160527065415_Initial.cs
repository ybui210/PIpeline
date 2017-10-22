using System;
using System.Collections.Generic;
using Microsoft.Data.Entity.Migrations;
using Microsoft.Data.Entity.Metadata;

namespace Pipeline.Migrations
{
    public partial class Initial : Migration
    {
        protected override void Up(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.CreateTable(
                name: "AspNetRoles",
                columns: table => new
                {
                    Id = table.Column<string>(nullable: false),
                    ConcurrencyStamp = table.Column<string>(nullable: true),
                    Name = table.Column<string>(nullable: true),
                    NormalizedName = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_IdentityRole", x => x.Id);
                });
            migrationBuilder.CreateTable(
                name: "AccountSettings",
                columns: table => new
                {
                    Email = table.Column<string>(nullable: false),
                    Purpose = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_AccountSetting", x => x.Email);
                });
            migrationBuilder.CreateTable(
                name: "IndustryCategories",
                columns: table => new
                {
                    ID = table.Column<int>(nullable: false)
                        .Annotation("SqlServer:ValueGenerationStrategy", SqlServerValueGenerationStrategy.IdentityColumn),
                    Category = table.Column<string>(nullable: true),
                    UserInput = table.Column<bool>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_IndustryCategory", x => x.ID);
                });
            migrationBuilder.CreateTable(
                name: "InvitationRequests",
                columns: table => new
                {
                    Email = table.Column<string>(nullable: false),
                    Approved = table.Column<bool>(nullable: false),
                    Code = table.Column<string>(nullable: true),
                    CodeUsed = table.Column<bool>(nullable: false),
                    DateApproved = table.Column<DateTime>(nullable: false),
                    DateRequested = table.Column<DateTime>(nullable: false),
                    Expiry = table.Column<DateTime>(nullable: false),
                    UserType = table.Column<string>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_InvitationRequest", x => x.Email);
                });
            migrationBuilder.CreateTable(
                name: "Locations",
                columns: table => new
                {
                    ID = table.Column<Guid>(nullable: false),
                    City = table.Column<string>(nullable: false),
                    Country = table.Column<string>(nullable: false),
                    StateProvince = table.Column<string>(nullable: false),
                    Street1 = table.Column<string>(nullable: false),
                    Street2 = table.Column<string>(nullable: true),
                    ZipPostal = table.Column<string>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_Location", x => x.ID);
                });
            migrationBuilder.CreateTable(
                name: "AspNetUsers",
                columns: table => new
                {
                    Id = table.Column<string>(nullable: false),
                    AccessFailedCount = table.Column<int>(nullable: false),
                    AccountStatus = table.Column<int>(nullable: false),
                    ConcurrencyStamp = table.Column<string>(nullable: true),
                    Email = table.Column<string>(nullable: true),
                    EmailConfirmed = table.Column<bool>(nullable: false),
                    LockoutEnabled = table.Column<bool>(nullable: false),
                    LockoutEnd = table.Column<DateTimeOffset>(nullable: true),
                    NormalizedEmail = table.Column<string>(nullable: true),
                    NormalizedUserName = table.Column<string>(nullable: true),
                    PasswordHash = table.Column<string>(nullable: true),
                    PhoneNumber = table.Column<string>(nullable: true),
                    PhoneNumberConfirmed = table.Column<bool>(nullable: false),
                    SecurityStamp = table.Column<string>(nullable: true),
                    TwoFactorEnabled = table.Column<bool>(nullable: false),
                    UserName = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_User", x => x.Id);
                });
            migrationBuilder.CreateTable(
                name: "AspNetRoleClaims",
                columns: table => new
                {
                    Id = table.Column<int>(nullable: false)
                        .Annotation("SqlServer:ValueGenerationStrategy", SqlServerValueGenerationStrategy.IdentityColumn),
                    ClaimType = table.Column<string>(nullable: true),
                    ClaimValue = table.Column<string>(nullable: true),
                    RoleId = table.Column<string>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_IdentityRoleClaim<string>", x => x.Id);
                    table.ForeignKey(
                        name: "FK_IdentityRoleClaim<string>_IdentityRole_RoleId",
                        column: x => x.RoleId,
                        principalTable: "AspNetRoles",
                        principalColumn: "Id",
                        onDelete: ReferentialAction.Cascade);
                });
            migrationBuilder.CreateTable(
                name: "UserIndustryPreferences",
                columns: table => new
                {
                    ID = table.Column<int>(nullable: false)
                        .Annotation("SqlServer:ValueGenerationStrategy", SqlServerValueGenerationStrategy.IdentityColumn),
                    IndustryCategoryID = table.Column<int>(nullable: true),
                    SettingsEmail = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_UserIndustryPreference", x => x.ID);
                    table.ForeignKey(
                        name: "FK_UserIndustryPreference_IndustryCategory_IndustryCategoryID",
                        column: x => x.IndustryCategoryID,
                        principalTable: "IndustryCategories",
                        principalColumn: "ID",
                        onDelete: ReferentialAction.Restrict);
                    table.ForeignKey(
                        name: "FK_UserIndustryPreference_AccountSetting_SettingsEmail",
                        column: x => x.SettingsEmail,
                        principalTable: "AccountSettings",
                        principalColumn: "Email",
                        onDelete: ReferentialAction.Restrict);
                });
            migrationBuilder.CreateTable(
                name: "ContactInformations",
                columns: table => new
                {
                    ID = table.Column<Guid>(nullable: false),
                    Email = table.Column<string>(nullable: false),
                    FirstName = table.Column<string>(nullable: true),
                    LastName = table.Column<string>(nullable: true),
                    LocationID = table.Column<Guid>(nullable: true),
                    MainPhone = table.Column<string>(nullable: true),
                    MiddleName = table.Column<string>(nullable: true),
                    SecondPhone = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_ContactInformation", x => x.ID);
                    table.ForeignKey(
                        name: "FK_ContactInformation_Location_LocationID",
                        column: x => x.LocationID,
                        principalTable: "Locations",
                        principalColumn: "ID",
                        onDelete: ReferentialAction.Restrict);
                });
            migrationBuilder.CreateTable(
                name: "AspNetUserClaims",
                columns: table => new
                {
                    Id = table.Column<int>(nullable: false)
                        .Annotation("SqlServer:ValueGenerationStrategy", SqlServerValueGenerationStrategy.IdentityColumn),
                    ClaimType = table.Column<string>(nullable: true),
                    ClaimValue = table.Column<string>(nullable: true),
                    UserId = table.Column<string>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_IdentityUserClaim<string>", x => x.Id);
                    table.ForeignKey(
                        name: "FK_IdentityUserClaim<string>_User_UserId",
                        column: x => x.UserId,
                        principalTable: "AspNetUsers",
                        principalColumn: "Id",
                        onDelete: ReferentialAction.Cascade);
                });
            migrationBuilder.CreateTable(
                name: "AspNetUserLogins",
                columns: table => new
                {
                    LoginProvider = table.Column<string>(nullable: false),
                    ProviderKey = table.Column<string>(nullable: false),
                    ProviderDisplayName = table.Column<string>(nullable: true),
                    UserId = table.Column<string>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_IdentityUserLogin<string>", x => new { x.LoginProvider, x.ProviderKey });
                    table.ForeignKey(
                        name: "FK_IdentityUserLogin<string>_User_UserId",
                        column: x => x.UserId,
                        principalTable: "AspNetUsers",
                        principalColumn: "Id",
                        onDelete: ReferentialAction.Cascade);
                });
            migrationBuilder.CreateTable(
                name: "AspNetUserRoles",
                columns: table => new
                {
                    UserId = table.Column<string>(nullable: false),
                    RoleId = table.Column<string>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_IdentityUserRole<string>", x => new { x.UserId, x.RoleId });
                    table.ForeignKey(
                        name: "FK_IdentityUserRole<string>_IdentityRole_RoleId",
                        column: x => x.RoleId,
                        principalTable: "AspNetRoles",
                        principalColumn: "Id",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_IdentityUserRole<string>_User_UserId",
                        column: x => x.UserId,
                        principalTable: "AspNetUsers",
                        principalColumn: "Id",
                        onDelete: ReferentialAction.Cascade);
                });
            migrationBuilder.CreateTable(
                name: "Listing",
                columns: table => new
                {
                    ID = table.Column<Guid>(nullable: false),
                    Category = table.Column<string>(nullable: false),
                    ContactID = table.Column<Guid>(nullable: false),
                    DatePosted = table.Column<DateTime>(nullable: false),
                    Description = table.Column<string>(nullable: false),
                    Discriminator = table.Column<string>(nullable: false),
                    Email = table.Column<string>(nullable: false),
                    EndingDate = table.Column<DateTime>(nullable: false),
                    Jurisdiction = table.Column<string>(nullable: false),
                    StartDate = table.Column<DateTime>(nullable: false),
                    Summary = table.Column<string>(nullable: false),
                    Title = table.Column<string>(nullable: false),
                    HighestCapital = table.Column<double>(nullable: true),
                    LowestCapital = table.Column<double>(nullable: true),
                    InvestmentType = table.Column<string>(nullable: true),
                    SeekingPrice = table.Column<double>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_Listing", x => x.ID);
                    table.ForeignKey(
                        name: "FK_Listing_ContactInformation_ContactID",
                        column: x => x.ContactID,
                        principalTable: "ContactInformations",
                        principalColumn: "ID",
                        onDelete: ReferentialAction.Cascade);
                });
            migrationBuilder.CreateTable(
                name: "Profiles",
                columns: table => new
                {
                    Email = table.Column<string>(nullable: false),
                    Avatar = table.Column<string>(nullable: true),
                    Bio = table.Column<string>(nullable: true),
                    ContactInfoID = table.Column<Guid>(nullable: false),
                    Discriminator = table.Column<string>(nullable: false),
                    LinkedinUrl = table.Column<string>(nullable: true),
                    Purpose = table.Column<string>(nullable: true),
                    UserId = table.Column<string>(nullable: true),
                    WebsiteUrl = table.Column<string>(nullable: true),
                    FirstName = table.Column<string>(nullable: true),
                    LastName = table.Column<string>(nullable: true),
                    MiddleName = table.Column<string>(nullable: true),
                    OrganizationName = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_Profile", x => x.Email);
                    table.ForeignKey(
                        name: "FK_Profile_ContactInformation_ContactInfoID",
                        column: x => x.ContactInfoID,
                        principalTable: "ContactInformations",
                        principalColumn: "ID",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_Profile_User_UserId",
                        column: x => x.UserId,
                        principalTable: "AspNetUsers",
                        principalColumn: "Id",
                        onDelete: ReferentialAction.Restrict);
                });
            migrationBuilder.CreateTable(
                name: "ListingImages",
                columns: table => new
                {
                    ID = table.Column<Guid>(nullable: false),
                    ListingID = table.Column<Guid>(nullable: true),
                    photo = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_ListingImage", x => x.ID);
                    table.ForeignKey(
                        name: "FK_ListingImage_Listing_ListingID",
                        column: x => x.ListingID,
                        principalTable: "Listing",
                        principalColumn: "ID",
                        onDelete: ReferentialAction.Restrict);
                });
            migrationBuilder.CreateTable(
                name: "ListingTags",
                columns: table => new
                {
                    ID = table.Column<Guid>(nullable: false),
                    ListingID = table.Column<Guid>(nullable: true),
                    TagName = table.Column<string>(nullable: true)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_ListingTag", x => x.ID);
                    table.ForeignKey(
                        name: "FK_ListingTag_Listing_ListingID",
                        column: x => x.ListingID,
                        principalTable: "Listing",
                        principalColumn: "ID",
                        onDelete: ReferentialAction.Restrict);
                });
            migrationBuilder.CreateTable(
                name: "SavedListings",
                columns: table => new
                {
                    UserId = table.Column<string>(nullable: false),
                    ListingId = table.Column<Guid>(nullable: false)
                },
                constraints: table =>
                {
                    table.PrimaryKey("PK_SavedListing", x => new { x.UserId, x.ListingId });
                    table.ForeignKey(
                        name: "FK_SavedListing_Listing_ListingId",
                        column: x => x.ListingId,
                        principalTable: "Listing",
                        principalColumn: "ID",
                        onDelete: ReferentialAction.Cascade);
                    table.ForeignKey(
                        name: "FK_SavedListing_User_UserId",
                        column: x => x.UserId,
                        principalTable: "AspNetUsers",
                        principalColumn: "Id",
                        onDelete: ReferentialAction.Cascade);
                });
            migrationBuilder.CreateIndex(
                name: "RoleNameIndex",
                table: "AspNetRoles",
                column: "NormalizedName");
            migrationBuilder.CreateIndex(
                name: "EmailIndex",
                table: "AspNetUsers",
                column: "NormalizedEmail");
            migrationBuilder.CreateIndex(
                name: "UserNameIndex",
                table: "AspNetUsers",
                column: "NormalizedUserName");
        }

        protected override void Down(MigrationBuilder migrationBuilder)
        {
            migrationBuilder.DropTable("AspNetRoleClaims");
            migrationBuilder.DropTable("AspNetUserClaims");
            migrationBuilder.DropTable("AspNetUserLogins");
            migrationBuilder.DropTable("AspNetUserRoles");
            migrationBuilder.DropTable("InvitationRequests");
            migrationBuilder.DropTable("ListingImages");
            migrationBuilder.DropTable("ListingTags");
            migrationBuilder.DropTable("Profiles");
            migrationBuilder.DropTable("SavedListings");
            migrationBuilder.DropTable("UserIndustryPreferences");
            migrationBuilder.DropTable("AspNetRoles");
            migrationBuilder.DropTable("Listing");
            migrationBuilder.DropTable("AspNetUsers");
            migrationBuilder.DropTable("IndustryCategories");
            migrationBuilder.DropTable("AccountSettings");
            migrationBuilder.DropTable("ContactInformations");
            migrationBuilder.DropTable("Locations");
        }
    }
}
