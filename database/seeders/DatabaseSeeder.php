<?php

namespace Database\Seeders;

use id;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

         User::factory(3)->create();

         Listing::create([
            'title' => 'Senior PHP Developer', 
            'tags' => 'php, laravel, backend',
            'company' => 'Inwi Maroc',
            'location' => 'Casablanca, Morocco',
            'email' => 'recruitment@inwi.ma',
            'website' => 'https://www.inwi.ma',
            'description' => 'Inwi Maroc is seeking an experienced PHP Developer skilled in Laravel to join our team. Responsibilities include building and maintaining our web applications and collaborating with cross-functional teams to deliver the best solutions.',
            'user_id' => auth()->id(),
            'logo' => 'logos/inwi-logo.png' // Path to logo
        ]);
        
        Listing::create([
            'title' => 'Data Scientist',
            'tags' => 'data science, python, machine learning',
            'company' => 'OCP Group',
            'location' => 'Khouribga, Morocco',
            'email' => 'jobs@ocpgroup.ma',
            'website' => 'https://www.ocpgroup.ma',
            'description' => 'OCP Group, a leading global fertilizer producer, is looking for a Data Scientist to analyze agricultural data and drive data-based decisions. Join us in making an impact in sustainable agriculture through cutting-edge data solutions.',
            'user_id' => auth()->id(),
            'logo' => 'logos/ocp-logo.png' // Path to logo
        ]);
        
        Listing::create([
            'title' => 'Front-End Developer',
            'tags' => 'javascript, react, frontend',
            'company' => 'Maroc Telecom',
            'location' => 'Rabat, Morocco',
            'email' => 'careers@maroctelecom.ma',
            'website' => 'https://www.iam.ma',
            'description' => 'Maroc Telecom is looking for a skilled Front-End Developer with expertise in JavaScript and React. This role involves developing user interfaces that improve customer experience for millions of users in Morocco.',
            'user_id' => auth()->id(),
            'logo' => 'logos/maroc-telecom-logo.png' // Path to logo
        ]);
        
        Listing::create([
            'title' => 'Cloud Engineer',
            'tags' => 'cloud, devops, aws',
            'company' => 'Attijariwafa Bank',
            'location' => 'Casablanca, Morocco',
            'email' => 'hr@attijariwafabank.com',
            'website' => 'https://www.attijariwafabank.com',
            'description' => 'Attijariwafa Bank seeks a Cloud Engineer to join our DevOps team. The ideal candidate will have experience with AWS and cloud infrastructure to support our digital banking initiatives.',
            'user_id' => auth()->id(),
            'logo' => 'logos/attijariwafa-logo.png' // Path to logo
        ]);
        
        Listing::create([
            'title' => 'UX/UI Designer',
            'tags' => 'ux, ui, design, figma',
            'company' => 'HPS',
            'location' => 'Casablanca, Morocco',
            'email' => 'recruit@hps-worldwide.com',
            'website' => 'https://www.hps-worldwide.com',
            'description' => 'HPS is recruiting a UX/UI Designer to enhance the usability of our digital payment solutions. If you have a passion for design and experience in Figma, join us to help shape the future of fintech in Morocco.',
            'user_id' => auth()->id(),
            'logo' => 'logos/hps-logo.png' // Path to logo
        ]);
        
        Listing::create([
            'title' => 'Marketing Specialist', 
            'tags' => 'marketing, digital marketing, seo',
            'company' => 'Cosumar',
            'location' => 'Casablanca, Morocco',
            'email' => 'hr@cosumar.co.ma',
            'website' => 'https://www.cosumar.co.ma',
            'description' => 'Cosumar is looking for a Marketing Specialist to lead digital campaigns and improve our SEO strategy. Join us in promoting Morocco\'s leading sugar producer with innovative marketing approaches.',
            'user_id' => auth()->id(),
            'logo' => 'logos/cosumar-logo.png' // Path to logo
        ]);
        
        Listing::create([
            'title' => 'Supply Chain Analyst',
            'tags' => 'supply chain, logistics, data analysis',
            'company' => 'Yazaki Morocco',
            'location' => 'Tangier, Morocco',
            'email' => 'recruitment@yazaki.ma',
            'website' => 'https://www.yazaki-group.com',
            'description' => 'Yazaki Morocco is hiring a Supply Chain Analyst to optimize logistics and support our automotive manufacturing operations. This role requires strong analytical skills to enhance our supply chain efficiency.',
            'user_id' => auth()->id(),
            'logo' => 'logos/yazaki-logo.png' // Path to logo
        ]);
        
        Listing::create([
            'title' => 'Project Manager',
            'tags' => 'project management, pmp, construction',
            'company' => 'LafargeHolcim Maroc',
            'location' => 'Casablanca, Morocco',
            'email' => 'careers@lafargeholcim.ma',
            'website' => 'https://www.lafargeholcim.ma',
            'description' => 'LafargeHolcim Maroc is looking for an experienced Project Manager with a background in construction. You will oversee large-scale building projects and ensure compliance with project timelines and budgets.',
            'user_id' => auth()->id(),
            'logo' => 'logos/lafargeholcim-logo.png' // Path to logo
        ]);
        
        Listing::create([
            'title' => 'Software Engineer',
            'tags' => 'java, spring boot, microservices',
            'company' => 'CGI Maroc',
            'location' => 'Rabat, Morocco',
            'email' => 'jobs@cgi.com',
            'website' => 'https://www.cgi.com/maroc',
            'description' => 'CGI Maroc is seeking a skilled Software Engineer to develop and maintain enterprise applications. Candidates with expertise in Java and Spring Boot are encouraged to apply.',
            'user_id' => auth()->id(),
            'logo' => 'logos/cgi-logo.png' // Path to logo
        ]);
        
        Listing::create([
            'title' => 'Customer Support Specialist',
            'tags' => 'customer service, support, bilingual',
            'company' => 'AXA Assurance Maroc',
            'location' => 'Casablanca, Morocco',
            'email' => 'support@axa.ma',
            'website' => 'https://www.axa.ma',
            'description' => 'AXA Assurance Maroc is hiring a Customer Support Specialist fluent in French and Arabic to assist clients with insurance inquiries. The role involves providing excellent customer service and problem resolution.',
            'user_id' => auth()->id(),
            'logo' => 'logos/axa-logo.png' // Path to logo
        ]);
        
  
    }
}
