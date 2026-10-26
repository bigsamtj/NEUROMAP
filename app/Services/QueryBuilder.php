<?php

namespace App\Services;

class QueryBuilder
{
    private array $templates = [
        // Exact Identity & Names
        [
            'title' => 'Full Name Exact Match',
            'category' => 'Identity',
            'pattern' => '"{{first_name}} {{surname}}"'
        ],
        [
            'title' => 'Name + Location / Country (Nigeria)',
            'category' => 'Identity',
            'pattern' => '"{{first_name}} {{surname}}" "Nigeria" OR "Lagos" OR "Abuja"'
        ],
        
        // Nigerian Specific Identifiers (Phone & NIN)
        [
            'title' => 'Phone Number Footprint',
            'category' => 'Identifiers',
            'pattern' => '"{phone}"'
        ],
        [
            'title' => 'NIN / Identity Number Mentions',
            'category' => 'Identifiers',
            'pattern' => '"{nin}"'
        ],

        // Social Media Targeted Dorks (Instagram, Twitter, Facebook, LinkedIn)
        [
            'title' => 'Instagram Profile & Mentions',
            'category' => 'Social Media',
            'pattern' => 'site:instagram.com "{{instagram}}" OR "{{first_name}} {{surname}}"'
        ],
        [
            'title' => 'Twitter / X Footprint',
            'category' => 'Social Media',
            'pattern' => 'site:twitter.com OR site:x.com "{{twitter}}" OR "{{first_name}} {{surname}}"'
        ],
        [
            'title' => 'Facebook Public Profile & Mentions',
            'category' => 'Social Media',
            'pattern' => 'site:facebook.com "{{facebook}}" OR "{{first_name}} {{surname}}"'
        ],
        [
            'title' => 'LinkedIn Professional Career',
            'category' => 'Professional',
            'pattern' => 'site:linkedin.com/in "{{first_name}} {{surname}}" OR "{{linkedin}}"'
        ],

        // Advanced OSINT Syntax (Inurl, Index Of, Login, Documents)
        [
            'title' => 'Directory Traversal / Index Of',
            'category' => 'Advanced Recon',
            'pattern' => 'intitle:"index of" "{{surname}} {{first_name}}" OR "{{email}}"'
        ],
        [
            'title' => 'Target Login / Portal Discovery',
            'category' => 'Advanced Recon',
            'pattern' => 'inurl:login OR inurl:admin OR inurl:portal "{{email}}" OR "{{organization}}"'
        ],
        [
            'title' => 'Public Documents (PDF/DOCX/XLSX)',
            'category' => 'Documents',
            'pattern' => '(filetype:pdf OR filetype:docx OR filetype:xlsx) "{{first_name}} {{surname}}" OR "{{organization}}"'
        ],
        [
            'title' => 'Domain Specific Records',
            'category' => 'Domain Recon',
            'pattern' => 'site:{{known_domains}} "{{first_name}}" OR "{{surname}}"'
        ],
        [
            'title' => 'Email Data Leak / Public Mentions',
            'category' => 'Contact',
            'pattern' => '"{email}"'
        ]
    ];

    public function generateQueries(array $subjectData): array
    {
        // Gabungkan first_name dan surname menjadi full_name jika diperlukan
        $subjectData['full_name'] = trim(($subjectData['first_name'] ?? '') . ' ' . ($subjectData['surname'] ?? ''));
        
        $generated = [];

        foreach ($this->templates as $index => $tpl) {
            $pattern = $tpl['pattern'];
            $isValid = true;

            // Cari placeholder {{variable}}
            preg_match_all('/\{\{(\w+)\}\}/', $pattern, $matches);

            foreach ($matches[1] as $field) {
                if (!empty($subjectData[$field])) {
                    $pattern = str_replace("{{{$field}}}", trim($subjectData[$field]), $pattern);
                } else {
                    // Jika parameter kunci kosong, abaikan dork tersebut agar tidak menghasilkan query kosong
                    $isValid = false;
                    break;
                }
            }

            if ($isValid) {
                $generated[] = [
                    'template_id' => $index + 1,
                    'title' => $tpl['title'],
                    'category' => $tpl['category'],
                    'provider' => 'google',
                    'query' => trim($pattern)
                ];
            }
        }

        return $generated;
    }
}
