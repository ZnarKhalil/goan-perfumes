import CtaLink from '@/components/public/home/cta-link';
import Reveal from '@/components/public/home/reveal';
import type { PublicCopy } from '@/lib/public-copy';

type Props = {
    copy: PublicCopy;
    whatsappUrl: string | null;
};

export default function Advice({ copy, whatsappUrl }: Props) {
    return (
        <section className="relative px-4 pt-10 pb-28 md:px-8 md:pb-36">
            <Reveal className="mx-auto max-w-7xl">
                <div className="relative overflow-hidden rounded-[2rem] border border-white/10 bg-white/[0.03] px-6 py-16 backdrop-blur-xl md:px-16 md:py-24">
                    <div className="absolute -top-24 left-1/2 h-64 w-[120%] -translate-x-1/2 bg-[radial-gradient(closest-side,rgba(231,200,137,0.18),transparent)]" />
                    <div className="absolute inset-x-16 top-0 h-px bg-linear-to-r from-transparent via-[#e7c889]/55 to-transparent" />

                    <div className="relative flex flex-col items-start justify-between gap-10 md:flex-row md:items-end">
                        <div>
                            <p className="flex items-center gap-3 text-[0.7rem] font-medium tracking-[0.38em] text-[#e7c889] uppercase">
                                <span className="h-px w-10 bg-[#e7c889]/60" />
                                {copy.home.adviceEyebrow}
                            </p>
                            <h2 className="mt-6 max-w-2xl font-display text-3xl leading-[1.1] font-light text-stone-50 md:text-5xl">
                                {copy.home.adviceTitle}
                            </h2>
                        </div>

                        {whatsappUrl && (
                            <CtaLink
                                href={whatsappUrl}
                                external
                                className="shrink-0"
                            >
                                {copy.home.whatsappCta}
                            </CtaLink>
                        )}
                    </div>
                </div>
            </Reveal>
        </section>
    );
}
