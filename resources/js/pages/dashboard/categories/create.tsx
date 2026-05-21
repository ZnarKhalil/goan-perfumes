import { Head } from '@inertiajs/react';
import CategoryForm from '@/components/dashboard/categories/category-form';
import type { CategoryParentOption } from '@/components/dashboard/categories/category-form';
import { emptyTranslations } from '@/components/dashboard/translation-tabs';
import Heading from '@/components/heading';
import { adminTitle, dashboardLabels } from '@/lib/de';
import categoriesRoutes from '@/routes/dashboard/categories';

const FIELDS = [
    { name: 'name', label: 'Name' },
    { name: 'description', label: 'Beschreibung', type: 'textarea' as const },
];

type Props = {
    parents: CategoryParentOption[];
    next_sort_order: number;
};

export default function CategoriesCreate({ parents, next_sort_order }: Props) {
    return (
        <>
            <Head title={adminTitle('Neue Kategorie')} />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Heading
                    title="Neue Kategorie"
                    description="Lege eine neue Hauptkategorie an. Pflichtfelder sind mit * markiert."
                />
                <CategoryForm
                    mode="create"
                    parents={parents}
                    initial={{
                        parent_id: null,
                        sort_order: next_sort_order,
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
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        { title: dashboardLabels.categories, href: categoriesRoutes.index() },
        { title: 'Neu', href: categoriesRoutes.create() },
    ],
};
