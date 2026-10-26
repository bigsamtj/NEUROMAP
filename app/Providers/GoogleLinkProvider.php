<?php

namespace App\Providers;

class GoogleLinkProvider
{
    public function buildSearchUrl(string $query): string
    {
        return 'https://www.google.com/search?q=' . urlencode($query);
    }
}
