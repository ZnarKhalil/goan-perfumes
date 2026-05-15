import { Link } from '@inertiajs/react';
import Price from '@/components/public/price';
import { cn } from '@/lib/utils';
import type { PublicProductCard } from '@/types/public';

type Props = {
    product: PublicProductCard;
    className?: string;
};

export default function ProductCard({ product, className }: Props) {
    return (
        <Link
            href={product.href}
            className={cn(
                'group grid gap-3 focus-visible:outline-none',
                className,
            )}
        >
            <div className="relative aspect-[4/5] overflow-hidden bg-stone-100">
                {product.image_url ? (
                    <img
                        src={product.image_url}
                        alt={product.image_alt}
                        loading="lazy"
                        className="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                    />
                ) : (
                    <div className="flex h-full items-center justify-center text-sm text-stone-500">
                        Kein Bild
                    </div>
                )}
                {product.is_featured && (
                    <span className="absolute top-3 left-3 bg-white/90 px-2.5 py-1 text-[11px] font-medium tracking-wide text-stone-900 uppercase">
                        Highlight
                    </span>
                )}
            </div>
            <div className="grid gap-1">
                {product.brand && (
                    <p className="text-xs tracking-wide text-stone-500 uppercase">
                        {product.brand}
                    </p>
                )}
                <h3 className="text-base leading-tight font-medium text-stone-950">
                    {product.name}
                </h3>
                <Price
                    min={product.min_price}
                    max={product.max_price}
                    className="text-sm text-stone-700"
                />
            </div>
        </Link>
    );
}
