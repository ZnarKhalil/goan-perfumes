export const euroFormatter = new Intl.NumberFormat('de-DE', {
    style: 'currency',
    currency: 'EUR',
});

export function formatEuro(value: string | number | null): string {
    if (value === null || value === '') {
        return 'Preis auf Anfrage';
    }

    return euroFormatter.format(Number(value));
}

export function formatPriceRange(
    minPrice: string | null,
    maxPrice: string | null,
): string {
    if (!minPrice || !maxPrice) {
        return 'Preis auf Anfrage';
    }

    const min = formatEuro(minPrice);
    const max = formatEuro(maxPrice);

    return min === max ? min : `${min} - ${max}`;
}
