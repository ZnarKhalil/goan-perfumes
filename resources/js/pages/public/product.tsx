import { Head, Link } from '@inertiajs/react';
import { ArrowLeft, Mail, Phone, Send } from 'lucide-react';
import { useState } from 'react';
import PublicLayout from '@/layouts/public-layout';
import { getPublicCopy } from '@/lib/public-copy';
import type { PublicCopy } from '@/lib/public-copy';
import { formatEuro } from '@/lib/public-format';
import { cn } from '@/lib/utils';
import type { PublicProductPageProps, PublicVariant } from '@/types/public';

export default function Product(page: PublicProductPageProps) {
    const copy = getPublicCopy(page.locale);
    const product = page.product;
    const primaryMedia =
        product.media.find((media) => media.is_primary) ?? product.media[0];
    const gallery = [...product.media].sort((first, second) => {
        if (first.is_primary === second.is_primary) {
            return first.id - second.id;
        }

        return first.is_primary ? -1 : 1;
    });
    const [selectedVariantId, setSelectedVariantId] = useState(
        product.variants.find((variant) => variant.is_default)?.id ??
            product.variants[0]?.id ??
            null,
    );
    const selectedVariant =
        product.variants.find((variant) => variant.id === selectedVariantId) ??
        product.variants[0] ??
        null;

    return (
        <PublicLayout
            navigation={page.navigation}
            contact={page.contact}
            logo_url={page.logo_url}
            locale={page.locale}
        >
            <Head title={product.name}>
                <meta
                    head-key="description"
                    name="description"
                    content={product.short_description}
                />
            </Head>

            <section className="px-4 py-8 md:px-8 md:py-12">
                <div className="mx-auto grid max-w-7xl gap-10 lg:grid-cols-[minmax(0,1.12fr)_minmax(24rem,0.88fr)] lg:items-start">
                    <div className="grid gap-3">
                        {primaryMedia ? (
                            <div className="aspect-[4/5] overflow-hidden bg-stone-100 md:aspect-[5/6]">
                                <img
                                    src={primaryMedia.url}
                                    alt={primaryMedia.alt}
                                    className="h-full w-full object-cover"
                                />
                            </div>
                        ) : (
                            <div className="flex aspect-[4/5] items-center justify-center bg-stone-100 text-sm text-stone-500">
                                {copy.product.imageMissing}
                            </div>
                        )}

                        {gallery.length > 1 && (
                            <div className="grid grid-cols-3 gap-3">
                                {gallery.map((media) => (
                                    <div
                                        key={media.id}
                                        className="aspect-square overflow-hidden bg-stone-100"
                                    >
                                        <img
                                            src={media.url}
                                            alt={media.alt}
                                            loading="lazy"
                                            className="h-full w-full object-cover transition duration-500 hover:scale-[1.03]"
                                        />
                                    </div>
                                ))}
                            </div>
                        )}
                    </div>

                    <div className="lg:sticky lg:top-24">
                        {product.primary_category && (
                            <Link
                                href={product.primary_category.href}
                                className="inline-flex items-center gap-2 text-sm text-stone-500 transition hover:text-stone-950"
                            >
                                <ArrowLeft className="size-4" />
                                {copy.product.backToCategory(
                                    product.primary_category.name,
                                )}
                            </Link>
                        )}

                        <div className="mt-8 border-b border-stone-200 pb-8">
                            {product.brand && (
                                <p className="text-xs tracking-[0.24em] text-stone-500 uppercase">
                                    {product.brand}
                                </p>
                            )}
                            <h1 className="mt-3 font-serif text-5xl leading-none text-stone-950 md:text-7xl">
                                {product.name}
                            </h1>
                            <p className="mt-6 text-lg leading-8 text-stone-700">
                                {product.short_description}
                            </p>
                        </div>

                        <VariantSelector
                            copy={copy}
                            selectedVariant={selectedVariant}
                            variants={product.variants}
                            onSelect={setSelectedVariantId}
                        />

                        <div className="border-y border-stone-200 py-7">
                            <h2 className="text-sm font-medium tracking-wide text-stone-950 uppercase">
                                {copy.product.scentProfile}
                            </h2>
                            <div className="mt-5 grid gap-5">
                                {product.attribute_groups.map((group) => (
                                    <div
                                        key={group.code}
                                        className="grid gap-3 md:grid-cols-[7rem_1fr]"
                                    >
                                        <p className="text-sm text-stone-500">
                                            {group.name}
                                        </p>
                                        <div className="flex flex-wrap gap-2">
                                            {group.values.map((value) => (
                                                <span
                                                    key={value.id}
                                                    className="border border-stone-300 px-3 py-1.5 text-sm text-stone-700"
                                                >
                                                    {value.name}
                                                </span>
                                            ))}
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>

                        <div className="grid gap-5 py-7">
                            <h2 className="text-sm font-medium tracking-wide text-stone-950 uppercase">
                                {copy.product.description}
                            </h2>
                            <p className="text-base leading-8 text-stone-700">
                                {product.description}
                            </p>
                        </div>

                        <ContactActions contact={page.contact} copy={copy} />
                    </div>
                </div>
            </section>
        </PublicLayout>
    );
}

function VariantSelector({
    copy,
    selectedVariant,
    variants,
    onSelect,
}: {
    copy: PublicCopy;
    selectedVariant: PublicVariant | null;
    variants: PublicVariant[];
    onSelect: (variantId: number) => void;
}) {
    return (
        <section className="grid gap-5 py-7">
            <div className="flex items-end justify-between gap-4">
                <div>
                    <h2 className="text-sm font-medium tracking-wide text-stone-950 uppercase">
                        {copy.product.sizeTitle}
                    </h2>
                    <p className="mt-2 text-sm text-stone-500">
                        {copy.product.sizeHelp}
                    </p>
                </div>
                <p className="text-2xl font-medium text-stone-950 tabular-nums">
                    {selectedVariant
                        ? formatEuro(
                              selectedVariant.price,
                              copy.product.priceOnRequest,
                          )
                        : copy.product.priceOnRequest}
                </p>
            </div>

            <div className="grid grid-cols-3 gap-2">
                {variants.map((variant) => (
                    <button
                        key={variant.id}
                        type="button"
                        onClick={() => onSelect(variant.id)}
                        className={cn(
                            'border px-3 py-4 text-left transition',
                            selectedVariant?.id === variant.id
                                ? 'border-stone-950 bg-stone-950 text-white'
                                : 'border-stone-300 text-stone-800 hover:border-stone-950',
                        )}
                    >
                        <span className="block text-sm font-medium">
                            {variant.size}
                        </span>
                        <span className="mt-2 block text-sm tabular-nums opacity-75">
                            {formatEuro(
                                variant.price,
                                copy.product.priceOnRequest,
                            )}
                        </span>
                    </button>
                ))}
            </div>
        </section>
    );
}

function ContactActions({
    contact,
    copy,
}: {
    contact: PublicProductPageProps['contact'];
    copy: PublicCopy;
}) {
    const links = [
        {
            label: copy.contact.methods.whatsapp,
            value: contact.whatsapp_number,
            href: contact.whatsapp_url,
            icon: Send,
        },
        {
            label: copy.contact.methods.phone,
            value: contact.phone,
            href: contact.phone_url,
            icon: Phone,
        },
        {
            label: copy.contact.methods.email,
            value: contact.email,
            href: contact.email_url,
            icon: Mail,
        },
    ].filter((link) => link.href);

    if (links.length === 0) {
        return null;
    }

    return (
        <section className="grid gap-3 bg-stone-950 p-5 text-white">
            <p className="text-xs tracking-[0.22em] text-white/50 uppercase">
                {copy.product.inquiry}
            </p>
            <h2 className="font-serif text-3xl leading-tight">
                {copy.product.availabilityTitle}
            </h2>
            <div className="mt-3 grid gap-2">
                {links.map((link) => {
                    const Icon = link.icon;

                    return (
                        <a
                            key={link.label}
                            href={link.href ?? undefined}
                            className="flex items-center justify-between gap-4 border border-white/20 px-4 py-3 text-sm transition hover:bg-white hover:text-stone-950"
                        >
                            <span>
                                <span className="block font-medium">
                                    {link.label}
                                </span>
                                {link.value && (
                                    <span className="mt-1 block text-white/60">
                                        {link.value}
                                    </span>
                                )}
                            </span>
                            <Icon className="size-4" />
                        </a>
                    );
                })}
            </div>
        </section>
    );
}
