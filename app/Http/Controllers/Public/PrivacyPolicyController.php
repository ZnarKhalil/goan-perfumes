<?php

namespace App\Http\Controllers\Public;

use Inertia\Inertia;
use Inertia\Response;

class PrivacyPolicyController extends PublicController
{
    public function __invoke(string $locale): Response
    {
        $meta = match ($this->locale()) {
            'en' => [
                'Privacy policy',
                'Information about processing personal data, contact requests, cookies, and Google Analytics at Goan Perfume.',
            ],
            'ar' => [
                'سياسة الخصوصية',
                'معلومات حول معالجة البيانات الشخصية وطلبات التواصل وملفات تعريف الارتباط وGoogle Analytics لدى Goan Perfume.',
            ],
            default => [
                'Datenschutzerklärung',
                'Informationen zur Verarbeitung personenbezogener Daten, Kontaktaufnahme, Cookies und Google Analytics bei Goan Perfume.',
            ],
        };

        return Inertia::render('public/privacy-policy', [
            ...$this->layoutProps(),
            'meta' => $this->localizedMeta(...$meta, routeName: 'privacy'),
        ]);
    }
}
