<?php

namespace App\Http\Requests\Dashboard;

use App\Models\PageSection;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePageSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->is_admin === true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $pageSection = $this->pageSection();

        $rules = [
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
            'translations' => ['required', 'array'],
            'translations.de' => ['required', 'array'],
            'translations.ar' => ['nullable', 'array'],
            'translations.en' => ['nullable', 'array'],
            'translations.*.title' => ['nullable', 'string', 'max:255'],
            'translations.*.body' => ['nullable', 'string', 'max:8000'],
            'translations.*.cta_text' => ['nullable', 'string', 'max:120'],
            'translations.*.bullet_points' => ['nullable', 'array'],
            'translations.*.bullet_points.*' => ['nullable', 'string', 'max:255'],
        ];

        if ($pageSection?->key === 'hero') {
            // The hero shows an image or a video, never both.
            $rules['hero_image'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,avif', 'max:5120', 'prohibits:hero_video'];
            $rules['hero_video'] = ['nullable', 'file', 'mimes:mp4,webm', 'max:20480', 'prohibits:hero_image'];
            $rules['remove_hero_image'] = ['nullable', 'boolean'];
            $rules['remove_hero_video'] = ['nullable', 'boolean'];
            $rules['translations.de.title'] = ['required', 'string', 'max:255'];
            $rules['translations.de.cta_text'] = ['nullable', 'string', 'max:120'];
        }

        if ($pageSection?->key === 'about') {
            $rules['translations.de.title'] = ['required', 'string', 'max:255'];
            $rules['translations.de.body'] = ['required', 'string', 'max:8000'];
        }

        if ($pageSection?->key === 'why_us') {
            $rules['translations.de.title'] = ['required', 'string', 'max:255'];
            $rules['translations.de.bullet_points'] = ['required', 'array', 'min:1'];
            $rules['translations.de.bullet_points.*'] = ['required', 'string', 'max:255'];
        }

        return $rules;
    }

    private function pageSection(): ?PageSection
    {
        $pageSection = $this->route('page_section');

        return $pageSection instanceof PageSection ? $pageSection : null;
    }
}
