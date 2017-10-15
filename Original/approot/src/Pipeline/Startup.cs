using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;
using Microsoft.AspNet.Builder;
using Microsoft.AspNet.Hosting;
using Microsoft.AspNet.Http;
using Microsoft.Extensions.Configuration;
using Microsoft.Extensions.DependencyInjection;
using Microsoft.AspNet.Identity.EntityFramework;
using Microsoft.Data.Entity;
using Microsoft.Extensions.Logging;
using Pipeline.Models;
using Microsoft.AspNet.Authentication.Cookies;
using Microsoft.AspNet.Identity;
using System.Security.Claims;

namespace Pipeline
{
    public class Startup
    {
        public static IConfigurationRoot Configuration { get; set; }

        public Startup(IHostingEnvironment env)
        {
            // Set up configuration sources.

            var builder = new ConfigurationBuilder()
                .AddJsonFile("appsettings.json")
                .AddJsonFile($"appsettings.{env.EnvironmentName}.json", optional: true);

            builder.AddEnvironmentVariables();
            Configuration = builder.Build();
        }

        // This method gets called by the runtime. Use this method to add services to the container.
        // For more information on how to configure your application, visit http://go.microsoft.com/fwlink/?LinkID=398940
        public void ConfigureServices(IServiceCollection services)
        {
            services.AddEntityFramework()
                .AddSqlServer()
                .AddDbContext<PipelineDbContext>(options =>
                    options.UseSqlServer(Configuration["Data:DefaultConnection:ConnectionString"]));

            services.AddIdentity<User, IdentityRole>(options =>
            {
                // TODO: For development environment only
                options.Password.RequireDigit = false;
                options.Password.RequiredLength = 1;
                options.Password.RequireLowercase = false;
                options.Password.RequireNonLetterOrDigit = false;
                options.Password.RequireUppercase = false;
            })
                .AddEntityFrameworkStores<PipelineDbContext>()
                .AddDefaultTokenProviders();


            services.AddAuthorization(options =>
            {
                options.AddPolicy("Approve Projects",
                    policy => policy.RequireClaim("permission", "projects.approve"));
                options.AddPolicy("Approve Users",
                    policy => policy.RequireClaim("permission", "users.approve"));
            });

            services.AddMvc();
        }

        // This method gets called by the runtime. Use this method to configure the HTTP request pipeline.
        public void Configure(IApplicationBuilder app)
        {
            app.UseDefaultFiles();
            app.UseStaticFiles();
            app.UseIdentity();
            app.UseMvc();

            CreateRoles(app.ApplicationServices).Wait();

            CreateCategories(app.ApplicationServices).Wait();
            

        }

        public async Task CreateCategories(IServiceProvider applicationServices)
        {
            PipelineDbContext context = applicationServices.GetService<PipelineDbContext>();
            IndustryCategory ic;
            Array cats = Enum.GetValues(typeof(BusinessCategories));
            foreach(BusinessCategories s in cats)
            {
                if(await context.IndustryCategories.FirstOrDefaultAsync(i => i.Category.Equals( s.ToString() )) == null)
                {
                    ic = new IndustryCategory();
                    ic.Category = s.ToString();
                    ic.UserInput = false;
                    context.IndustryCategories.Add(ic);
                }
            }
            await context.SaveChangesAsync();
        }

        public async Task CreateRoles(IServiceProvider applicationServices)
        {

            // Create an admin user
            PipelineDbContext context = applicationServices.GetService<PipelineDbContext>();
            UserManager<User> userManager = applicationServices.GetService<UserManager<User>>();
            User admin = null;

            if ((admin = await userManager.FindByEmailAsync("admin@hashice.com")) != null)
            {
                context.Profiles.Remove(await context.Profiles.FirstAsync(x => x.Email.Equals("admin@hashice.com")));
                //context.AccountSettings.RemoveRange(await context.AccountSettings.FirstAsync(x => x.Email.Equals("admin@hashice.com")));
                context.ContactInformations.Remove(await context.ContactInformations.FirstAsync(x => x.Email.Equals("admin@hashice.com")));
                await context.SaveChangesAsync();
                await userManager.DeleteAsync(admin);
            }

            admin = new User
            {
                UserName = "admin@hashice.com",
                Email = "admin@hashice.com",
                AccountStatus = AccountStatus.Active,
                EmailConfirmed = true
            };

            ContactInformation adminContactInfo = new ContactInformation()
            {
                Email = admin.Email
            };

            IndividualProfile adminProfile = new IndividualProfile
            {
                FirstName = "Dennis",
                LastName = "Petke",
                Email = admin.Email,
                ContactInfo = adminContactInfo,
                Avatar = "/imgs/default_avatars/default_user_avatar.png"
            };

            //AccountSetting settings = new AccountSetting
            //{
            //};

            //context.AccountSettings.Add(settings);
            context.ContactInformations.Add(adminContactInfo);
            context.Profiles.Add(adminProfile);

            int results = -1;
            IdentityResult result = null;

            try
            {
                result = await userManager.CreateAsync(admin, "123");

                if (result != null)
                {
                    adminProfile.User = admin;
                    results = await context.SaveChangesAsync();
                }
            }
            catch (Exception ex)
            {
                ex.ToString();
            }

            // Create admin and user roles and add the previously created user to admin rol
            var roleManager = applicationServices.GetService<RoleManager<IdentityRole>>();

            var adminRole = await roleManager.FindByNameAsync(Roles.Admin.ToString());
            if (adminRole == null)
            {
                adminRole = new IdentityRole(Roles.Admin.ToString());
                await roleManager.CreateAsync(adminRole);

                await roleManager.AddClaimAsync(adminRole, new Claim("permission", "projects.approve"));
                await roleManager.AddClaimAsync(adminRole, new Claim("permission", "users.approve"));
            }

            // Add our admin user to Admin Roles
            if (admin != null && !await userManager.IsInRoleAsync(admin, adminRole.Name))
            {
                await userManager.AddToRoleAsync(admin, adminRole.Name);
            }

            var userRole = await roleManager.FindByNameAsync(Roles.Individual.ToString());

            if (userRole == null)
            {
                userRole = new IdentityRole(Roles.Individual.ToString());
                await roleManager.CreateAsync(userRole);
            }

            var orgRole = await roleManager.FindByNameAsync(Roles.Organization.ToString());

            if (orgRole == null)
            {
                orgRole = new IdentityRole(Roles.Organization.ToString());
                await roleManager.CreateAsync(orgRole);
            }
        }

        // Entry point for the application.
        public static void Main(string[] args) => WebApplication.Run<Startup>(args);
    }
}
