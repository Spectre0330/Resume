<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillGroup;
use Illuminate\Database\Seeder;

class ResumeSeeder extends Seeder
{
    /**
     * Seed the resume content.
     */
    public function run(): void
    {
        Profile::query()->create([
            'name' => 'Brandon Henry',
            'headline' => 'Software Developer · B.A. Computer Science, Washington State University',
            'bio' => "I'm a software developer who likes hard problems and building practical solutions to them. At Art Culinaire, I build integrations and internal tools on top of the business applications the company relies on every day, connecting Zoho CRM, Books, and Desk with systems like RingCentral, AvaTax, and WooCommerce. I build automations that help my coworkers work faster and make fewer errors, and I care about writing clean, maintainable code that people actually use. This role has shown me that almost any problem can be solved with code once I've learned the right tools, and I'm always keen to learn new ones.",
            'email' => 'extreme0330@gmail.com',
            'location' => 'Snohomish, WA',
            'phone' => '425-870-0875',
            'show_phone' => false,
            'github_url' => 'https://github.com/BrandonHenry0330/BrandonHenry-Projects',
            'linkedin_url' => 'https://linkedin.com/in/brandon-henry-7ab4a1223',
        ]);

        collect([
            [
                'company' => 'Art Culinaire',
                'role' => 'Junior Software Developer',
                'location' => 'Snohomish, WA',
                'started_on' => '2024-07-31',
                'ended_on' => null,
                'bullets' => [
                    "Built a Laravel order-processing automation that does about 1.5 people's worth of order work, so the company runs on one order processor instead of two. When a customer pays a deposit, it checks the estimate against the line items the range's 3D configurator specifies, flags discrepancies to sales and order processing, and creates the Sales Order and Purchase Order. In its first 4–5 months it caught missing line items worth thousands of dollars.",
                    "Built a Laravel audit tool after finance found unauthorized AvaTax reseller certificates on Zoho Books records, which Zoho's activity log couldn't trace to a user. The tool processes Zoho Books webhooks for estimates, sales orders, invoices and customers, detects when the certificate field changes, and attributes each change to the employee who made it.",
                    "Built a JavaScript widget embedded in Zoho Desk that pulls a customer's Lacanche range details from Zoho CRM. After the company moved support from email to Zoho Desk, staff no longer had to switch platforms on every ticket. I refined the widget based on support staff feedback until the whole team was using it every day; it's now faster for them than opening CRM directly.",
                    'Adopted AI-assisted development with Claude Code to design, build, and test internal tools faster, reviewing and testing all generated code before deployment.',
                ],
            ],
            [
                'company' => 'Art Culinaire',
                'role' => 'IT Intern',
                'location' => 'Snohomish, WA',
                'started_on' => '2024-05-13',
                'ended_on' => '2024-07-31',
                'bullets' => [
                    "Replaced the paper quality-control process with a Zoho Creator app written in Deluge. It guides QC technicians through each range inspection step by step and shows or hides steps based on the range's configuration. The app is still in daily use and still getting new features.",
                    "Integrated the app with Zoho CRM. Inspection photos, files and notes attach automatically to each range's CRM record, and failed checks trigger an email alert, so problems are caught more consistently.",
                    "Built per-inspection time tracking. Its data showed actual QC throughput was about half of management's estimate (~1 range per technician per day, not 2), which gave management real numbers for scheduling and planning.",
                ],
            ],
            [
                'company' => 'Art Culinaire',
                'role' => 'IT Intern',
                'location' => 'Snohomish, WA',
                'started_on' => '2023-05-01',
                'ended_on' => '2023-08-05',
                'bullets' => [
                    "Built a Laravel and Livewire app that uses the RingCentral SDK and API to archive the previous day's calls and analytics every day, keeping call history past RingCentral's 6-month limit. It is still running and still maintained.",
                    'Made the archive searchable by everyone in the company. Management uses it for call analytics, and sales and support staff use it to check call history when a customer disputes whether a call happened.',
                ],
            ],
        ])->each(fn (array $experience, int $index) => Experience::query()->create([...$experience, 'sort_order' => $index + 1]));

        collect([
            [
                'title' => 'Order Processing Automation',
                'description' => "Two order processing staff used to handle every order by hand. After both left, I built a Laravel service so one new hire could cover the work. When a retainer invoice is paid, it works out which line items the range's configuration requires (from the configuration link on the estimate) and checks the estimate against that list. If anything is missing or wrong it emails the salesperson and order processing, then it generates the Sales Order and Purchase Order. It does about 1.5 people's worth of order work, and in its first months it caught missing line items worth thousands of dollars.",
                'tech' => ['PHP', 'Laravel', 'Zoho Books API', 'Webhooks'],
                'repo_url' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'Reseller Certificate Audit Log',
                'description' => "Finance was finding unauthorized tax-exempt reseller certificates on records in Zoho Books, and the platform couldn't show who added them. I built a Laravel service that receives Zoho Books webhooks for four record types and compares each update against stored state, since Zoho reports that a record changed but not which field. It logs certificate additions, ignores duplicate events, and tracks removals so that re-additions are caught. Each change is attributed to an employee by matching Zoho's modified-by ID against a stored user directory.",
                'tech' => ['PHP', 'Laravel', 'Zoho Books API', 'Webhooks', 'AvaTax'],
                'repo_url' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'Zoho Desk Range Lookup Widget',
                'description' => "Support staff resisted the move to Zoho Desk because every ticket meant switching back to Zoho CRM to look up a customer's range. I offered to build an embedded widget. It uses the Desk–CRM integration to resolve each ticket's contact to their exact CRM record, then calls the Zoho CRM API to show their range details inside Desk. I iterated on it with the support team, and all of them now use it in place of CRM.",
                'tech' => ['JavaScript', 'Zoho Desk Widgets SDK', 'Zoho CRM API'],
                'repo_url' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'This Resume Site',
                'description' => 'Designed and built my own resume site with Laravel and Livewire, working agentically with Claude Code: I planned each feature, had Claude Code implement it, then reviewed and tested the result. All content is database-driven and managed through a private admin panel with drag-and-drop ordering, per-project visibility, and privacy controls. It includes a rate-limited contact form that emails new messages, dark mode, and a print-ready PDF view. The codebase is covered by Pest feature tests and static analysis with PHPStan (level 7).',
                'tech' => ['PHP', 'Laravel', 'Livewire', 'Tailwind CSS', 'Pest', 'PHPStan', 'Claude Code'],
                'repo_url' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'Digital QC Inspection App',
                'description' => "Converted the paper QC checklist into a Zoho Creator app with an inspection flow that adapts to each range's configuration. It attaches photos, files and notes to the matching Zoho CRM record, sends an email alert when a check fails, and logs time per inspection. Those logs showed that real throughput was half of what management had estimated. The app is still in daily use and still being extended.",
                'tech' => ['Zoho Creator', 'Deluge', 'Zoho CRM API'],
                'repo_url' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'RingCentral Call Archive',
                'description' => "RingCentral keeps only 6 months of call history. I built a Laravel app that pulls each day's call logs and analytics through the RingCentral SDK and stores them permanently, with a Livewire interface that every employee can search. Management uses it for analytics, and sales and support use it to check disputed calls. It is still in production and maintained.",
                'tech' => ['PHP', 'Laravel', 'Livewire', 'RingCentral API'],
                'repo_url' => null,
                'is_featured' => true,
            ],
            [
                'title' => 'Electronic Voting Machine',
                'description' => 'Led a six-person team at WSU to design and build an electronic voting machine, coordinating scope, task assignment, and integration.',
                'tech' => ['C#', 'Team Lead', 'Agile'],
                'repo_url' => 'https://github.com/BrandonHenry0330/BrandonHenry-Projects',
                'is_featured' => false,
            ],
            [
                'title' => 'PostScript Interpreter',
                'description' => 'Implemented an interpreter for a subset of PostScript in Python, leaning on higher-order functions for the operator dispatch.',
                'tech' => ['Python', 'Interpreters'],
                'repo_url' => 'https://github.com/BrandonHenry0330/BrandonHenry-Projects',
                'is_featured' => false,
            ],
            [
                'title' => 'Command-Line Chat Room',
                'description' => 'Built a terminal chat room in C++ with a partner as part of Everett Community College computer science coursework.',
                'tech' => ['C++', 'Networking'],
                'repo_url' => 'https://github.com/BrandonHenry0330/BrandonHenry-Projects',
                'is_featured' => false,
            ],
        ])->each(fn (array $project, int $index) => Project::query()->create([...$project, 'sort_order' => $index + 1]));

        collect([
            ['name' => 'Languages', 'skills' => ['PHP', 'JavaScript / TypeScript', 'SQL (MySQL)', 'Deluge', 'Python', 'C#', 'C++']],
            ['name' => 'Frameworks & Tools', 'skills' => ['Laravel', 'Livewire', 'Tailwind CSS', 'Pest', 'Git', 'Claude Code', 'React']],
            ['name' => 'Platforms & Integrations', 'skills' => ['Zoho (CRM, Books, Desk, Creator, Analytics)', 'WooCommerce / WordPress', 'AvaTax', 'RingCentral', 'REST APIs', 'Webhooks']],
            ['name' => 'Practices', 'skills' => ['Object-Oriented Design', 'Agentic Engineering', 'Agile / Scrum', 'Team Leadership']],
        ])->each(fn (array $group, int $index) => SkillGroup::query()->create([...$group, 'sort_order' => $index + 1]));

        collect([
            [
                'institution' => 'Washington State University',
                'credential' => 'B.A. Computer Science',
                'started_on' => '2020-08-01',
                'ended_on' => '2024-05-31',
                'details' => [
                    'Coursework: Design & Analysis of Algorithms, Systems Programming (C/C++), Data Mining, Computer Architecture, Programming Language Design, Software Engineering, Automata & Formal Languages, Linear Algebra, Statistics.',
                ],
            ],
            [
                'institution' => 'Everett Community College',
                'credential' => 'Associate Degree (Running Start)',
                'started_on' => '2017-09-01',
                'ended_on' => '2020-03-31',
                'details' => [
                    'Entered through Running Start as a high school junior, completing college-level coursework before transferring to WSU.',
                ],
            ],
        ])->each(fn (array $education, int $index) => Education::query()->create([...$education, 'sort_order' => $index + 1]));
    }
}
