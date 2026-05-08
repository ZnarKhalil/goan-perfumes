import { Head } from '@inertiajs/react';
import CategoryForm from '@/components/dashboard/categories/category-form';
import type { CategoryParentOption } from '@/components/dashboard/categories/category-form';
import { emptyTranslations } from '@/components/dashboard/translation-tabs';
import Heading from '@/components/heading';
import categoriesRoutes from '@/routes/dashboard/categories';

const FIELDS = [
    { name: 'name', label: 'Name' },
    { name: 'description', label: 'Beschreibung', type: 'textarea' as const },
    { name: 'meta_title', label: 'Meta Title' },
    {
        name: 'meta_description',
        label: 'Meta Description',
        type: 'textarea' as const,
    },
];

type Props = {
    parents: CategoryParentOption[];
};

export default function CategoriesCreate({ parents }: Props) {
    return (
        <>
            <Head title="Neue Kategorie" />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Heading
                    title="Neue Kategorie"
                    description="Lege eine neue Hauptkategorie an. Pflichtfelder sind mit * markiert."
                />
                <CategoryForm
                    mode="create"
                    parents={parents}
                    initial={{
                        slug: '',
                        parent_id: null,
                        sort_order: 0,
                        is_active: true,
                        image_url: null,
                        translations: emptyTranslations(FIELDS),
                    }}
                />
            </div>
        </>
    );
}

CategoriesCreate.layout = {
    breadcrumbs: [
        { title: 'Dashboard', href: '/dashboard' },
        { title: 'Kategorien', href: categoriesRoutes.index() },
        { title: 'Neu', href: categoriesRoutes.create() },
    ],
};
