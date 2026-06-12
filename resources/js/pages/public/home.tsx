import { Head } from '@inertiajs/react';
import Advice from '@/components/public/home/advice';
import Atmosphere from '@/components/public/home/atmosphere';
import Collections from '@/components/public/home/collections';
import Hero from '@/components/public/home/hero';
import Offers from '@/components/public/home/offers';
import ProductVitrine from '@/components/public/home/product-vitrine';
import Story from '@/components/public/home/story';
import PublicLayout from '@/layouts/public-layout';
import { getPublicCopy } from '@/lib/public-copy';
import type { PublicHomePageProps } from '@/types/public';

export default function Home(page: PublicHomePageProps) {
    const copy = getPublicCopy(page.locale);
    const locale = page.locale?.current ?? 'de';
    const luxuryHref =
        page.navigation.find((category) => category.slug === 'luxusparfums')
            ?.href ?? `/${locale}`;
    const contactHref = `/${locale}/kontakt`;

    return (
        <PublicLayout
            navigation={page.navigation}
            contact={page.contact}
            logo_url={page.logo_url}
            locale={page.locale}
            theme="dark"
        >
            <Head title={page.meta.title}>
                <meta name="description" content={page.meta.description} />
            </Head>

            <Atmosphere />

            <Hero
                hero={page.page_sections.hero}
                copy={copy}
                ctaHref={luxuryHref}
                contactHref={contactHref}
            />

            <Offers
                offers={page.promotions}
                copy={copy}
                shopHref={luxuryHref}
            />

            <ProductVitrine
                products={page.featured_products}
                copy={copy}
                eyebrow={copy.home.featuredEyebrow}
                title={copy.home.featuredTitle}
                seeAllHref={luxuryHref}
                seeAllLabel={copy.home.luxuryLink}
                emptyMessage={copy.home.featuredEmpty}
            />

            <Collections
                categories={page.navigation}
                eyebrow={copy.home.collectionsEyebrow}
                title={copy.home.collectionsTitle}
            />

            <Story
                about={page.page_sections.about}
                whyUs={page.page_sections.why_us}
                copy={copy}
            />

            <Advice
                copy={copy}
                whatsappUrl={page.contact.whatsapp_url}
            />
        </PublicLayout>
    );
}
