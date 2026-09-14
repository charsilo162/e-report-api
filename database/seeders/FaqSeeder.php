<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            ['question' => 'Can I really be anonymous?', 'answer' => 'Yes. When you submit a Report, simply choose "Yes" under "Do you want to be anonymous". We do not track your IP address, browser information, or location. We use end-to-end encryption to ensure that only those authorized can access your details.'],
            ['question' => 'Does it cost money to get legal help?', 'answer' => 'No. All legal services provided through WhistleBlowNG are pro-bono (free of charge) for the whistleblower. We connect you with lawyers who are committed to public interest litigation and fighting corruption.'],
            ['question' => 'Can I track my report status?', 'answer' => "Yes. Upon submitting a report, if you chose to be anonymous, you will receive a unique 16-digit passcode. You can use this code to log back in anonymously to check for updates. If you chose not to be anonymous, you can check your dashboard for updates and more."],
            ['question' => 'How long does the process usually take?', 'answer' => "Initial review takes 3-5 working days, within which you'd receive information about the status of your report. Timelines for accepted cases vary greatly depending on the complexity. We strive to keep you updated at major milestones through the secure portal or dashboard."],
            ['question' => 'What kind of wrongdoing can I report?', 'answer' => 'You can report various forms of misconduct including fraud, harassment, bribery, embezzlement, public safety violations, environmental damage, and abuse of power within both public and private organizations in Nigeria.'],
            ['question' => 'Can I submit evidence like documents, audio, or video?', 'answer' => 'Yes, and it is highly encouraged. Our secure upload system accepts documents (PDF, DOCX), images, audio, and video files. All files are automatically scrubbed of metadata (like location and author info) before being viewed by investigators.'],
        ];

        foreach ($faqs as $i => $faq) {
            Faq::create([...$faq, 'order' => $i]);
        }
    }
}