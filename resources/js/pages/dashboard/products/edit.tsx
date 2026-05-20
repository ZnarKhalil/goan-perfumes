import { Head } from '@inertiajs/react';
import ProductForm from '@/components/dashboard/products/product-form';
import type {
    HighlightSlots,
    ProductAttributeGroup,
    ProductCategoryOption,
    ProductMediaRow,
} from '@/components/dashboard/products/product-form';
import type { TranslationsShape } from '@/components/dashboard/translation-tabs';
import type { VariantRow } from '@/components/dashboard/variant-row-editor';
import Heading from '@/components/heading';
import { adminTitle, dashboardLabels } from '@/lib/de';
import productsRoutes from '@/routes/dashboard/products';

type Props = {
    product: {
        id: number;
        slug: string;
        brand: string | null;
        is_active: boolean;
        is_featured: boolean;
        translations: TranslationsShape;
        categories: number[];
        attribute_values: number[];
        variants: VariantRow[];
        media: ProductMediaRow[];
    };
    categories: ProductCategoryOption[];
    attributes: ProductAttributeGroup[];
    highlightSlots: HighlightSlots;
};

export default function ProductsEdit({
    product,
    categories,
    attributes,
    highlightSlots,
}: Props) {
    const title = product.translations.de?.name || product.slug;

    return (
        <>
            <Head title={adminTitle(`Produkt bearbeiten – ${title}`)} />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Heading
                    title={title}
                    description="Bearbeite Stammdaten, Varianten, Filter und Bilder."
                />
                <ProductForm
                    mode="edit"
                    productId={product.id}
                    categories={categories}
                    attributes={attributes}
                    highlightSlots={highlightSlots}
                    initial={{
                        brand: product.brand ?? '',
                        is_active: product.is_active,
                        is_featured: product.is_featured,
                        translations: product.translations,
                        categories: product.categories,
                        attribute_values: product.attribute_values,
                        variants: product.variants,
                        media: product.media,
                    }}
                />
            </div>
        </>
    );
}

ProductsEdit.layout = {
    breadcrumbs: [
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        { title: dashboardLabels.products, href: productsRoutes.index() },
        { title: 'Bearbeiten', href: '#' },
    ],
};
