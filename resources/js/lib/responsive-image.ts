const publicStoragePrefix = '/storage/';

export function responsiveImageUrl(
    source: string,
    width: number,
): string | null {
    if (!source.startsWith(publicStoragePrefix)) {
        return null;
    }

    const path = source
        .slice(publicStoragePrefix.length)
        .split('/')
        .map(encodeURIComponent)
        .join('/');

    return `/media/${width}/${path}`;
}

export function responsiveImageSrcSet(
    source: string,
    widths: number[],
): string | undefined {
    const candidates = widths
        .map((width) => {
            const url = responsiveImageUrl(source, width);

            return url ? `${url} ${width}w` : null;
        })
        .filter((candidate): candidate is string => candidate !== null);

    return candidates.length > 0 ? candidates.join(', ') : undefined;
}
