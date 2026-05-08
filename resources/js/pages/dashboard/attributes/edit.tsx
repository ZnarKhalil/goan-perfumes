import { Head } from '@inertiajs/react';
import AttributeForm from '@/components/dashboard/attributes/attribute-form';
import AttributeValueEditor from '@/components/dashboard/attributes/attribute-value-editor';
import type { AttributeValueRow } from '@/components/dashboard/attributes/attribute-value-editor';
import type { TranslationsShape } from '@/components/dashboard/translation-tabs';
import Heading from '@/components/heading';
import { adminTitle, dashboardLabels } from '@/lib/de';
import attributesRoutes from '@/routes/dashboard/attributes';

type Props = {
    attribute: {
        id: number;
        code: string;
        sort_order: number;
        is_filterable: boolean;
        is_multiple: boolean;
        translations: TranslationsShape;
        name: string;
        values: AttributeValueRow[];
    };
};

export default function AttributesEdit({ attribute }: Props) {
    return (
        <>
            <Head
                title={adminTitle(`Attribut bearbeiten – ${attribute.name}`)}
            />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Heading
                    title={attribute.name}
                    description="Bearbeite dieses Attribut und seine Werte."
                />
                <AttributeForm
                    mode="edit"
                    attributeId={attribute.id}
                    initial={{
                        code: attribute.code,
                        sort_order: attribute.sort_order,
                        is_filterable: attribute.is_filterable,
                        is_multiple: attribute.is_multiple,
                        translations: attribute.translations,
                    }}
                />
                <AttributeValueEditor
                    attributeId={attribute.id}
                    values={attribute.values}
                />
            </div>
        </>
    );
}

AttributesEdit.layout = {
    breadcrumbs: [
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        { title: dashboardLabels.attributes, href: attributesRoutes.index() },
        { title: 'Bearbeiten', href: '#' },
    ],
};
