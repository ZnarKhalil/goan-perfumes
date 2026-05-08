import { Head } from '@inertiajs/react';
import ProductForm from '@/components/dashboard/products/product-form';
import type {
    HighlightSlots,
    ProductAttributeGroup,
    ProductCategoryOption,
} from '@/components/dashboard/products/product-form';
import { emptyTranslations } from '@/components/dashboard/translation-tabs';
import Heading from '@/components/heading';
import productsRoutes from '@/routes/dashboard/products';

const FIELDS = [
    { name: 'name', label: 'Name' },
    { name: 'short_description', label: 'Kurzbeschreibung' },
    { name: 'description', label: 'Beschreibung' },
];

type Props = {
    categories: ProductCategoryOption[];
    attributes: ProductAttributeGroup[];
    highlightSlots: HighlightSlots;
};

export default function ProductsCreate({
    categories,
    attributes,
    highlightSlots,
}: Props) {
    return (
        <>
            <Head title="Neues Produkt" />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Heading
                    title="Neues Produkt"
                    description="Lege ein Produkt mit Varianten, Filtern und Bildern an."
                />
                <ProductForm
                    mode="create"
                    categories={categories}
                    attributes={attributes}
                    highlightSlots={highlightSlots}
                    initial={{
                        slug: '',
                        brand: '',
                        is_active: true,
                        is_featured: false,
                        translations: emptyTranslations(FIELDS),
                        categories: [],
                        attribute_values: [],
                        variants: [],
                        media: [],
                    }}
                />
            </div>
        </>
    );
}

ProductsCreate.layout = {
    breadcrumbs: [
        { title: 'Dashboard', href: '/dashboard' },
        { title: 'Produkte', href: productsRoutes.index() },
        { title: 'Neu', href: productsRoutes.create() },
    ],
};
