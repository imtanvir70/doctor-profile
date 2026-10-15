<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\DrProfile;
use App\Models\SeoSetting;
use App\Models\Chamber;
use App\Models\Specialty;
use App\Models\Article;
use App\Models\Video;
use App\Models\Faq;
use App\Models\Review;
use App\Models\Serial;
use App\Models\Prescription;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        User::updateOrCreate(
            ['email' => 'admin@drabuhanifrakib.com'],
            [
                'name' => 'Dr. Abu Hanif Rakib',
                'password' => Hash::make('admin123'),
            ]
        );

        // 2. Doctor Profile (table: drprofile)
        DrProfile::updateOrCreate(
            ['id' => 1],
            [
                'name_en' => 'Dr. Abu Hanif Rakib',
                'name_bn' => 'ডাঃ মোঃ আবু হানিফ রাকিব',
                'designation_en' => 'Senior Consultant Medicine Specialist',
                'designation_bn' => 'সিনিয়র কনসালট্যান্ট ও মেডিসিন বিশেষজ্ঞ',
                'degrees_en' => 'MBBS, BCS (Health), FCPS (Medicine)',
                'degrees_bn' => 'এমবিবিএস, বিসিএস (স্বাস্থ্য), এফসিপিএস (মেডিসিন)',
                'bmdc_reg' => '84321',
                'experience_years' => '12+',
                'patients_count' => '28,000+',
                'satisfaction_rate' => '98.7%',
                'avatar' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&crop=top&w=900&q=80',
                'hero_badge_en' => 'BMDC Reg No: 84321',
                'hero_badge_bn' => 'বিএমডিসি রেজি নং: ৮৪৩২১',
                'hero_bio_en' => 'Providing authoritative, evidence-based diagnostic care and individualized treatment protocols for chronic, metabolic, and complex non-surgical conditions. Dedicated to clinical precision and patient dignity.',
                'hero_bio_bn' => 'জটিল মেডিসিন রোগ, ডায়াবেটিস, দীর্ঘমেয়াদী উচ্চ রক্তচাপ ও শারীরিক জটিলতায় আন্তর্জাতিক গাইডলাইন ভিত্তিক আধুনিক চিকিৎসা ও নিবিড় রোগীসেবা।',
                'about_headline_en' => 'Clinical Accuracy Built on Careful Listening & Rational Medicine',
                'about_headline_bn' => 'রোগীর কথা গভীর মনোযোগে শুনে সঠিক রোগ নির্ণয় ও পরিমিত চিকিৎসাসেবা',
                'about_p1_en' => 'Dr. Abu Hanif Rakib has earned widespread clinical respect as a dedicated Medicine Specialist in Bangladesh. After completing his undergraduate training with distinction from premier institutions, he completed his residency and earned fellowship in Internal Medicine from the Bangladesh College of Physicians and Surgeons (BCPS).',
                'about_p1_bn' => 'ডাঃ মোঃ আবু হানিফ রাকিব দেশের স্বনামধন্য মেডিকেল প্রতিষ্ঠান থেকে এমবিবিএস এবং পরবর্তীতে বিসিপিএস (BCPS) থেকে ইন্টারনাল মেডিসিনে মর্যাদাপূর্ণ এফসিপিএস (FCPS) ডিগ্রি অর্জন করেন।',
                'about_p2_en' => 'His clinical philosophy centres on treating the whole patient rather than isolated symptoms: avoiding irrational polypharmacy, reducing unnecessary investigational burdens, and framing accessible lifestyle interventions alongside modern therapeutic drugs.',
                'about_p2_bn' => 'চিকিৎসায় অপ্রয়োজনীয় ওষুধের অযৌক্তিক ব্যবহার পরিহার করা এবং রোগীর রোগ ও শারীরিক অবস্থা সহজভাবে বুঝিয়ে দিয়ে বিজ্ঞানসম্মত জীবনযাত্রার সমন্বয় করাই তাঁর মূল চিকিৎসা দর্শন।',
                'academic_post1_en' => 'Associate Professor, Department of Medicine',
                'academic_post1_bn' => 'সহযোগী অধ্যাপক, মেডিসিন বিভাগ',
                'academic_desc1_en' => 'Directing clinical rounds, high-dependency internal medicine care, and clinical trials.',
                'academic_desc1_bn' => 'মেডিসিন ওয়ার্ড রাউন্ড, জটিল রোগী পর্যবেক্ষণ ও মেডিকেল শিক্ষার্থীদের ক্লিনিক্যাল পাঠদান।',
                'hotline_phone' => '+8801700000000',
                'hotline_whatsapp' => '8801700000000',
                'email' => 'consultation@drabuhanifrakib.com',
                'consultation_fee' => 'BDT 1,200',
                'emergency_notice_en' => 'For severe chest pain, acute breathlessness, or signs of acute stroke, please visit the nearest hospital emergency department immediately or dial 999.',
                'emergency_notice_bn' => 'জরুরি আশঙ্কাজনক অবস্থায় (তীব্র বুকে ব্যথা, হঠাৎ অচেতনতা, স্ট্রোকের লক্ষণ) অবিলম্বে ৯৯৯ অথবা নিকটস্থ হাসপাতালের ইমার্জেন্সিতে যান।',
                'facebook_url' => 'https://facebook.com',
                'youtube_url' => 'https://youtube.com',
                'linkedin_url' => 'https://linkedin.com',
            ]
        );

        // 3. SEO Settings
        $seoPages = [
            [
                'page_key' => 'global',
                'meta_title_en' => 'Dr. Abu Hanif Rakib | Medicine Specialist | MBBS, BCS, FCPS',
                'meta_title_bn' => 'ডাঃ মোঃ আবু হানিফ রাকিব | মেডিসিন বিশেষজ্ঞ | এমবিবিএস, বিসিএস, এফসিপিএস',
                'meta_description_en' => 'Official appointment booking and clinical portal of Dr. Abu Hanif Rakib, Consultant Medicine Specialist in Dhaka. Evidence-based care for Diabetes, BP, and Internal Diseases.',
                'meta_description_bn' => 'মেডিসিন বিশেষজ্ঞ ডাঃ মোঃ আবু হানিফ রাকিবের অফিসিয়াল ওয়েবসাইট ও চেম্বার সিরিয়াল বুকিং পোর্টাল। ডায়াবেটিস ও জটিল মেডিসিন রোগের নির্ভরযোগ্য চিকিৎসা।',
                'keywords_en' => 'Dr. Abu Hanif Rakib, Medicine Specialist, Internal Medicine Dhaka, FCPS Medicine, Diabetes Specialist, BMDC Registered Doctor',
                'keywords_bn' => 'ডাঃ আবু হানিফ রাকিব, মেডিসিন বিশেষজ্ঞ ঢাকা, এফসিপিএস মেডিসিন, ডায়াবেটিস বিশেষজ্ঞ, প্রেসার স্পেশালিস্ট',
                'og_image' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?auto=format&fit=crop&w=1200&q=80',
                'schema_type' => 'Physician',
            ],
            [
                'page_key' => 'home',
                'meta_title_en' => 'Dr. Abu Hanif Rakib | Medicine Specialist | Official Portal',
                'meta_title_bn' => 'ডাঃ মোঃ আবু হানিফ রাকিব | মেডিসিন বিশেষজ্ঞ | অফিসিয়াল পোর্টাল',
                'meta_description_en' => 'Senior Consultant Medicine Specialist offering evidence-based medical diagnosis and comprehensive chronic care in Dhaka.',
                'meta_description_bn' => 'সিনিয়র কনসালট্যান্ট মেডিসিন বিশেষজ্ঞ ডাঃ মোঃ আবু হানিফ রাকিবের সার্বিক চিকিৎসা সেবা ও অনলাইন সিরিয়াল বুকিং।',
                'keywords_en' => 'Medicine Specialist Dhaka, Diabetes Doctor, Hypertension Expert, Internal Medicine',
                'keywords_bn' => 'মেডিসিন ডাক্তার ঢাকা, ডায়াবেটিস বিশেষজ্ঞ, রক্তচাপ বিশেষজ্ঞ',
                'schema_type' => 'Physician',
            ],
            [
                'page_key' => 'about',
                'meta_title_en' => 'About Dr. Abu Hanif Rakib | Credentials & Philosophy',
                'meta_title_bn' => 'ডাঃ মোঃ আবু হানিফ রাকিবের পরিচিতি ও চিকিৎসা দর্শন',
                'meta_description_en' => 'Learn about Dr. Abu Hanif Rakib, FCPS (Medicine), Associate Professor, with 12+ years of hospital experience.',
                'meta_description_bn' => 'ডাঃ মোঃ আবু হানিফ রাকিবের শিক্ষাগত যোগ্যতা, ফেলোশিপ এবং রোগীসেবার দৃষ্টিভঙ্গি সম্পর্কে জানুন।',
                'schema_type' => 'Person',
            ],
            [
                'page_key' => 'chambers',
                'meta_title_en' => 'Chambers & Schedule | Dr. Abu Hanif Rakib | Dhanmondi & Uttara',
                'meta_title_bn' => 'চেম্বার ও সময়সূচি | ডাঃ মোঃ আবু হানিফ রাকিব | ধানমন্ডি ও উত্তরা',
                'meta_description_en' => 'Consultation schedule at Popular Diagnostic Dhanmondi and Ibn Sina Diagnostic Uttara. View visiting days and hours.',
                'meta_description_bn' => 'পপুলার ডায়াগনস্টিক ধানমন্ডি এবং ইবনে সিনা উত্তরা চেম্বারের রোগী দেখার সময়সূচি ও হটলাইন নম্বর।',
                'schema_type' => 'MedicalOrganization',
            ],
            [
                'page_key' => 'booking',
                'meta_title_en' => 'Instant Serial Booking | Dr. Abu Hanif Rakib',
                'meta_title_bn' => 'সহজ অনলাইন সিরিয়াল বুকিং | ডাঃ মোঃ আবু হানিফ রাকিব',
                'meta_description_en' => 'Reserve your chamber consultation serial online in 2 minutes. Instant SMS confirmation, zero upfront fee.',
                'meta_description_bn' => 'মাত্র ২ মিনিটে নিশ্চিত করুন চেম্বার সিরিয়াল। অগ্রিম ফি ছাড়া ইনস্ট্যান্ট এসএমএস কনফার্মেশন।',
                'schema_type' => 'MedicalTherapy',
            ],
            [
                'page_key' => 'blog',
                'meta_title_en' => 'Health Articles & Medical Journal | Dr. Abu Hanif Rakib',
                'meta_title_bn' => 'স্বাস্থ্য পরামর্শ ও মেডিকেল কলাম | ডাঃ মোঃ আবু হানিফ রাকিব',
                'meta_description_en' => 'Read evidence-based clinical articles on diabetes, dengue recovery, hypertension, and thyroid care by Dr. Rakib.',
                'meta_description_bn' => 'ডায়াবেটিস, ডেঙ্গু ও স্বাস্থ্য সচেতনতায় ডাঃ মোঃ আবু হানিফ রাকিবের দিকনির্দেশনামূলক প্রবন্ধ।',
                'schema_type' => 'Article',
            ],
            [
                'page_key' => 'videos',
                'meta_title_en' => 'Clinical Video Guides & Advice | Dr. Abu Hanif Rakib',
                'meta_title_bn' => 'ভিডিও পরামর্শ ও স্বাস্থ্যবার্তা | ডাঃ মোঃ আবু হানিফ রাকিব',
                'meta_description_en' => 'Watch authentic video guides on blood sugar fluctuations, blood pressure control, and inhaler techniques.',
                'meta_description_bn' => 'রক্তে সুগার ও প্রেশার নিয়ন্ত্রণের সহজ নিয়ম নিয়ে চিকিৎসকের ভিডিও পরামর্শ।',
                'schema_type' => 'VideoObject',
            ],
            [
                'page_key' => 'faq',
                'meta_title_en' => 'Patient Help Guide & FAQs | Dr. Abu Hanif Rakib',
                'meta_title_bn' => 'রোগী সহায়তা ও প্রশ্নোত্তর | ডাঃ মোঃ আবু হানিফ রাকিব',
                'meta_description_en' => 'Find answers about serial booking, consultation fees, test report reviews, and required medical documents.',
                'meta_description_bn' => 'সিরিয়াল বুকিং, রিপোর্ট দেখানোর সময়সীমা ও ভিজিট ফি সংক্রান্ত জরুরি প্রশ্নোত্তর।',
                'schema_type' => 'FAQPage',
            ],
        ];

        foreach ($seoPages as $p) {
            SeoSetting::updateOrCreate(['page_key' => $p['page_key']], $p);
        }

        // 4. Chambers
        $chambers = [
            [
                'name_en' => 'Popular Diagnostic Centre, Dhanmondi',
                'name_bn' => 'পপুলার ডায়াগনস্টিক সেন্টার, ধানমন্ডি',
                'slug' => 'dhanmondi',
                'badge_en' => 'Dhanmondi Chamber',
                'badge_bn' => 'ধানমন্ডি চেম্বার',
                'address_en' => 'House #16, Road #2, Dhanmondi R/A, Dhaka - 1205 (Room 308, Building 2)',
                'address_bn' => 'বাড়ি #১৬, রোড #২, ধানমন্ডি আ/এ, ঢাকা - ১২০৫ (রুম ৩০৮, ভবন ২)',
                'visiting_days_en' => 'Saturday – Wednesday',
                'visiting_days_bn' => 'শনিবার – বুধবার',
                'visiting_hours_en' => '5:00 PM – 9:30 PM',
                'visiting_hours_bn' => 'বিকাল ৫:০০ – রাত ৯:৩০',
                'weekly_off_en' => 'Thursday & Friday',
                'weekly_off_bn' => 'বৃহস্পতিবার ও শুক্রবার বন্ধ',
                'phone1' => '01711-000001',
                'phone2' => '02-9669480',
                'fee' => 'BDT 1,200',
                'map_url' => 'https://maps.google.com/?q=Popular+Diagnostic+Centre+Dhanmondi+Dhaka',
                'facilities_en' => 'Fully accredited pathology lab, 1.5T MRI, 128-slice CT, Echocardiography, Spirometry, Ultrasound, and full-service pharmacy located in the same building.',
                'facilities_bn' => 'সার্বক্ষণিক প্যাথলজি ল্যাব, ১.৫টি এমআরআই, ১২৮-স্লাইস সিটি স্ক্যান, ইকোকার্ডিওগ্রাফি, স্পাইরোমেট্রি ও পূর্ণাঙ্গ ফার্মেসি সেবা একই ভবনে।',
                'note_en' => 'Direct on-site lab & pharmacy assistance.',
                'note_bn' => 'একই ভবনে আধুনিক ল্যাব ও ফার্মেসি সেবা বিদ্যমান।',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'name_en' => 'Ibn Sina Diagnostic Center, Uttara',
                'name_bn' => 'ইবনে সিনা ডায়াগনস্টিক সেন্টার, উত্তরা',
                'slug' => 'uttara',
                'badge_en' => 'Uttara Chamber',
                'badge_bn' => 'উত্তরা চেম্বার',
                'address_en' => 'House #52, Sector #3, Jasimuddin Avenue, Uttara, Dhaka - 1230 (Room 205)',
                'address_bn' => 'বাড়ি #৫২, সেক্টর #৩, জসীমউদ্দীন এভিনিউ, উত্তরা, ঢাকা - ১২৩০ (রুম ২০৫)',
                'visiting_days_en' => 'Thursday & Friday Only',
                'visiting_days_bn' => 'শুধুমাত্র বৃহস্পতিবার ও শুক্রবার',
                'visiting_hours_en' => '6:00 PM – 9:00 PM',
                'visiting_hours_bn' => 'সন্ধ্যা ৬:০০ – রাত ৯:০০',
                'weekly_off_en' => 'Saturday to Wednesday',
                'weekly_off_bn' => 'শনিবার থেকে বুধবার বন্ধ',
                'phone1' => '01722-000002',
                'phone2' => '02-4895444',
                'fee' => 'BDT 1,200',
                'map_url' => 'https://maps.google.com/?q=Ibn+Sina+Diagnostic+Center+Sector+3+Uttara+Dhaka',
                'facilities_en' => 'Advanced digital diagnostics, rapid fever panel workups (Dengue NS1, CBC), dedicated patient parking, and streamlined reception queue management.',
                'facilities_bn' => 'উন্নত ডিজিটাল ডায়াগনস্টিকস, দ্রুত ডেঙ্গু প্যানেল টেস্ট (NS1, CBC), নিজস্ব পার্কিং ব্যবস্থা ও রোগী বান্ধব অভ্যর্থনা সেবা।',
                'note_en' => 'Weekend and evening emergency serial slots available.',
                'note_bn' => 'ছুটির দিনে বিশেষ সান্ধ্যকালীন সিরিয়ালের সুযোগ।',
                'display_order' => 2,
                'is_active' => true,
            ],
        ];

        foreach ($chambers as $c) {
            Chamber::updateOrCreate(['slug' => $c['slug']], $c);
        }

        // 5. Clinical Specialties
        $specialties = [
            [
                'title_en' => 'Uncontrolled Diabetes & Metabolic Disorders',
                'title_bn' => 'অনিয়ন্ত্রিত ডায়াবেটিস ও মেটাবলিক সমস্যা',
                'slug' => 'diabetes-metabolism',
                'badge_en' => 'Metabolic Care',
                'badge_bn' => 'ডায়াবেটিস ও সুগার',
                'description_en' => 'Comprehensive glycemic stabilization for brittle Type 2 & Type 1 diabetes, diabetic neuropathy, kidney risk reduction, and individualized insulin regimen formulation.',
                'description_bn' => 'টাইপ-১ ও টাইপ-২ ডায়াবেটিসের টেকসই নিয়ন্ত্রণ, ইনসুলিন ব্যালেন্স, সুগার ওঠা-নামা প্রতিরোধ এবং কিডনি ও হার্ট সুরক্ষামূলক চিকিৎসা।',
                'approach_en' => 'Prioritizes organ-protective SGLT2 inhibitors and GLP-1 therapy alongside strict nutritional timing to achieve target HbA1c below 6.5% without hypoglycemic risk.',
                'approach_bn' => 'কিডনি ও হার্ট সুরক্ষাকারী আধুনিক ডায়াবেটিস ওষুধ এবং নিয়ন্ত্রিত খাদ্যতালিকার মাধ্যমে সুগার নিয়ন্ত্রণ।',
                'icon_class' => 'bi-activity',
                'icon_color' => 'clinical-icon-blue',
                'tags_en' => ['HbA1c Planning', 'Kidney Protection', 'Insulin Titration'],
                'tags_bn' => ['HbA1c নিয়ন্ত্রণ', 'কিডনি সুরক্ষা', 'ইনসুলিন গাইড'],
                'display_order' => 1,
            ],
            [
                'title_en' => 'Refractory Hypertension & Cardiovascular Risk',
                'title_bn' => 'উচ্চ রক্তচাপ ও হৃদরোগের ঝুঁকি নিয়ন্ত্রণ',
                'slug' => 'hypertension-heart',
                'badge_en' => 'Cardiovascular',
                'badge_bn' => 'উচ্চ রক্তচাপ',
                'description_en' => 'Diagnostic screening for resistant secondary hypertension, lipid profile dyslipidemia, cardiac risk assessment, and long-term arterial protection protocols.',
                'description_bn' => 'অনিয়ন্ত্রিত উচ্চ রক্তচাপ, লিপিড প্রোফাইল বা কোলেস্টেরল নিয়ন্ত্রণ এবং স্ট্রোক ও হার্ট অ্যাটাকের ঝুঁকি কমানোর বৈজ্ঞানিক চিকিৎসা।',
                'approach_en' => 'Identifies concealed secondary hypertension causes (renal artery stenosis, sleep apnea, endocrine adenomas) to prevent premature strokes and heart failure.',
                'approach_bn' => 'অনিয়ন্ত্রিত উচ্চ রক্তচাপের নেপথ্য কারণ শনাক্তকরণ ও অপ্রয়োজনীয় মাত্রাতিরিক্ত ওষুধ পরিহার।',
                'icon_class' => 'bi-heart-pulse-fill',
                'icon_color' => 'clinical-icon-blue',
                'tags_en' => ['24h BP Profiling', 'Stroke Prevention', 'Lipid Management'],
                'tags_bn' => ['২৪ ঘণ্টা প্রেশার মনিটরিং', 'স্ট্রোক প্রতিরোধ', 'কোলেস্টেরল'],
                'display_order' => 2,
            ],
            [
                'title_en' => 'Asthma, COPD & Respiratory Diseases',
                'title_bn' => 'হাঁপানি, শ্বাসকষ্ট ও সিওপিডি (COPD)',
                'slug' => 'respiratory-asthma',
                'badge_en' => 'Pulmonology',
                'badge_bn' => 'ফুসফুস ও শ্বাসযন্ত্র',
                'description_en' => 'Evidence-led therapeutics for chronic refractory cough, bronchial asthma, chronic obstructive pulmonary disease (COPD), allergic bronchitis, and post-viral lung recovery.',
                'description_bn' => 'দীর্ঘমেয়াদী কাশি, ব্রঙ্কিয়াল অ্যাজমা, সিওপিডি, অ্যালার্জি ও ফুসফুসের ইনফেকশন নিরাময়ে ইনহেলার ও আধুনিক চিকিৎসা।',
                'approach_en' => 'Employs objective spirometry parameters and teaches flawless inhaler spacer techniques rather than resorting to prolonged oral steroid dependence.',
                'approach_bn' => 'স্পাইরোমেট্রি টেস্ট ও ইনহেলারের সঠিক প্রয়োগ পদ্ধতির মাধ্যমে শ্বাসকষ্ট ও সিওপিডির কার্যকর নিয়ন্ত্রণ।',
                'icon_class' => 'bi-lungs-fill',
                'icon_color' => 'clinical-icon-emerald',
                'tags_en' => ['Spirometry Review', 'Inhaler Education', 'Allergy Control'],
                'tags_bn' => ['স্পাইরোমেট্রি', 'ইনহেলার টেকনিক', 'অ্যালার্জি'],
                'display_order' => 3,
            ],
            [
                'title_en' => 'Thyroid, Hormone & Endocrine Conditions',
                'title_bn' => 'থাইরয়েড ও হরমোনজনিত জটিলতা',
                'slug' => 'thyroid-endocrine',
                'badge_en' => 'Endocrine',
                'badge_bn' => 'থাইরয়েড',
                'description_en' => 'Accurate micro-titration of levothyroxine for hypothyroidism, hyperthyroidism control, thyroiditis, adrenal insufficiency, and metabolic weight dysregulation.',
                'description_bn' => 'হাইপোথাইরয়েডিজম, হঠাৎ ওজন বৃদ্ধি বা কমে যাওয়া, অতিরিক্ত ক্লান্তি ও হরমোনের তারতম্যের সুনির্দিষ্ট ডোজ নির্ধারণ।',
                'approach_en' => 'Performs comprehensive Free T3, Free T4, and anti-TPO antibody profiling to deliver precision micro-titrated hormone replenishment.',
                'approach_bn' => 'সম্পূর্ণ থাইরয়েড অ্যান্টিবডি প্রোফাইলিং এবং রোগীর শারীরিক লক্ষণ অনুযায়ী থাইরয়েড ওষুধের সুনির্দিষ্ট ডোজ নির্ধারণ।',
                'icon_class' => 'bi-capsule-pill',
                'icon_color' => 'clinical-icon-blue',
                'tags_en' => ['Thyroid Antibodies', 'Micro-Titration', 'Fatigue Recovery'],
                'tags_bn' => ['অ্যান্টিবডি টেস্ট', 'ওজন নিয়ন্ত্রণ', 'ক্লান্তি দূরীকরণ'],
                'display_order' => 4,
            ],
            [
                'title_en' => 'Dengue, Fever & Complex Infections',
                'title_bn' => 'ডেঙ্গু জ্বর ও জটিল সংক্রামক ব্যাধি',
                'slug' => 'fever-infections',
                'badge_en' => 'Infectious Diseases',
                'badge_bn' => 'জ্বর ও ইনফেকশন',
                'description_en' => 'Vigilant monitoring protocols for Dengue critical phase, typhoid, urinary tract infections (UTI), pyrexia of unknown origin (PUO), and sepsis management.',
                'description_bn' => 'ডেঙ্গু জ্বরে তরলের সঠিক ভারসাম্য রক্ষা, রক্ত পরীক্ষার ধারাবাহিক বিশ্লেষণ এবং অযথা অ্যান্টিবায়োটিক পরিহার।',
                'approach_en' => 'Strict hematocrit monitoring and plasma balance protocol for dengue; zero indiscriminate antibiotic prescriptions for benign viral infections.',
                'approach_bn' => 'ডেঙ্গু ও জ্বরে হেমাটোক্রিট পর্যবেক্ষণ ও প্লাজমা ব্যালেন্স নিশ্চিতকরণ; অপ্রয়োজনীয় অ্যান্টিবায়োটিক সম্পূর্ণ পরিহার।',
                'icon_class' => 'bi-thermometer-half',
                'icon_color' => 'clinical-icon-emerald',
                'tags_en' => ['Hematocrit Tracking', 'Dengue Protocols', 'Antibiotic Safety'],
                'tags_bn' => ['হেমাটোক্রিট ট্র্যাকিং', 'ডেঙ্গু গাইডলাইন', 'অ্যান্টিবায়োটিক সুরক্ষা'],
                'display_order' => 5,
            ],
            [
                'title_en' => 'Fatty Liver, IBS & Gastrointestinal Health',
                'title_bn' => 'ফ্যাটি লিভার ও গ্যাস্ট্রিক/আইবিএস সমস্যা',
                'slug' => 'liver-gut',
                'badge_en' => 'Gastroenterology',
                'badge_bn' => 'গ্যাস্ট্রিক ও লিভার',
                'description_en' => 'Systematic management of Grade 1/2 NAFLD (Fatty Liver), chronic gastritis, irritable bowel syndrome (IBS), dyspepsia, and chronic constipation.',
                'description_bn' => 'গ্রেড ১ ও ২ ফ্যাটি লিভার নিরাময়, আইবিএস, দীর্ঘস্থায়ী এসিডিটি ও পেটের নানাবিধ অস্বস্তির দীর্ঘমেয়াদী সমাধান।',
                'approach_en' => 'Staged gut-microbiome and liver enzyme normalization without long-term proton pump inhibitor dependency or unnecessary dietary restrictions.',
                'approach_bn' => 'দীর্ঘদিন এসিডিটির ওষুধ না দিয়ে জীবনযাত্রা ও খাদ্যাভ্যাস পরিবর্তনের মাধ্যমে ফ্যাটি লিভার ও আইবিএস নিরাময়।',
                'icon_class' => 'bi-shield-plus',
                'icon_color' => 'clinical-icon-blue',
                'tags_en' => ['Enzyme Reversal', 'IBS Nutrition', 'Microbiome Health'],
                'tags_bn' => ['লিভার এনজাইম', 'আইবিএস ডায়েট', 'পরিপাকতন্ত্র'],
                'display_order' => 6,
            ],
        ];

        foreach ($specialties as $s) {
            Specialty::updateOrCreate(['slug' => $s['slug']], $s);
        }

        // 6. Articles
        $articles = [
            [
                'title_en' => 'Lifestyle Modification as Medicine: Reversing Pre-Diabetes',
                'title_bn' => 'ওষুধ নয়, জীবনযাত্রাই চিকিৎসা: প্রি-ডায়াবেটিস নিয়ন্ত্রণ',
                'slug' => 'reversing-pre-diabetes-lifestyle',
                'category' => 'lifestyle',
                'badge_en' => 'Preventive Care',
                'badge_bn' => 'প্রতিরোধমূলক স্বাস্থ্য',
                'excerpt_en' => 'Pre-diabetes is not a permanent diagnosis—it is a critical physiological window where structured lifestyle intervention can prevent irreversible beta-cell exhaustion.',
                'excerpt_bn' => 'প্রি-ডায়াবেটিস কোনো স্থায়ী রোগ নয়—সঠিক সময়ে খাদ্য পরিবর্তন ও ব্যায়ামের মাধ্যমে এটিকে সম্পূর্ণ নিরাময় করা সম্ভব।',
                'content_en' => '<p>Pre-diabetes represents an elevated fasting glucose (100–125 mg/dL) or HbA1c between 5.7% and 6.4%. At this threshold, pancreatic beta cells still retain functional insulin secretagogue capacity.</p><h6 class="fw-bold text-primary mt-4">1. Post-Prandial Movement Protocol</h6><p>Walking briskly for 15 minutes immediately following your heaviest meal reduces postprandial glucose surges by 20–25%.</p><h6 class="fw-bold text-primary mt-4">2. Chrono-Nutrition & Glycemic Load</h6><p>Avoid high glycemic index carbohydrates at dinner. Replacing white rice with coarse whole grains and leafy fibers improves nocturnal insulin sensitivity.</p><h6 class="fw-bold text-primary mt-4">3. Modest Weight Loss</h6><p>A 5–7% weight reduction reduces hepatic steatosis significantly, returning fasting glucose to physiological range within 12 to 16 weeks.</p>',
                'content_bn' => '<p>প্রি-ডায়াবেটিস হলো রক্তে সুগারের মাত্রা স্বাভাবিকের চেয়ে বেশি কিন্তু তা পূর্ণ ডায়াবেটিসে পৌঁছায়নি। এই সময়ে সচেতন হলে ডায়াবেটিস পুরোপুরি ঠেকানো সম্ভব।</p><h6 class="fw-bold text-primary mt-4">১. খাওয়ার পরপরই হালকা হাঁটার নিয়ম</h6><p>ভারী খাবারের পরপরই ১৫ মিনিট সাধারণ গতিতে হাঁটলে রক্তের অতিরিক্ত সুগার পেশিগুলো সরাসরি গ্রহণ করে। এতে ইনসুলিনের ওপর চাপ অনেকটাই কমে যায়।</p><h6 class="fw-bold text-primary mt-4">২. রাতের খাবারে কার্বোহাইড্রেট কমানো</h6><p>রাতে অতিরিক্ত ভাত পরিহার করে শাকসবজি ও সালাদের পরিমাণ বাড়ান। এটি রাতের বেলা লিভারে অতিরিক্ত গ্লুকোজ তৈরি বন্ধ করে।</p><h6 class="fw-bold text-primary mt-4">৩. ৫-৭% ওজন কমানোর জাদু</h6><p>শরীরের মোট ওজনের মাত্র ৫ থেকে ৭ শতাংশ কমাতে পারলে লিভারের চর্বি দূর হয় এবং ইনসুলিন সংবেদনশীলতা স্বাভাবিক হয়।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=1000&q=80',
                'read_time' => '4 min read',
                'is_featured' => true,
                'is_published' => true,
            ],
            [
                'title_en' => 'Dengue Recovery: What Platelet Count Alone Doesn\'t Tell You',
                'title_bn' => 'ডেঙ্গু জ্বর: শুধু প্লাটিলেট কাউন্টই কি সবকিছু?',
                'slug' => 'dengue-recovery-hematocrit-fluids',
                'category' => 'infection',
                'badge_en' => 'Infectious Diseases',
                'badge_bn' => 'সংক্রামক ব্যাধি',
                'excerpt_en' => 'Why hematocrit monitoring, plasma leakage assessment, and strict fluid balance take clinical precedence over platelets alone during the critical phase.',
                'excerpt_bn' => 'ডেঙ্গু জ্বরে প্লাটিলেটের চেয়ে রক্তের ঘনত্ব বা হেমাটোক্রিট এবং তরলের ভারসাম্য বজায় রাখা কেন জীবনরক্ষাকারী।',
                'content_en' => '<p>During acute dengue infection, clinical morbidity is primarily driven by capillary plasma leakage rather than isolated thrombocytopenia.</p><h6 class="fw-bold text-primary mt-4">The Danger of the "Critical Phase"</h6><p>When fever suddenly subsides around day 4–5, patients often presume recovery. In reality, this marks the onset of the 48-hour critical phase where vascular permeability spikes.</p><h6 class="fw-bold text-primary mt-4">Hematocrit Over Platelets</h6><p>A hematocrit rise exceeding 20% signifies hemoconcentration. Judicious isotonic fluid management prevents dengue shock syndrome without causing pulmonary edema.</p>',
                'content_bn' => '<p>ডেঙ্গুতে অধিকাংশ রোগীর জটিলতা বা মৃত্যু প্লাটিলেট কমার কারণে নয়, বরং রক্তনালী থেকে পানি বা প্লাজমা বের হয়ে যাওয়ার কারণে ঘটে থাকে।</p><h6 class="fw-bold text-primary mt-4">ক্রিটিক্যাল ফেজ বা ঝুঁকিপূর্ণ সময়</h6><p>জ্বর কমার ৪র্থ থেকে ৬ষ্ঠ দিনে রোগী ভাবেন তিনি সুস্থ হয়ে গেছেন। অথচ এই সময়েই রক্তনালীর প্রাচীর ভেদ করে ফ্লুইড বাইরে চলে যেতে থাকে।</p><h6 class="fw-bold text-primary mt-4">হেমাটোক্রিট (HCT) পরীক্ষা সবচেয়ে জরুরি</h6><p>শুধু প্লাটিলেটের পেছনে না ছুটে রক্তের ঘনত্ব ২০% বৃদ্ধি পেল কি না তা নজর রাখা জরুরি। অতিরিক্ত স্যালাইন দেওয়াও ফুসফুসে পানি জমার মতো মারাত্মক বিপদ ডেকে আনতে পারে।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1584362917165-526a968579e8?auto=format&fit=crop&w=800&q=80',
                'read_time' => '5 min read',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title_en' => 'Chronic Fatigue, Brain Fog, & Unexplained Weight Gain',
                'title_bn' => 'অতিরিক্ত ক্লান্তি, স্মৃতিভ্রম ও হঠাৎ ওজন বৃদ্ধি',
                'slug' => 'chronic-fatigue-thyroid-deficiency',
                'category' => 'endocrine',
                'badge_en' => 'Endocrine Care',
                'badge_bn' => 'হরমোন ও থাইরয়েড',
                'excerpt_en' => 'Recognizing the subtle signs of subclinical hypothyroidism, Vitamin D deficiency, and adult metabolic dysregulation.',
                'excerpt_bn' => 'দীর্ঘমেয়াদী ক্লান্তি ও কাজে অনীহার পেছনে থাইরয়েড ও ভিটামিন ডি ঘাটতির নীরব প্রভাব চিহ্নিত করুন।',
                'content_en' => '<p>Persistent fatigue coupled with cold intolerance, hair thinning, and puffiness often points to subclinical hypothyroidism.</p><h6 class="fw-bold text-primary mt-4">Diagnostic Triad</h6><p>A complete thyroid panel including Free T4, Free T3, TSH, and anti-TPO antibodies distinguishes Hashimoto\'s autoimmune thyroiditis from general micronutrient deficiency.</p>',
                'content_bn' => '<p>ব্যস্ত জীবনে অনেকেই দীর্ঘস্থায়ী ক্লান্তি ও কাজে অনীহাকে শুধুই কাজের চাপ ভাবেন। কিন্তু এর পেছনে সাবক্লিনিক্যাল হাইপোথাইরয়েডিজম বা ভিটামিন ডি ঘাটতি থাকার সম্ভাবনা সবচেয়ে বেশি।</p><h6 class="fw-bold text-primary mt-4">সঠিক পরীক্ষা ও চিকিৎসা</h6><p>শুধু TSH নয়, এর সাথে Free T4 এবং অ্যান্টিবডি টেস্ট করা প্রয়োজন। সঠিক মাত্রার ওষুধ মাত্র ৩ থেকে ৪ সপ্তাহের মধ্যেই রোগীকে সম্পূর্ণ প্রাণবন্ত করে তোলে।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=800&q=80',
                'read_time' => '6 min read',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title_en' => 'Hidden Dietary Sodium & Refractory High Blood Pressure',
                'title_bn' => 'লুকানো লবণ ও অনিয়ন্ত্রিত উচ্চ রক্তচাপের রহস্য',
                'slug' => 'hidden-dietary-sodium-hypertension',
                'category' => 'heart',
                'badge_en' => 'Hypertension',
                'badge_bn' => 'উচ্চ রক্তচাপ',
                'excerpt_en' => 'Exploring why patients on three anti-hypertensive drugs still experience blood pressure spikes due to processed foods and seasonings.',
                'excerpt_bn' => 'তিনটি প্রেশারের ওষুধ খেয়েও প্রেশার নিয়ন্ত্রণে না আসার পেছনে প্রক্রিয়াজাত খাবারের গোপন সোডিয়ামের ভূমিকা।',
                'content_en' => '<p>Resistant hypertension is defined as BP that remains above goal despite concurrent use of three antihypertensive agents. In over 60% of cases in Bangladesh, occult salt consumption is the primary barrier.</p>',
                'content_bn' => '<p>অনেক রোগী অভিযোগ করেন—তিনটি প্রেশারের ওষুধ খেয়েও প্রেশার নিয়ন্ত্রণে আসছে না। এর প্রধান কারণ খাবারে লুকানো লবণের মাত্রাতীরিক্ত উপস্থিতি। পাউরুটি, বিস্কুট, চানাচুর ও বাইরের খাবারে প্রচুর সোডিয়াম থাকে।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=800&q=80',
                'read_time' => '4 min read',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title_en' => 'Antibiotic Resistance: A Doctor\'s Urgent Appeal',
                'title_bn' => 'অযথা অ্যান্টিবায়োটিক সেবন: চিকিৎসকের জরুরি সতর্কতা',
                'slug' => 'antibiotic-resistance-urgent-appeal',
                'category' => 'infection',
                'badge_en' => 'Stewardship',
                'badge_bn' => 'অ্যান্টিবায়োটিক',
                'excerpt_en' => 'Why taking Azithromycin or Cefixime for routine sore throats destroys normal flora and fuels lethal multidrug-resistant superbugs.',
                'excerpt_bn' => 'সামান্য সর্দি-কাশিতে অ্যান্টিবায়োটিক খেয়ে বন্ধ করে দিলে শরীরের রোগজীবাণু কীভাবে ভয়াবহ প্রতিরোধী হয়ে ওঠে।',
                'content_en' => '<p>Antibiotics only kill bacteria—they have zero efficacy against viruses causing seasonal colds, influenza, or dengue.</p>',
                'content_bn' => '<p>সাধারণ সর্দি, কাশি বা ভাইরাল জ্বরে অ্যান্টিবায়োটিকের কোনো ভূমিকা নেই। ভাইরাস মারতে অ্যান্টিবায়োটিক সম্পূর্ণ অকার্যকর। চিকিৎসকের পরামর্শ ছাড়া কখনো অ্যান্টিবায়োটিক খাবেন না।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1471864190281-a93a3070b6de?auto=format&fit=crop&w=800&q=80',
                'read_time' => '5 min read',
                'is_featured' => false,
                'is_published' => true,
            ],
            [
                'title_en' => 'IBS vs Acid Reflux: Deconstructing Gut Inflammation',
                'title_bn' => 'আইবিএস বনাম এসিডিটি: পেটের দীর্ঘমেয়াদী সমস্যার সমাধান',
                'slug' => 'ibs-vs-acid-reflux-gut-health',
                'category' => 'lifestyle',
                'badge_en' => 'Gastroenterology',
                'badge_bn' => 'গ্যাস্ট্রিক ও লিভার',
                'excerpt_en' => 'Clinical perspectives on gut-brain interactions, the role of chronic sympathetic stress, and avoiding lifelong proton-pump inhibitor overuse.',
                'excerpt_bn' => 'মস্তিষ্ক ও পরিপাকতন্ত্রের সম্পর্ক, মানসিক চাপ এবং প্রতিদিন গ্যাস্ট্রিকের ওষুধের ওপর নির্ভরতা কমানোর উপায়।',
                'content_en' => '<p>Irritable Bowel Syndrome (IBS) involves altered gut-brain communication rather than permanent mucosal damage. Chronic sympathetic nervous system overdrive slows or accelerates colonic motility.</p>',
                'content_bn' => '<p>আইবিএস (IBS) কোনো সংক্রমণ নয়, বরং মস্তিষ্কের সাথে অন্ত্রের সংকেত আদান-প্রদানের অসংগতি। মানসিক চাপ ও অনিয়মিত ঘুমের কারণে অন্ত্রের স্বাভাবিক চলাচল ব্যাহত হয়। অপ্রয়োজনীয় গ্যাস্ট্রিকের ক্যাপসুল মাসের পর মাস না খেয়ে জীবনযাত্রা পরিবর্তন করুন।</p>',
                'featured_image' => 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=800&q=80',
                'read_time' => '5 min read',
                'is_featured' => false,
                'is_published' => true,
            ],
        ];

        foreach ($articles as $a) {
            Article::updateOrCreate(['slug' => $a['slug']], $a);
        }

        // 7. Videos
        $videos = [
            [
                'title_en' => 'Managing Sudden Fluctuations in Blood Sugar',
                'title_bn' => 'রক্তে সুগারের হঠাৎ ওঠা-নামা নিয়ন্ত্রণে করণীয়',
                'youtube_id' => 'ScMzIvxBSi4',
                'category' => 'diabetes',
                'duration' => '8:45',
                'description_en' => 'Practical clinical advice on what to do when fasting and post-meal glucose spike unexpectedly, and when to seek urgent medical review.',
                'description_bn' => 'খাবার আগে ও পরে সুগার হঠাৎ বেড়ে গেলে করণীয় এবং ইনসুলিনের সঠিক ভারসাম্য রক্ষা।',
                'thumbnail' => 'https://img.youtube.com/vi/ScMzIvxBSi4/hqdefault.jpg',
                'display_order' => 1,
            ],
            [
                'title_en' => 'High Blood Pressure: Silent Risks & Prevention',
                'title_bn' => 'উচ্চ রক্তচাপের নীরব ঝুঁকি ও সুরক্ষার উপায়',
                'youtube_id' => 'ScMzIvxBSi4',
                'category' => 'hypertension',
                'duration' => '10:12',
                'description_en' => 'Understanding systolic and diastolic numbers, salt intake reduction, and protecting kidney and heart health over decades.',
                'description_bn' => 'সিস্টোলিক ও ডায়াস্টোলিক প্রেশার বোঝা এবং হার্ট ও কিডনি সুরক্ষায় লবণ নিয়ন্ত্রণের গুরুত্ব।',
                'thumbnail' => 'https://img.youtube.com/vi/ScMzIvxBSi4/hqdefault.jpg',
                'display_order' => 2,
            ],
            [
                'title_en' => 'Dangers of Indiscriminate Antibiotic Use',
                'title_bn' => 'অযথা অ্যান্টিবায়োটিক সেবনের মারাত্মক বিপদ',
                'youtube_id' => 'ScMzIvxBSi4',
                'category' => 'antibiotic',
                'duration' => '7:30',
                'description_en' => 'Why simple viral fevers do not require antibiotics, and how antibiotic resistance threatens public health in Bangladesh.',
                'description_bn' => 'ভাইরাল জ্বরে কেন অ্যান্টিবায়োটিক লাগে না এবং ওষুধের কার্যকারিতা নষ্ট হওয়ার কারণ।',
                'thumbnail' => 'https://img.youtube.com/vi/ScMzIvxBSi4/hqdefault.jpg',
                'display_order' => 3,
            ],
            [
                'title_en' => 'Asthma vs COPD: Correct Inhaler Techniques',
                'title_bn' => 'অ্যাজমা ও সিওপিডি: ইনহেলার ব্যবহারের সঠিক নিয়ম',
                'youtube_id' => 'ScMzIvxBSi4',
                'category' => 'respiratory',
                'duration' => '9:15',
                'description_en' => 'Step-by-step guidance on using metered-dose inhalers and rotahalers to achieve optimum pulmonary airway delivery without throat irritation.',
                'description_bn' => 'ইনহেলার ব্যবহারের সময় সাধারণ ভুলগুলো এড়িয়ে ফুসফুসে ওষুধের সঠিক কার্যকারিতা নিশ্চিতকরণ।',
                'thumbnail' => 'https://img.youtube.com/vi/ScMzIvxBSi4/hqdefault.jpg',
                'display_order' => 4,
            ],
            [
                'title_en' => 'Dengue Critical Phase: Warning Signs & Fluids',
                'title_bn' => 'ডেঙ্গু জ্বরের ঝুঁকিপূর্ণ ধাপ ও তরল ব্যবস্থাপনার নিয়ম',
                'youtube_id' => 'ScMzIvxBSi4',
                'category' => 'fever',
                'duration' => '11:05',
                'description_en' => 'Why day 4 to day 6 of dengue fever requires vigilant fluid balance monitoring, hematocrit testing, and how to spot plasma leakage early.',
                'description_bn' => 'জ্বর কমে যাওয়ার পর ডেঙ্গুর ক্রিটিক্যাল ফেজে সতর্কতা ও চিকিৎসকের নিবিড় পরামর্শ।',
                'thumbnail' => 'https://img.youtube.com/vi/ScMzIvxBSi4/hqdefault.jpg',
                'display_order' => 5,
            ],
            [
                'title_en' => 'Reversing Grade 1 & 2 Fatty Liver Clinically',
                'title_bn' => 'গ্রেড ১ ও ২ ফ্যাটি লিভার নিরাময়ের বাস্তবসম্মত উপায়',
                'youtube_id' => 'ScMzIvxBSi4',
                'category' => 'diabetes',
                'duration' => '12:40',
                'description_en' => 'Evidence-based nutritional shifts, weight optimization guidelines, and hepatic enzyme stabilization protocols to prevent liver fibrosis.',
                'description_bn' => 'সঠিক খাদ্যাভ্যাস, ওজন নিয়ন্ত্রণ ও নিয়মতান্ত্রিক জীবনযাত্রার মাধ্যমে ফ্যাটি লিভার দূর করা।',
                'thumbnail' => 'https://img.youtube.com/vi/ScMzIvxBSi4/hqdefault.jpg',
                'display_order' => 6,
            ],
        ];

        foreach ($videos as $v) {
            Video::updateOrCreate(['title_en' => $v['title_en']], $v);
        }

        // 8. FAQs
        $faqs = [
            [
                'question_en' => 'How can I book an appointment serial with Dr. Abu Hanif Rakib?',
                'question_bn' => 'ডাঃ মোঃ আবু হানিফ রাকিবের সিরিয়াল কীভাবে নেওয়া যায়?',
                'answer_en' => 'You can book a serial directly using our 2-step online form on this portal, or by calling chamber front-desk numbers from 8:00 AM daily (Dhanmondi: 01711-000001, Uttara: 01722-000002).',
                'answer_bn' => 'আপনি ওয়েবসাইটের ২-ক্লিক ফর্মের মাধ্যমে অনলাইনে অথবা সকাল ৮টা থেকে চেম্বারের নম্বরে সরাসরি ফোন দিয়ে সিরিয়াল নিতে পারবেন (ধানমন্ডি: ০১৭১১-০০০০০১, উত্তরা: ০১৭২২-০০০০০২)।',
                'display_order' => 1,
            ],
            [
                'question_en' => 'What medical documents should I bring for my first consultation?',
                'question_bn' => 'প্রথম সাক্ষাতে সাথে কী কী কাগজপত্র আনা উচিত?',
                'answer_en' => 'Please bring all previous prescriptions, recent lab test reports (blood tests, sugar charts, lipid profiles, imaging), and a list of all current medications with dosages.',
                'answer_bn' => 'রোগীর পূর্ববর্তী সমস্ত প্রেসক্রিপশন, সাম্প্রতিক টেস্ট রিপোর্ট (সিবিসি, সুগার, লিপিড প্রোফাইল ইত্যাদি) এবং বর্তমান ওষুধের তালিকা সঙ্গে আনা জরুরি।',
                'display_order' => 2,
            ],
            [
                'question_en' => 'What is the report evaluation timeframe and fee rule?',
                'question_bn' => 'রিপোর্ট দেখানোর নিয়ম ও সময়সীমা কী?',
                'answer_en' => 'Diagnostic tests ordered during your initial consultation can be reviewed within 7 to 10 days free of any additional consultation charge.',
                'answer_bn' => 'প্রথম সাক্ষাতে দেওয়া পরীক্ষাগুলোর রিপোর্ট ৭ থেকে ১০ দিনের মধ্যে বিনামূল্যে ডাক্তার স্যারকে দেখানো যাবে।',
                'display_order' => 3,
            ],
            [
                'question_en' => 'Does Dr. Abu Hanif Rakib provide telemedicine consultations?',
                'question_bn' => 'অনলাইন বা টেলিমেডিসিনে রোগী দেখেন কি?',
                'answer_en' => 'Telemedicine follow-ups are available for established patients who have undergone at least one comprehensive in-person clinical examination.',
                'answer_bn' => 'পূর্বে চেম্বারে স্বশরীরে দেখানো রোগীদের ক্ষেত্রে প্রয়োজন অনুযায়ী ফলো-আপে টেলিমেডিসিন পরামর্শের সুবিধা দেওয়া হয়।',
                'display_order' => 4,
            ],
            [
                'question_en' => 'How much is the consultation fee and how is it paid?',
                'question_bn' => 'পরামর্শ ফি কত এবং কীভাবে পরিশোধ করতে হয়?',
                'answer_en' => 'The consultation fee is BDT 1,200 for initial visits. No advance payment is needed online; payment is completed at the chamber counter upon arrival.',
                'answer_bn' => 'প্রথমবার পরামর্শ ফি ১,২০০ টাকা। অনলাইনে কোনো অগ্রিম টাকা দিতে হয় না; চেম্বারে এসে রিসেপশনে ফি পরিশোধ করবেন।',
                'display_order' => 5,
            ],
            [
                'question_en' => 'What should I do in case of an acute medical emergency?',
                'question_bn' => 'জরুরি চিকিৎসা বা হাসপাতালে ভর্তির প্রয়োজন হলে কী করব?',
                'answer_en' => 'Chambers provide scheduled outpatient care only. For acute severe chest pain, breathing collapse, or stroke symptoms, please dial 999 or go directly to the nearest hospital emergency department.',
                'answer_bn' => 'চেম্বার শুধুমাত্র পূর্বনির্ধারিত বহিঃবিভাগীয় পরামর্শের জন্য। তীব্র বুকে ব্যথা, শ্বাসকষ্ট বা স্ট্রোকের মতো জরুরি অবস্থায় অবিলম্বে নিকটস্থ হাসপাতালের ইমার্জেন্সিতে যান।',
                'display_order' => 6,
            ],
        ];

        foreach ($faqs as $f) {
            Faq::updateOrCreate(['question_en' => $f['question_en']], $f);
        }

        // 9. Reviews
        $reviews = [
            [
                'patient_name' => 'Anwar Hossain',
                'patient_initials' => 'AR',
                'color_class' => 'clinical-icon-blue',
                'location_tag_en' => 'Diabetes Patient • Dhanmondi',
                'location_tag_bn' => 'ডায়াবেটিস রোগী • ধানমন্ডি',
                'rating' => 5,
                'review_text_en' => '"Dr. Abu Hanif Rakib is one of the most thorough doctors in Dhaka. He spent over 20 minutes analyzing my fluctuating glucose numbers and adjusted my medication smoothly. My HbA1c is now stable at 6.3%."',
                'review_text_bn' => '"ডাঃ আবু হানিফ রাকিব স্যার খুব ধৈর্য নিয়ে কথা শোনেন। আমার সুগার ওঠা-নামা করছিল, উনি ওষুধ এডজাস্ট করার পর এখন আলহামদুলিল্লাহ পুরো নিয়ন্ত্রণে আছে।"',
            ],
            [
                'patient_name' => 'Shamima Jahan',
                'patient_initials' => 'SJ',
                'color_class' => 'clinical-icon-emerald',
                'location_tag_en' => 'Hypertension Care • Uttara',
                'location_tag_bn' => 'উচ্চ রক্তচাপ • উত্তরা',
                'rating' => 5,
                'review_text_en' => '"My mother suffered from unexplained high blood pressure spikes for months. Dr. Rakib accurately diagnosed secondary renal artery constriction and helped us avoid severe organ damage. We are eternally grateful."',
                'review_text_bn' => '"আমার মায়ের অনিয়ন্ত্রিত প্রেশার নিয়ে খুব চিন্তায় ছিলাম। স্যার নিখুঁতভাবে টেস্ট দিয়ে সঠিক সমস্যা চিহ্নিত করেছেন। ওনার আন্তরিকতায় আমরা কৃতজ্ঞ।"',
            ],
            [
                'patient_name' => 'Khandaker Rafiqul Islam',
                'patient_initials' => 'KR',
                'color_class' => 'clinical-icon-blue',
                'location_tag_en' => 'General Medicine • Mirpur',
                'location_tag_bn' => 'জেনারেল মেডিসিন • মিরপুর',
                'rating' => 5,
                'review_text_en' => '"No unnecessary tests, honest clinical advice, and genuine bedside kindness. When you speak to Dr. Abu Hanif Rakib, you know you are in the hands of a true expert."',
                'review_text_bn' => '"অহেতুক অতিরিক্ত পরীক্ষা দেন না এবং শান্তভাবে প্রতিটি কথা শোনেন। ঢাকায় এমন আন্তরিক মেডিসিন বিশেষজ্ঞ পাওয়া আসলেই ভাগ্যের ব্যাপার।"',
            ],
        ];

        foreach ($reviews as $r) {
            Review::updateOrCreate(['patient_name' => $r['patient_name']], $r);
        }

        // 10. Sample Serials
        $dhanmondiChamber = Chamber::where('slug', 'dhanmondi')->first();
        $sampleSerial = Serial::updateOrCreate(
            ['serial_number' => 'SL-20261015-001'],
            [
                'chamber_id' => $dhanmondiChamber->id,
                'chamber_name' => $dhanmondiChamber->name_en,
                'patient_name' => 'Abdul Karim',
                'patient_phone' => '01712345678',
                'preferred_date' => now()->toDateString(),
                'patient_age' => 52,
                'patient_gender' => 'male',
                'visit_type' => 'new',
                'symptoms_summary' => 'Uncontrolled fasting blood sugar (12.5 mmol/L) and frequent urination for 3 weeks.',
                'status' => 'confirmed',
                'admin_notes' => 'Confirmed via SMS on 09:30 AM.',
                'sms_sent_at' => now(),
            ]
        );

        // 11. Sample Digital Prescription (EMR)
        Prescription::updateOrCreate(
            ['prescription_no' => 'RX-2026-0001'],
            [
                'serial_id' => $sampleSerial->id,
                'chamber_id' => $dhanmondiChamber->id,
                'patient_name' => 'Abdul Karim',
                'patient_phone' => '01712345678',
                'patient_age' => 52,
                'patient_gender' => 'Male',
                'patient_address' => 'Mirpur-10, Dhaka',
                'consultation_date' => now()->toDateString(),
                'bp_systolic' => '135',
                'bp_diastolic' => '85',
                'pulse' => '76',
                'weight' => '72 kg',
                'temperature' => '98.4 F',
                'blood_sugar' => '12.4 mmol/L (Fasting)',
                'spo2' => '98%',
                'chief_complaints' => "1. Polyuria & Polydipsia for 3 weeks\n2. Generalized lethargy and morning fatigue",
                'clinical_history' => "Known hypertensive for 4 years on regular Tab. Amlodipine 5mg. No prior history of IHD or Asthma.",
                'diagnosis' => "Uncontrolled Type 2 Diabetes Mellitus with Mild Hypertension",
                'medicines' => [
                    [
                        'name' => 'Tab. Dapagliflozin 10mg (Dapavel)',
                        'dose' => '0 + 1 + 0',
                        'timing' => 'After lunch',
                        'duration' => '1 month',
                        'instructions' => 'Take with full glass of water. Do not skip.'
                    ],
                    [
                        'name' => 'Tab. Metformin HCl 500mg (Comet XR)',
                        'dose' => '1 + 0 + 1',
                        'timing' => 'With meal / After dinner',
                        'duration' => '1 month',
                        'instructions' => 'Swallow whole, do not crush.'
                    ],
                    [
                        'name' => 'Tab. Telmisartan 40mg (Telmi)',
                        'dose' => '1 + 0 + 0',
                        'timing' => 'Morning after breakfast',
                        'duration' => 'Continue',
                        'instructions' => 'Regular blood pressure monitoring.'
                    ]
                ],
                'investigations' => [
                    ['name' => 'HbA1c', 'instructions' => 'Check in certified lab'],
                    ['name' => 'Serum Creatinine & eGFR', 'instructions' => 'Renal assessment'],
                    ['name' => 'Urine R/M/E with Microalbumin', 'instructions' => 'Morning fresh sample'],
                    ['name' => 'Fasting Lipid Profile', 'instructions' => '12 hours fasting required']
                ],
                'special_advice' => "১. চিনি, মিষ্টি, কোমল পানীয় ও মিষ্টি ফল সম্পূর্ণ বর্জন করুন।\n২. প্রতিদিন খাবারের পর অন্তত ১৫-২০ মিনিট দ্রুত গতিতে হাঁটবেন।\n৩. রান্নায় অতিরিক্ত লবণ ও আলগা কাঁচা লবণ পরিহার করুন।\n৪. প্রচুর পানি ও আঁশযুক্ত শাকসবজি গ্রহণ করবেন।",
                'next_visit_date' => now()->addDays(14)->toDateString(),
                'doctor_notes' => 'Review with reports after 2 weeks. Monitor for hypoglycemia.',
            ]
        );

        $this->call(InternationalProjectSeeder::class);
    }
}
