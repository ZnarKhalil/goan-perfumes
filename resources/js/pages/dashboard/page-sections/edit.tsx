import { Head } from '@inertiajs/react';
import PageSectionForm from '@/components/dashboard/page-sections/page-section-form';
import type {
    PageSectionKey,
    PageSectionTranslations,
} from '@/components/dashboard/page-sections/page-section-form';
import Heading from '@/components/heading';
import { adminTitle, dashboardLabels } from '@/lib/de';
import pageSectionsRoutes from '@/routes/dashboard/page-sections';

type Props = {
    section: {
        id: number;
        key: PageSectionKey;
        label: string;
        type: string;
        payload: {
            image_path?: string | null;
            video_path?: string | null;
            product_ids?: number[];
        };
        image_url: string | null;
        video_url: string | null;
        sort_order: number;
        is_active: boolean;
        translations: PageSectionTranslations;
    };
    products: Array<{
        id: number;
        name: string;
        brand: string | null;
    }>;
};

export default function PageSectionsEdit({ section, products }: Props) {
    return (
        <>
            <Head
                title={adminTitle(
                    `Seiten-Inhalt bearbeiten – ${section.label}`,
                )}
            />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Heading
                    title={section.label}
                    description="Bearbeite diesen festen Bereich der Startseite."
                />
                <PageSectionForm section={section} products={products} />
            </div>
        </>
    );
}

PageSectionsEdit.layout = {
    breadcrumbs: [
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        {
            title: dashboardLabels.pageSections,
            href: pageSectionsRoutes.index(),
        },
        { title: 'Bearbeiten', href: '#' },
    ],
};
