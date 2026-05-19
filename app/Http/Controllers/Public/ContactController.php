<?php

namespace App\Http\Controllers\Public;

use Inertia\Inertia;
use Inertia\Response;

class ContactController extends PublicController
{
    public function __invoke(string $locale): Response
    {
        return Inertia::render('public/contact', $this->layoutProps());
    }
}
