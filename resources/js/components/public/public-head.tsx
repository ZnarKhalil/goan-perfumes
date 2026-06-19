import { Head } from '@inertiajs/react';
import type { PublicMeta } from '@/types/public';

type Props = {
    meta: PublicMeta;
};

export default function PublicHead({ meta }: Props) {
    const appName = import.meta.env.VITE_APP_NAME || 'Goan Perfume';
    const fullTitle = meta.title ? `${meta.title} - ${appName}` : appName;
    const twitterCard = meta.image_url ? 'summary_large_image' : 'summary';

    return (
        <Head title={meta.title}>
            <meta
                head-key="description"
                name="description"
                content={meta.description}
            />
            <meta head-key="og-title" property="og:title" content={fullTitle} />
            <meta
                head-key="og-description"
                property="og:description"
                content={meta.description}
            />
            <meta
                head-key="og-url"
                property="og:url"
                content={meta.canonical}
            />
            <meta
                head-key="og-type"
                property="og:type"
                content={meta.og_type}
            />
            <meta
                head-key="og-locale"
                property="og:locale"
                content={meta.og_locale}
            />
            <meta
                head-key="twitter-card"
                name="twitter:card"
                content={twitterCard}
            />
            <meta
                head-key="twitter-title"
                name="twitter:title"
                content={fullTitle}
            />
            <meta
                head-key="twitter-description"
                name="twitter:description"
                content={meta.description}
            />
            {meta.image_url && (
                <>
                    <meta
                        head-key="og-image"
                        property="og:image"
                        content={meta.image_url}
                    />
                    <meta
                        head-key="twitter-image"
                        name="twitter:image"
                        content={meta.image_url}
                    />
                </>
            )}
            <link head-key="canonical" rel="canonical" href={meta.canonical} />
            {meta.preload_image_url && (
                <link
                    head-key="preload-image"
                    rel="preload"
                    as="image"
                    href={meta.preload_image_url}
                    fetchPriority="high"
                />
            )}
            {meta.robots && (
                <meta head-key="robots" name="robots" content={meta.robots} />
            )}
            {Object.entries(meta.alternates).map(([hrefLang, href]) => (
                <link
                    key={hrefLang}
                    head-key={`alternate-${hrefLang}`}
                    rel="alternate"
                    hrefLang={hrefLang}
                    href={href}
                />
            ))}
            {meta.structured_data.map((item, index) => (
                <script
                    key={index}
                    head-key={`structured-data-${index}`}
                    type="application/ld+json"
                    dangerouslySetInnerHTML={{
                        __html: serializeStructuredData(item),
                    }}
                />
            ))}
        </Head>
    );
}

function serializeStructuredData(item: Record<string, unknown>): string {
    return JSON.stringify(item)
        .replace(/</g, '\\u003c')
        .replace(/>/g, '\\u003e')
        .replace(/&/g, '\\u0026')
        .replace(/\u2028/g, '\\u2028')
        .replace(/\u2029/g, '\\u2029');
}
