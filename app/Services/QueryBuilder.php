<?php

namespace App\Services;

class QueryBuilder
{
    public function generateQueries(array $subjectData, array $templates): array
    {
        $generated = [];

        foreach ($templates as $tpl) {
            $pattern = $tpl['pattern'];
            $isValid = true;

            // Cari semua placeholder {{variable}}
            preg_match_all('/\{\{(\w+)\}\}/', $pattern, $matches);

            foreach ($matches[1] as $field) {
                if (!empty($subjectData[$field])) {
                    $pattern = str_replace("{{{$field}}}", trim($subjectData[$field]), $pattern);
                } else {
                    // Jika parameter wajib tidak ada, lewati template ini
                    $isValid = false;
                    break;
                }
            }

            if ($isValid) {
                $generated[] = [
                    'template_id' => $tpl['id'],
                    'title' => $tpl['title'],
                    'category' => $tpl['category'],
                    'provider' => $tpl['provider'],
                    'query' => $pattern
                ];
            }
        }

        return $generated;
    }
}
