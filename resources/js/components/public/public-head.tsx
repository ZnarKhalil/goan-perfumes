import { Head } from '@inertiajs/react';
import type { PublicMeta } from '@/types/public';

type Props = {
    meta: PublicMeta;
};

export default function PublicHead({ meta }: Props) {
    return (
        <Head title={meta.title}>
            <meta
                head-key="description"
                name="description"
                content={meta.description}
            />
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
