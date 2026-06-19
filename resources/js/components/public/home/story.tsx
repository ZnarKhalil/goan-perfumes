import { motion, useReducedMotion } from 'motion/react';
import Reveal from '@/components/public/home/reveal';
import type { PublicCopy } from '@/lib/public-copy';
import type { PublicBulletSection, PublicTextSection } from '@/types/public';

type Props = {
    about: PublicTextSection;
    whyUs: PublicBulletSection;
    copy: PublicCopy;
};

export default function Story({ about, whyUs, copy }: Props) {
    const reduceMotion = useReducedMotion();

    return (
        <section className="relative px-4 py-24 md:px-8 md:py-36">
            <div className="mx-auto grid max-w-7xl gap-16 lg:grid-cols-[0.95fr_1.05fr] lg:gap-24">
                <div className="lg:sticky lg:top-28 lg:self-start">
                    <Reveal>
                        <p className="flex items-center gap-3 text-[0.7rem] font-medium tracking-[0.38em] text-[#e7c889] uppercase">
                            <span className="h-px w-10 bg-[#e7c889]/60" />
                            {copy.home.aboutEyebrow}
                        </p>
                        <h2 className="mt-6 font-display text-4xl leading-[1.05] font-light text-stone-50 md:text-6xl">
                            {about.title}
                        </h2>
                        <p className="mt-7 max-w-xl text-base leading-8 text-stone-300 md:text-lg">
                            {about.body}
                        </p>
                    </Reveal>
                </div>

                <div>
                    <Reveal>
                        <h3 className="font-display text-2xl font-light text-stone-200 md:text-3xl">
                            {whyUs.title}
                        </h3>
                    </Reveal>

                    <ul className="mt-10">
                        {whyUs.items.map((item, index) => (
                            <Reveal
                                as="li"
                                key={item}
                                delay={index * 0.08}
                                blur={false}
                                className="group grid grid-cols-[3.5rem_1fr] items-start gap-5 py-7"
                            >
                                <span className="font-display text-2xl text-[#e7c889]/70 tabular-nums">
                                    {String(index + 1).padStart(2, '0')}
                                </span>
                                <div>
                                    <p className="text-lg leading-8 text-stone-200 transition-colors duration-500 group-hover:text-stone-50 md:text-xl">
                                        {item}
                                    </p>
                                    <motion.span
                                        className="mt-7 block h-px origin-left bg-linear-to-r from-[#e7c889]/50 via-white/15 to-transparent"
                                        initial={
                                            reduceMotion ? false : { scaleX: 0 }
                                        }
                                        whileInView={{ scaleX: 1 }}
                                        viewport={{ once: true }}
                                        transition={{
                                            duration: 1.1,
                                            delay: 0.1 + index * 0.08,
                                            ease: [0.16, 1, 0.3, 1],
                                        }}
                                    />
                                </div>
                            </Reveal>
                        ))}
                    </ul>
                </div>
            </div>
        </section>
    );
}
