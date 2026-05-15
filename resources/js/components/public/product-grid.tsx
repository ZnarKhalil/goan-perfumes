import ProductCard from '@/components/public/product-card';
import { cn } from '@/lib/utils';
import type { PublicProductCard } from '@/types/public';

type Props = {
    products: PublicProductCard[];
    emptyMessage?: string;
    className?: string;
};

export default function ProductGrid({
    products,
    emptyMessage = 'Keine Produkte gefunden.',
    className,
}: Props) {
    if (products.length === 0) {
        return (
            <div className="border border-dashed border-stone-300 px-6 py-12 text-center text-sm text-stone-500">
                {emptyMessage}
            </div>
        );
    }

    return (
        <div
            className={cn(
                'grid grid-cols-2 gap-x-3 gap-y-8 md:gap-x-5 lg:grid-cols-4',
                className,
            )}
        >
            {products.map((product) => (
                <ProductCard key={product.id} product={product} />
            ))}
        </div>
    );
}
