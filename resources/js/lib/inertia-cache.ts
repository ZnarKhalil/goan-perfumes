import type { InertiaLinkProps } from '@inertiajs/react';

export type InertiaLinkCacheProps = Pick<
    InertiaLinkProps,
    'cacheFor' | 'cacheTags' | 'prefetch'
>;

export const publicCacheTags = {
    layout: 'public:layout',
    content: 'public:content',
    catalog: 'public:catalog',
    categories: 'public:categories',
    products: 'public:products',
} as const;

export const publicCatalogCacheTags = [
    publicCacheTags.catalog,
    publicCacheTags.categories,
    publicCacheTags.products,
];

export const publicContentCacheTags = [
    publicCacheTags.content,
    publicCacheTags.layout,
];

export const publicAllCacheTags = [
    ...publicContentCacheTags,
    ...publicCatalogCacheTags,
];

export const publicNavigationPrefetch = {
    prefetch: true,
    cacheFor: ['1m', '5m'],
    cacheTags: [publicCacheTags.layout, publicCacheTags.content],
} satisfies InertiaLinkCacheProps;

export const publicHomePrefetch = {
    prefetch: true,
    cacheFor: ['45s', '3m'],
    cacheTags: publicAllCacheTags,
} satisfies InertiaLinkCacheProps;

export const publicCategoryPrefetch = {
    prefetch: true,
    cacheFor: ['45s', '3m'],
    cacheTags: [publicCacheTags.catalog, publicCacheTags.categories],
} satisfies InertiaLinkCacheProps;

export const publicProductPrefetch = {
    prefetch: true,
    cacheFor: ['30s', '2m'],
    cacheTags: [publicCacheTags.catalog, publicCacheTags.products],
} satisfies InertiaLinkCacheProps;

export const publicCatalogListProps = [
    'products',
    'filters',
    'selected_filters',
    'pagination',
    'meta',
];

export const publicSearchListProps = ['products', 'pagination', 'query', 'meta'];
