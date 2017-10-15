using System;
using System.Net;
using System.Net.Mail;


namespace Pipeline.Helpers
{
    public class EmailHelper
    {
        private static EmailHelper instance;
        private readonly string SMTP_USERNAME = Startup.Configuration["Pipeline:Email:AWS_Username"];
        private readonly string SMTP_PASSWORD = Startup.Configuration["Pipeline:Email:AWS_Password"];
        private readonly string HOST = Startup.Configuration["Pipeline:Email:AWS_Host"];
        private readonly int PORT = Int32.Parse(Startup.Configuration["Pipeline:Email:AWS_Port"]);

        public bool sendMessage(string from, string to, string subject, string message)
        {
            using (System.Net.Mail.SmtpClient client = new System.Net.Mail.SmtpClient(HOST, PORT))
            {
                client.Credentials = new System.Net.NetworkCredential(SMTP_USERNAME, SMTP_PASSWORD);
                client.EnableSsl = true;

                try
                {
                    client.Send(from, to, subject, message);
                }
                catch (Exception ex)
                {
                    Console.WriteLine("The email was not sent.");
                    Console.WriteLine("Error message: " + ex.Message);
                    return false;
                }
            }
            return true;
        }

        public static EmailHelper Instance
        {
            get
            {
                if (instance == null)
                {
                    instance = new EmailHelper();
                }
                return instance;
            }
        }
    }
}
