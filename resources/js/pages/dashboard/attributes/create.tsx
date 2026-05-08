import { Head } from '@inertiajs/react';
import AttributeForm, {
    ATTRIBUTE_TRANSLATION_FIELDS,
} from '@/components/dashboard/attributes/attribute-form';
import { emptyTranslations } from '@/components/dashboard/translation-tabs';
import Heading from '@/components/heading';
import { adminTitle, dashboardLabels } from '@/lib/de';
import attributesRoutes from '@/routes/dashboard/attributes';

export default function AttributesCreate() {
    return (
        <>
            <Head title={adminTitle('Neues Attribut')} />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Heading
                    title="Neues Attribut"
                    description="Lege eine neue Filtergruppe für den Katalog an."
                />
                <AttributeForm
                    mode="create"
                    initial={{
                        code: '',
                        sort_order: 0,
                        is_filterable: true,
                        is_multiple: true,
                        translations: emptyTranslations(
                            ATTRIBUTE_TRANSLATION_FIELDS,
                        ),
                    }}
                />
            </div>
        </>
    );
}

AttributesCreate.layout = {
    breadcrumbs: [
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        { title: dashboardLabels.attributes, href: attributesRoutes.index() },
        { title: 'Neu', href: attributesRoutes.create() },
    ],
};
