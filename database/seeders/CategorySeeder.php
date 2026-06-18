<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Media;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = PerfumeCatalog::categories();
        $slugs = collect($categories)->pluck('slug')->all();
        $translations = PerfumeCatalog::categoryTranslations();

        Category::query()
            ->whereNotIn('slug', $slugs)
            ->each(fn (Category $category) => $this->deleteCategory($category));

        foreach ($categories as $index => $category) {
            $model = Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );

            $names = PerfumeCatalog::localized(
                $category['name'],
                $translations[$category['slug']] ?? [],
            );

            foreach ($names as $locale => $name) {
                $model->setTranslation($locale, 'name', $name);
            }

            $model->translations()
                ->whereNotIn('field', ['name'])
                ->delete();
        }
    }

    private function deleteCategory(Category $category): void
    {
        $category->media()
            ->with('translations')
            ->get()
            ->each(function (Media $media): void {
                $media->translations()->delete();
                $media->delete();
            });

        $category->translations()->delete();
        $category->delete();
    }
}
