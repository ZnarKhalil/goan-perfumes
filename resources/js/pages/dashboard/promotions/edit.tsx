import { Head } from '@inertiajs/react';
import PromotionForm from '@/components/dashboard/promotions/promotion-form';
import type { TranslationsShape } from '@/components/dashboard/translation-tabs';
import Heading from '@/components/heading';
import { adminTitle, dashboardLabels } from '@/lib/de';
import promotionsRoutes from '@/routes/dashboard/promotions';

type Props = {
    promotion: {
        id: number;
        slug: string;
        background_image_url: string | null;
        background_color: string;
        link_url: string;
        promo_code: string;
        discount_percent: number | null;
        starts_at: string;
        ends_at: string;
        sort_order: number;
        is_active: boolean;
        translations: TranslationsShape;
        title: string;
    };
};

export default function PromotionsEdit({ promotion }: Props) {
    return (
        <>
            <Head
                title={adminTitle(`Aktion bearbeiten – ${promotion.title}`)}
            />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Heading
                    title={promotion.title}
                    description="Bearbeite Hero-Inhalte, Laufzeit und Darstellung."
                />
                <PromotionForm
                    mode="edit"
                    promotionId={promotion.id}
                    initial={{
                        slug: promotion.slug,
                        background_image_url: promotion.background_image_url,
                        background_color: promotion.background_color,
                        link_url: promotion.link_url,
                        promo_code: promotion.promo_code,
                        discount_percent: promotion.discount_percent ?? '',
                        starts_at: promotion.starts_at,
                        ends_at: promotion.ends_at,
                        sort_order: promotion.sort_order,
                        is_active: promotion.is_active,
                        translations: promotion.translations,
                    }}
                />
            </div>
        </>
    );
}

PromotionsEdit.layout = {
    breadcrumbs: [
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        { title: dashboardLabels.promotions, href: promotionsRoutes.index() },
        { title: 'Bearbeiten', href: '#' },
    ],
};
