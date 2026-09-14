<?php

namespace Database\Seeders;

use App\Models\CaseStudy;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CaseStudySeeder extends Seeder
{
    public function run(): void
    {
        $stories = [
            [
                'tag' => 'Financial Crime',
                'title' => "Senior Banker's Fraud",
                'excerpt' => 'A senior banker in a leading Tier 1 bank was exposed for massive financial fraud, leading to legal action and asset recovery.',
                'image' => '/assets/stories/bankers-fraud.jpg',
                'detail_title' => 'Financial fraud by a senior banker',
                'case_details' => 'A senior banker in a leading Tier 1 bank was exposed for laundering funds tied to unauthorized offshore transfers. The whistleblower provided documentation implicating multiple senior executives in the scheme.',
                'evidence' => [
                    ['title' => 'Falsified Audit Reports', 'description' => "Internal documentation highlighting discrepancies in the bank's ledger versus client accounts."],
                    ['title' => 'Leaked Correspondence', 'description' => 'Digital transcripts of unauthorized fund movements between accounts.'],
                ],
                'monetary_amount' => 'N600M+ in funds were traced and recovered. This whistleblower can potentially earn up to 10% of the recovered monetary value of the wrongdoing, if applicable.',
                'outcome' => 'Following the report, the bank launched an internal investigation that led to the resignation of three executives, and regulatory bodies imposed fines exceeding N2M for compliance failures.',
                'stats' => ['amountRecovered' => '₦600M+', 'reportDate' => 'Jan 2024', 'resolutionDate' => '08 Months', 'legalFrameworkUsed' => 'Whistleblower Protection Act'],
            ],
            [
                'tag' => null,
                'title' => 'Sexual Harassment in FMCG',
                'excerpt' => 'Three women bravely reported sexual harassment in a leading FMCG company, resulting in a full investigation and disciplinary action.',
                'image' => '/assets/stories/fmcg-harassment.jpg',
                'detail_title' => 'Sexual harassment inside a leading FMCG company',
                'case_details' => 'Three employees independently reported a pattern of harassment by a senior manager. Reports were cross-referenced and corroborated during the review process.',
                'evidence' => [
                    ['title' => 'Written Testimonies', 'description' => 'Detailed accounts submitted by three separate employees.'],
                    ['title' => 'Internal Messages', 'description' => 'Chat logs showing inappropriate conduct over company channels.'],
                ],
                'monetary_amount' => 'No monetary recovery applied to this case; resolution was disciplinary and procedural.',
                'outcome' => "The company launched a full investigation, resulting in the manager's dismissal and the introduction of a revised harassment policy.",
                'stats' => ['amountRecovered' => 'N/A', 'reportDate' => 'Mar 2024', 'resolutionDate' => '2 Months', 'legalFrameworkUsed' => 'Workplace Harassment Act'],
            ],
            [
                'tag' => null,
                'title' => 'Dismissal of a Whistleblower',
                'excerpt' => 'A whistleblower in a Tier 2 bank wrongfully dismissed after exposing internal irregularities was fully reinstated with compensation.',
                'image' => '/assets/stories/whistleblower-dismissal.jpg',
                'detail_title' => 'Wrongful dismissal of a whistleblower',
                'case_details' => 'An employee was dismissed shortly after reporting irregular loan approvals. The timing and lack of documented performance issues raised concerns of retaliation.',
                'evidence' => [
                    ['title' => 'Termination Letter', 'description' => 'Issued 9 days after the internal report was filed.'],
                    ['title' => 'Performance Records', 'description' => 'Showed no prior disciplinary history before the report.'],
                ],
                'monetary_amount' => 'Reinstated with full back pay and additional compensation for wrongful dismissal.',
                'outcome' => 'The employee was reinstated to their original role, and the bank updated its internal policy to protect reporters from retaliation.',
                'stats' => ['amountRecovered' => 'N/A', 'reportDate' => 'Jun 2024', 'resolutionDate' => '5 Months', 'legalFrameworkUsed' => 'Whistleblower Protection Act'],
            ],
        ];

        foreach ($stories as $story) {
            $story['slug'] = Str::slug($story['title']);
            CaseStudy::create($story);
        }
    }
}