<?php

namespace App\Controllers;

use App\Core\Helper;
use App\Core\App;
use App\Core\Database;

class EvidenceController
{
    /**
     * Store new evidence
     */
    public function store(): void
    {
        Helper::requireAuth();

        $investigationId = (int) ($_POST['investigation_id'] ?? 0);
        $title           = trim($_POST['title'] ?? '');
        $url             = trim($_POST['url'] ?? '');
        $snippet         = trim($_POST['snippet'] ?? '');
        $sourcePlatform  = trim($_POST['source_platform'] ?? '');
        $evidenceType    = trim($_POST['evidence_type'] ?? 'link');
        $confidence      = trim($_POST['confidence'] ?? 'medium');
        $notes           = trim($_POST['notes'] ?? '');

        if ($investigationId <= 0) {
            Helper::redirect('/dashboard');
            return;
        }

        // Validate investigation exists
        $investigation = Database::fetch(
            "SELECT id FROM investigations WHERE id = ?",
            [$investigationId]
        );

        if (!$investigation) {
            Helper::redirect('/dashboard');
            return;
        }

        Database::insert('evidence', [
            'investigation_id' => $investigationId,
            'title'            => $title ?: null,
            'url'              => $url ?: null,
            'snippet'          => $snippet ?: null,
            'source_platform'  => $sourcePlatform ?: null,
            'evidence_type'    => $evidenceType,
            'confidence'       => $confidence,
            'notes'            => $notes ?: null,
            'is_verified'      => 0
        ]);

        Helper::redirect('/investigation/' . $investigationId . '?evidence=1');
    }

    /**
     * Delete evidence
     */
    public function delete(string $id): void
    {
        Helper::requireAuth();

        $evidence = Database::fetch(
            "SELECT * FROM evidence WHERE id = ?",
            [$id]
        );

        if ($evidence) {
            $investigationId = $evidence['investigation_id'];
            Database::delete('evidence', 'id = :id', ['id' => $id]);
            Helper::redirect('/investigation/' . $investigationId);
            return;
        }

        Helper::redirect('/dashboard');
    }
}
