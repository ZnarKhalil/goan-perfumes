import ProductCard from '@/components/public/product-card';
import type { PublicCopy } from '@/lib/public-copy';
import { cn } from '@/lib/utils';
import type { PublicProductCard } from '@/types/public';

type Props = {
    products: PublicProductCard[];
    copy: PublicCopy;
    emptyMessage?: string;
    className?: string;
};

export default function ProductGrid({
    products,
    copy,
    emptyMessage = copy.category.empty,
    className,
}: Props) {
    if (products.length === 0) {
        return (
            <div className="rounded-[1.4rem] border border-dashed border-white/15 px-6 py-16 text-center text-sm text-stone-400">
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
                <ProductCard key={product.id} product={product} copy={copy} />
            ))}
        </div>
    );
}
