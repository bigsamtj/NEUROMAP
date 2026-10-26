<?php

namespace App\Providers;

interface SearchProviderInterface
{
    public function buildSearchUrl(string $query): string;
}
