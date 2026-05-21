import { Head } from '@inertiajs/react';
import PromotionForm, {
    PROMOTION_TRANSLATION_FIELDS,
} from '@/components/dashboard/promotions/promotion-form';
import { emptyTranslations } from '@/components/dashboard/translation-tabs';
import Heading from '@/components/heading';
import { adminTitle, dashboardLabels } from '@/lib/de';
import promotionsRoutes from '@/routes/dashboard/promotions';

type Props = {
    next_sort_order: number;
};

export default function PromotionsCreate({ next_sort_order }: Props) {
    return (
        <>
            <Head title={adminTitle('Neue Aktion')} />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Heading
                    title="Neue Aktion"
                    description="Lege ein Textangebot für die Startseite an."
                />
                <PromotionForm
                    mode="create"
                    initial={{
                        starts_at: '',
                        ends_at: '',
                        sort_order: next_sort_order,
                        is_active: true,
                        translations: emptyTranslations(
                            PROMOTION_TRANSLATION_FIELDS,
                        ),
                    }}
                />
            </div>
        </>
    );
}

PromotionsCreate.layout = {
    breadcrumbs: [
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        { title: dashboardLabels.promotions, href: promotionsRoutes.index() },
        { title: 'Neu', href: promotionsRoutes.create() },
    ],
};
