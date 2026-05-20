<?php

namespace App\Http\Controllers\Public;

use Inertia\Inertia;
use Inertia\Response;

class ContactController extends PublicController
{
    public function __invoke(string $locale): Response
    {
        return Inertia::render('public/contact', [
            ...$this->layoutProps(),
            'meta' => $this->meta(
                'Kontakt',
                'Direkter Kontakt für persönliche Duftberatung – Fragen zu Duftprofil, Größen und Verfügbarkeit per WhatsApp, Telefon oder E-Mail.',
            ),
        ]);
    }
}
