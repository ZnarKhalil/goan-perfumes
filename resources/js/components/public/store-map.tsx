import type { PublicCopy } from '@/lib/public-copy';

export default function StoreMap({ copy }: { copy: PublicCopy }) {
    return (
        <div className="mx-auto max-w-7xl overflow-hidden rounded-[1.4rem] border border-white/10">
            <iframe
                title={`${copy.store.address} — Goan Perfume, Ludwigplatz 11, Kelheim`}
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2621.861927555412!2d11.873508699999997!3d48.918022799999996!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x479fbb001131c907%3A0xe678c0ef1c318bf9!2sGoan%20Perfume!5e0!3m2!1sen!2sde!4v1789225993063!5m2!1sen!2sde"
                className="block h-96 w-full border-0 bg-stone-200 md:h-[32rem]"
                loading="lazy"
                referrerPolicy="strict-origin-when-cross-origin"
                allowFullScreen
            />
            <div className="flex flex-wrap items-center justify-between gap-4 bg-white/[0.035] px-6 py-5 text-sm text-stone-300">
                <address className="not-italic">
                    <bdi dir="ltr">Ludwigplatz 11, 93309 Kelheim</bdi>
                </address>
                <a
                    href="https://maps.app.goo.gl/iKsFCmr1CFUeqgqr9"
                    target="_blank"
                    rel="noopener noreferrer"
                    className="rounded-sm text-[#e7c889] underline underline-offset-4 transition-colors hover:text-stone-50 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-[#e7c889]"
                >
                    {copy.store.openMap}
                </a>
            </div>
        </div>
    );
}
