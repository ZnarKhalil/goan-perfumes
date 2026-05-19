export const euroFormatter = new Intl.NumberFormat('de-DE', {
    style: 'currency',
    currency: 'EUR',
});

export function formatEuro(
    value: string | number | null,
    fallback: string,
): string {
    if (value === null || value === '') {
        return fallback;
    }

    return euroFormatter.format(Number(value));
}

export function formatPriceRange(
    minPrice: string | null,
    maxPrice: string | null,
    fallback: string,
): string {
    if (!minPrice || !maxPrice) {
        return fallback;
    }

    const min = formatEuro(minPrice, fallback);
    const max = formatEuro(maxPrice, fallback);

    return min === max ? min : `${min} - ${max}`;
}
