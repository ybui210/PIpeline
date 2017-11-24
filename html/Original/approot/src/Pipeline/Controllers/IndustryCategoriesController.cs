using System.Collections.Generic;
using System.Linq;
using Microsoft.AspNet.Http;
using Microsoft.AspNet.Mvc;
using Microsoft.Data.Entity;
using Pipeline.Models;
using Microsoft.AspNet.Authorization;
using System;
using System.Threading.Tasks;

namespace Pipeline.Controllers
{
    [Authorize]
    [Produces("application/json")]
    [Route("/IndustryCategories")]
    public class IndustryCategoriesController : Controller
    {
        private PipelineDbContext _context;

        public IndustryCategoriesController(PipelineDbContext context)
        {
            _context = context;
        }

        // GET: /IndustryCategories/GetIndustryCategorys
        [AllowAnonymous]
        [HttpGet("All")]
        public IEnumerable<IndustryCategory> All()
        {
            return _context.IndustryCategories;
        }

        [AllowAnonymous]
        [HttpGet("GetMaxID")]
        public async Task<IActionResult> GetMaxID()
        {
            var max = await _context.IndustryCategories.MaxAsync(p => p.ID);
            return Json(new
            {
                Succeeded = true,
                Max = max
            });
        }

        [AllowAnonymous]
        [HttpPost("AppendNewCategory")]
        public async Task<IActionResult> AddCategory(string category)
        {
            var count = _context.IndustryCategories.Max(p => p.ID);
            try
            {
                IndustryCategory ic = new IndustryCategory()
                {
                    Category = category,
                    UserInput = true
                };
                _context.IndustryCategories.Add(ic);
                await _context.SaveChangesAsync();      
            }
            catch (Exception e)
            {
                return Json(new
                {
                    Succeeded = false,
                    Errors = new object[] { new { Description = "Internal server error." } }
                });
            }
            return Json(new
            {
                Succeeded = true,
                Message = new object[] { new { Description = "Category added to database." } }
            });
        }
    }

}