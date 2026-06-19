<?php

namespace App\Http\Controllers\Public;

use Inertia\Inertia;
use Inertia\Response;

class ImpressumController extends PublicController
{
    public function __invoke(string $locale): Response
    {
        $meta = match ($this->locale()) {
            'en' => [
                'Legal notice',
                'Legal provider information and contact details for Goan Perfume.',
            ],
            'ar' => [
                'البيانات القانونية',
                'معلومات المزوّد القانونية وبيانات التواصل الخاصة بـ Goan Perfume.',
            ],
            default => [
                'Impressum',
                'Anbieterkennzeichnung und rechtliche Kontaktdaten von Goan Perfume.',
            ],
        };

        return Inertia::render('public/impressum', [
            ...$this->layoutProps(),
            'meta' => $this->localizedMeta(...$meta, routeName: 'impressum'),
        ]);
    }
}
