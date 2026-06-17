import { Head } from '@inertiajs/react';
import CategoryForm from '@/components/dashboard/categories/category-form';
import type { CategoryParentOption } from '@/components/dashboard/categories/category-form';
import type { TranslationsShape } from '@/components/dashboard/translation-tabs';
import Heading from '@/components/heading';
import { adminTitle, dashboardLabels } from '@/lib/de';
import categoriesRoutes from '@/routes/dashboard/categories';

type Props = {
    category: {
        id: number;
        slug: string;
        parent_id: number | null;
        sort_order: number;
        is_active: boolean;
        translations: TranslationsShape;
        name: string;
    };
    parents: CategoryParentOption[];
};

export default function CategoriesEdit({ category, parents }: Props) {
    return (
        <>
            <Head
                title={adminTitle(`Kategorie bearbeiten – ${category.name}`)}
            />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Heading
                    title={category.name}
                    description="Bearbeite diese Kategorie und ihre Übersetzungen."
                />
                <CategoryForm
                    mode="edit"
                    categoryId={category.id}
                    parents={parents}
                    initial={{
                        parent_id: category.parent_id,
                        sort_order: category.sort_order,
                        is_active: category.is_active,
                        translations: category.translations,
                    }}
                />
            </div>
        </>
    );
}

CategoriesEdit.layout = {
    breadcrumbs: [
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        { title: dashboardLabels.categories, href: categoriesRoutes.index() },
        { title: 'Bearbeiten', href: '#' },
    ],
};
