import type { PublicCopy } from '@/lib/public-copy';

export default function StoreDetails({
    copy,
    className,
}: {
    copy: PublicCopy;
    className?: string;
}) {
    return (
        <div className={className}>
            <div>
                <h2 className="text-xs font-semibold tracking-widest uppercase">
                    {copy.store.address}
                </h2>
                <address className="mt-3 text-sm leading-7 not-italic">
                    <bdi dir="ltr">Ludwigplatz 11</bdi>
                    <br />
                    <bdi dir="ltr">93309 Kelheim</bdi>
                </address>
            </div>
            <div>
                <h2 className="text-xs font-semibold tracking-widest uppercase">
                    {copy.store.openingHours}
                </h2>
                <dl className="mt-3 grid grid-cols-[max-content_max-content] justify-start gap-x-4 gap-y-2 text-sm leading-7">
                    <div className="contents">
                        <dt>{copy.store.weekdays}</dt>
                        <dd dir="ltr">10:00–18:00</dd>
                    </div>
                    <div className="contents">
                        <dt>{copy.store.sunday}</dt>
                        <dd>{copy.store.closed}</dd>
                    </div>
                </dl>
            </div>
        </div>
    );
}
