<?php

namespace App\Services;

class SocialScanner
{
    private array $target = [];

    public function __construct(array $target)
    {
        $this->target = $target;
    }

    /**
     * Generate social media specific searches and possible profile URLs
     */
    public function generate(): array
    {
        $results = [];

        $results = array_merge($results, $this->generateForPlatforms());
        $results = array_merge($results, $this->generateProfileGuesses());

        // Remove duplicates
        $unique = [];
        foreach ($results as $item) {
            $key = md5(($item['query'] ?? '') . ($item['url'] ?? ''));
            if (!isset($unique[$key])) {
                $unique[$key] = $item;
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

    private function generateForPlatforms(): array
    {
        $items = [];

        $names = $this->splitValues($this->target['full_name'] ?? '');
        $usernames = $this->splitValues($this->target['usernames'] ?? '');
        $aliases = $this->splitValues($this->target['aliases'] ?? '');

        $identifiers = array_unique(array_merge($names, $usernames, $aliases));

        $platforms = [
            'facebook'  => 'facebook.com',
            'instagram' => 'instagram.com',
            'twitter'   => 'twitter.com',
            'x'         => 'x.com',
            'linkedin'  => 'linkedin.com',
            'tiktok'    => 'tiktok.com',
            'github'    => 'github.com',
            'youtube'   => 'youtube.com',
            'reddit'    => 'reddit.com',
            'pinterest' => 'pinterest.com',
            'telegram'  => 't.me',
        ];

        foreach ($platforms as $name => $domain) {
            foreach ($identifiers as $id) {
                if (strlen($id) < 2) continue;

                $items[] = [
                    'type'     => 'social',
                    'platform' => $name,
                    'category' => 'social_search',
                    'query'    => 'site:' . $domain . ' "' . $id . '"',
                    'url'      => null
                ];
            }
        }

        return $items;
    }

    private function generateProfileGuesses(): array
    {
        $items = [];
        $usernames = $this->splitValues($this->target['usernames'] ?? '');

        // Common profile URL patterns
        $patterns = [
            'facebook'  => 'https://facebook.com/%s',
            'instagram' => 'https://instagram.com/%s',
            'twitter'   => 'https://twitter.com/%s',
            'x'         => 'https://x.com/%s',
            'github'    => 'https://github.com/%s',
            'tiktok'    => 'https://tiktok.com/@%s',
            'youtube'   => 'https://youtube.com/@%s',
            'reddit'    => 'https://reddit.com/user/%s',
            'telegram'  => 'https://t.me/%s',
            'linkedin'  => 'https://linkedin.com/in/%s',
        ];

        foreach ($usernames as $username) {
            $clean = ltrim($username, '@');
            if (strlen($clean) < 2) continue;

            foreach ($patterns as $platform => $pattern) {
                $items[] = [
                    'type'     => 'social',
                    'platform' => $platform,
                    'category' => 'profile_guess',
                    'query'    => null,
                    'url'      => sprintf($pattern, $clean)
                ];
            }
        }

        return $items;
    }
}
