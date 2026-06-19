import { Link } from '@inertiajs/react';
import Price from '@/components/public/price';
import type { PublicCopy } from '@/lib/public-copy';
import { cn } from '@/lib/utils';
import type { PublicProductCard } from '@/types/public';

type Props = {
    product: PublicProductCard;
    copy: PublicCopy;
    className?: string;
};

export default function ProductCard({ product, copy, className }: Props) {
    return (
        <Link
            href={product.href}
            className={cn(
                'group grid gap-3 focus-visible:outline-none',
                className,
            )}
        >
            <div className="relative aspect-[4/5] overflow-hidden rounded-[1.2rem] border border-white/10 bg-[radial-gradient(120%_90%_at_50%_0%,#221708,#0c0907)]">
                {product.image_url ? (
                    <img
                        src={product.image_url}
                        alt={product.image_alt}
                        width={800}
                        height={1000}
                        loading="lazy"
                        decoding="async"
                        className="h-full w-full object-cover transition duration-700 group-hover:scale-[1.05]"
                    />
                ) : (
                    <div className="flex h-full items-center justify-center text-sm text-stone-500">
                        {copy.productCard.imageMissing}
                    </div>
                )}
                {product.is_featured && (
                    <span className="absolute top-3 left-3 rounded-full border border-[#e7c889]/40 bg-black/40 px-2.5 py-1 text-[11px] font-medium tracking-wide text-[#e7c889] uppercase backdrop-blur">
                        {copy.productCard.highlight}
                    </span>
                )}
            </div>
            <div className="grid gap-1">
                {product.brand && (
                    <p className="text-xs tracking-wide text-stone-400 uppercase">
                        {product.brand}
                    </p>
                )}
                <h3 className="font-display text-base leading-tight font-medium text-stone-50">
                    {product.name}
                </h3>
                <Price
                    min={product.min_price}
                    max={product.max_price}
                    fallback={copy.product.priceOnRequest}
                    className="text-sm text-[#e7c889]"
                />
            </div>
        </Link>
    );
}
