<?php

namespace App\Services;

class DorkEngine
{
    private array $target = [];

    public function __construct(array $target)
    {
        $this->target = $target;
    }

    /**
     * Generate all possible dorks based on available target data
     */
    public function generate(): array
    {
        $dorks = [];

        $dorks = array_merge($dorks, $this->nameDorks());
        $dorks = array_merge($dorks, $this->emailDorks());
        $dorks = array_merge($dorks, $this->phoneDorks());
        $dorks = array_merge($dorks, $this->usernameDorks());
        $dorks = array_merge($dorks, $this->organizationDorks());
        $dorks = array_merge($dorks, $this->locationDorks());
        $dorks = array_merge($dorks, $this->websiteDorks());
        $dorks = array_merge($dorks, $this->combinedDorks());
        $dorks = array_merge($dorks, $this->fileDorks());
        $dorks = array_merge($dorks, $this->socialDorks());

        // Remove duplicates and empty values
        $unique = [];
        foreach ($dorks as $dork) {
            $key = md5($dork['query']);
            if (!isset($unique[$key]) && !empty(trim($dork['query']))) {
                $unique[$key] = $dork;
            }
        }

        return array_values($unique);
    }

    private function splitValues(?string $value): array
    {
        if (empty($value)) return [];
        $parts = preg_split('/[,;]+/', $value);
        return array_filter(array_map('trim', $parts));
    }

    private function nameDorks(): array
    {
        $dorks = [];
        $names = $this->splitValues($this->target['full_name'] ?? '');
        $aliases = $this->splitValues($this->target['aliases'] ?? '');

        $allNames = array_merge($names, $aliases);

        foreach ($allNames as $name) {
            if (strlen($name) < 3) continue;

            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'name',
                'query'    => '"' . $name . '"'
            ];

            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'name',
                'query'    => '"' . $name . '" (email OR phone OR address OR "phone number")'
            ];

            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'name',
                'query'    => '"' . $name . '" (CV OR resume OR curriculum OR "curriculum vitae")'
            ];

            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'name',
                'query'    => '"' . $name . '" (filetype:pdf OR filetype:doc OR filetype:docx)'
            ];
        }

        return $dorks;
    }

    private function emailDorks(): array
    {
        $dorks = [];
        $emails = $this->splitValues($this->target['emails'] ?? '');

        foreach ($emails as $email) {
            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'email',
                'query'    => '"' . $email . '"'
            ];

            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'email',
                'query'    => '"' . $email . '" (password OR leak OR breach OR pastebin OR dump)'
            ];

            // Extract domain from email
            if (strpos($email, '@') !== false) {
                $domain = explode('@', $email)[1];
                $dorks[] = [
                    'type'     => 'google_dork',
                    'platform' => 'google',
                    'category' => 'email',
                    'query'    => 'site:' . $domain . ' "' . explode('@', $email)[0] . '"'
                ];
            }
        }

        return $dorks;
    }

    private function phoneDorks(): array
    {
        $dorks = [];
        $phones = $this->splitValues($this->target['phones'] ?? '');

        foreach ($phones as $phone) {
            $clean = preg_replace('/[^0-9+]/', '', $phone);

            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'phone',
                'query'    => '"' . $phone . '"'
            ];

            if ($clean !== $phone) {
                $dorks[] = [
                    'type'     => 'google_dork',
                    'platform' => 'google',
                    'category' => 'phone',
                    'query'    => '"' . $clean . '"'
                ];
            }

            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'phone',
                'query'    => '"' . $phone . '" (name OR address OR owner OR "phone number")'
            ];
        }

        return $dorks;
    }

    private function usernameDorks(): array
    {
        $dorks = [];
        $usernames = $this->splitValues($this->target['usernames'] ?? '');

        foreach ($usernames as $username) {
            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'username',
                'query'    => '"' . $username . '"'
            ];

            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'username',
                'query'    => '"' . $username . '" (profile OR account OR user OR "@' . $username . '")'
            ];
        }

        return $dorks;
    }

    private function organizationDorks(): array
    {
        $dorks = [];
        $orgs = $this->splitValues($this->target['organizations'] ?? '');
        $names = $this->splitValues($this->target['full_name'] ?? '');

        foreach ($orgs as $org) {
            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'organization',
                'query'    => '"' . $org . '"'
            ];

            foreach ($names as $name) {
                $dorks[] = [
                    'type'     => 'google_dork',
                    'platform' => 'google',
                    'category' => 'organization',
                    'query'    => '"' . $name . '" "' . $org . '"'
                ];
            }
        }

        return $dorks;
    }

    private function locationDorks(): array
    {
        $dorks = [];
        $locations = $this->splitValues($this->target['locations'] ?? '');
        $names = $this->splitValues($this->target['full_name'] ?? '');

        foreach ($locations as $location) {
            foreach ($names as $name) {
                $dorks[] = [
                    'type'     => 'google_dork',
                    'platform' => 'google',
                    'category' => 'location',
                    'query'    => '"' . $name . '" "' . $location . '"'
                ];
            }
        }

        return $dorks;
    }

    private function websiteDorks(): array
    {
        $dorks = [];
        $websites = $this->splitValues($this->target['websites'] ?? '');

        foreach ($websites as $site) {
            $domain = preg_replace('/^https?:\/\//', '', $site);
            $domain = rtrim($domain, '/');

            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'website',
                'query'    => 'site:' . $domain
            ];

            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'website',
                'query'    => '"' . $domain . '"'
            ];
        }

        return $dorks;
    }

    private function combinedDorks(): array
    {
        $dorks = [];
        $names = $this->splitValues($this->target['full_name'] ?? '');
        $emails = $this->splitValues($this->target['emails'] ?? '');
        $phones = $this->splitValues($this->target['phones'] ?? '');

        foreach ($names as $name) {
            foreach ($emails as $email) {
                $dorks[] = [
                    'type'     => 'google_dork',
                    'platform' => 'google',
                    'category' => 'combined',
                    'query'    => '"' . $name . '" "' . $email . '"'
                ];
            }

            foreach ($phones as $phone) {
                $dorks[] = [
                    'type'     => 'google_dork',
                    'platform' => 'google',
                    'category' => 'combined',
                    'query'    => '"' . $name . '" "' . $phone . '"'
                ];
            }
        }

        return $dorks;
    }

    private function fileDorks(): array
    {
        $dorks = [];
        $names = $this->splitValues($this->target['full_name'] ?? '');
        $emails = $this->splitValues($this->target['emails'] ?? '');

        $fileTypes = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'csv'];

        foreach ($names as $name) {
            foreach ($fileTypes as $type) {
                $dorks[] = [
                    'type'     => 'google_dork',
                    'platform' => 'google',
                    'category' => 'file',
                    'query'    => '"' . $name . '" filetype:' . $type
                ];
            }
        }

        foreach ($emails as $email) {
            $dorks[] = [
                'type'     => 'google_dork',
                'platform' => 'google',
                'category' => 'file',
                'query'    => '"' . $email . '" filetype:pdf'
            ];
        }

        return $dorks;
    }

    private function socialDorks(): array
    {
        $dorks = [];
        $names = $this->splitValues($this->target['full_name'] ?? '');
        $usernames = $this->splitValues($this->target['usernames'] ?? '');

        $platforms = [
            'facebook.com',
            'instagram.com',
            'twitter.com',
            'x.com',
            'linkedin.com',
            'tiktok.com',
            'github.com',
            'youtube.com'
        ];

        foreach ($platforms as $platform) {
            foreach ($names as $name) {
                $dorks[] = [
                    'type'     => 'google_dork',
                    'platform' => 'google',
                    'category' => 'social',
                    'query'    => 'site:' . $platform . ' "' . $name . '"'
                ];
            }

            foreach ($usernames as $username) {
                $dorks[] = [
                    'type'     => 'google_dork',
                    'platform' => 'google',
                    'category' => 'social',
                    'query'    => 'site:' . $platform . ' "' . $username . '"'
                ];
            }
        }

        return $dorks;
    }
}
