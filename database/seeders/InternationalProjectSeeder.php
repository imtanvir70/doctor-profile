<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InternationalProject;

class InternationalProjectSeeder extends Seeder
{
    public function run(): void
    {
        InternationalProject::firstOrCreate([
            'title_en' => 'WHO South-East Asia Diabetes & Cardiovascular Prevention Study',
        ], [
            'title_bn' => 'দক্ষিণ এশিয়া ডায়াবেটিস ও কার্ডিওভাসকুলার প্রতিরোধ গবেষণা',
            'organization' => 'World Health Organization (WHO) & SEARO',
            'country_or_location' => 'Geneva & South Asia Hub',
            'role_en' => 'National Clinical Lead - Bangladesh Cohort',
            'role_bn' => 'জাতীয় ক্লিনিক্যাল প্রধান - বাংলাদেশ পর্ব',
            'duration' => '2022 – 2024',
            'category' => 'Clinical Research',
            'badge_text' => 'WHO Sponsored',
            'description_en' => 'Led a multi-center observational trial evaluating evidence-based rational therapies and lifestyle interventions for metabolic disorders across 5,000+ patients.',
            'description_bn' => 'দক্ষিণ এশিয়ার ৫,০০০+ রোগীর ডায়াবেটিস ও বিপাকীয় রোগ প্রতিরোধে আধুনিক এভিডেন্স-বেসড চিকিৎসা পদ্ধতি ও ক্লিনিক্যাল ট্রায়াল পরিচালনায় নেতৃত্ব দিয়েছেন।',
            'project_url' => 'https://www.who.int',
            'icon' => 'bi-globe-americas',
            'display_order' => 1,
            'is_featured' => true,
            'is_active' => true,
        ]);

        InternationalProject::firstOrCreate([
            'title_en' => 'Global Antimicrobial Resistance (AMR) Stewardship Collaboration',
        ], [
            'title_bn' => 'গ্লোবাল অ্যান্টিমাইক্রোবিয়াল রেজিস্ট্যান্স (AMR) গবেষণা সহযোগিতা',
            'organization' => 'Oxford Tropical Network & Wellcome Trust',
            'country_or_location' => 'Oxford, UK & Regional Centers',
            'role_en' => 'Co-Investigator & Clinical Consultant',
            'role_bn' => 'সহ-গবেষক ও ক্লিনিক্যাল কনসালট্যান্ট',
            'duration' => '2020 – 2022',
            'category' => 'Public Health & Pharmacology',
            'badge_text' => 'Oxford Wellcome Collab',
            'description_en' => 'Coordinated cross-border surveillance on irrational antibiotic use in acute fever cases, establishing strict protocols to preserve antimicrobial potency.',
            'description_bn' => 'তীব্র জ্বর ও ইনফেকশনে অপ্রয়োজনীয় অ্যান্টিবায়োটিক ব্যবহার হ্রাস এবং ড্রাগ রেজিস্ট্যান্স রোধে বৈশ্বিক গবেষণা প্রোটোকল প্রণয়ন ও তত্ত্বাবধান।',
            'project_url' => 'https://www.wellcome.org',
            'icon' => 'bi-shield-check',
            'display_order' => 2,
            'is_featured' => true,
            'is_active' => true,
        ]);

        InternationalProject::firstOrCreate([
            'title_en' => 'International Clinical Registry for Post-Viral Metabolic Sequelae',
        ], [
            'title_bn' => 'পোস্ট-ভাইরাল বিপাকীয় ও হার্ট জটিলতা বিষয়ক আন্তর্জাতিক রেজিস্ট্রি',
            'organization' => 'International Society of Internal Medicine (ISIM)',
            'country_or_location' => 'Basel, Switzerland & Global Hub',
            'role_en' => 'Steering Committee Member & Clinical Investigator',
            'role_bn' => 'স্টিয়ারিং কমিটি সদস্য ও গবেষক',
            'duration' => '2021 – Present',
            'category' => 'Multicenter Clinical Trial',
            'badge_text' => 'ISIM Global Registry',
            'description_en' => 'International observational study tracking long-term cardiovascular and metabolic outcomes following severe viral infections in adult populations.',
            'description_bn' => 'ভাইরাল সংক্রমণ পরবর্তী দীর্ঘমেয়াদী জটিলতা ও কার্ডিওভাসকুলার রোগ নিয়ন্ত্রণে আন্তর্জাতিক পর্যায়ে ক্লিনিক্যাল ডেটাবেজ ও পর্যবেক্ষণমূলক গবেষণা।',
            'project_url' => 'https://www.isim.org',
            'icon' => 'bi-activity',
            'display_order' => 3,
            'is_featured' => true,
            'is_active' => true,
        ]);
    }
}

