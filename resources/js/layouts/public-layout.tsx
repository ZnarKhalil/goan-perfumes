import FloatingContactSidebar from '@/components/public/floating-contact-sidebar';
import SiteHeader from '@/components/public/site-header';
import type { PublicLayoutProps } from '@/types/public';

export default function PublicLayout({
    navigation,
    contact,
    logo_url,
    children,
}: PublicLayoutProps) {
    return (
        <div className="min-h-screen bg-[#fbf8f2] text-stone-950 antialiased">
            <SiteHeader
                navigation={navigation}
                contact={contact}
                logoUrl={logo_url}
            />
            <main>{children}</main>
            <FloatingContactSidebar contact={contact} />
            <footer className="border-t border-stone-200 px-4 py-8 text-sm text-stone-500 md:px-8">
                <div className="mx-auto flex max-w-7xl flex-col gap-3 md:flex-row md:items-center md:justify-between">
                    <p>Goan Perfume</p>
                    <p>
                        Produkt-Showcase ohne Online-Shop. Kontakt direkt per
                        WhatsApp, Telefon oder E-Mail.
                    </p>
                </div>
            </footer>
        </div>
    );
}
