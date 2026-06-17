<?php

namespace App\Http\Controllers\Public;

use Inertia\Inertia;
use Inertia\Response;

class PrivacyPolicyController extends PublicController
{
    public function __invoke(string $locale): Response
    {
        return Inertia::render('public/privacy-policy', [
            ...$this->layoutProps(),
            'meta' => $this->meta(
                'Datenschutzerklärung',
                'Informationen zur Verarbeitung personenbezogener Daten, Kontaktaufnahme, Cookies und Google Analytics bei Goan Perfume.',
            ),
        ]);
    }
}
