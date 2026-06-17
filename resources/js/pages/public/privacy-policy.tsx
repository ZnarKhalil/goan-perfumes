import { Head } from '@inertiajs/react';
import PublicLayout from '@/layouts/public-layout';
import type { PublicPrivacyPolicyPageProps } from '@/types/public';

const sections = [
    {
        title: '1. Verantwortlicher',
        body: [
            'Verantwortlich für diese Website ist Goan Perfume. Kontaktanfragen können über die auf der Kontaktseite angegebenen Kommunikationswege gestellt werden.',
        ],
    },
    {
        title: '2. Zugriffsdaten',
        body: [
            'Beim Besuch der Website können technisch notwendige Zugriffsdaten verarbeitet werden, zum Beispiel aufgerufene Seiten, Zeitpunkt des Zugriffs, Browser- und Geräteinformationen sowie IP-Adresse. Diese Daten dienen der sicheren und stabilen Bereitstellung der Website.',
        ],
    },
    {
        title: '3. Kontaktaufnahme',
        body: [
            'Wenn Sie uns per WhatsApp, Telefon, E-Mail oder Social Media kontaktieren, verarbeiten wir die von Ihnen übermittelten Angaben zur Bearbeitung Ihrer Anfrage. Je nach gewähltem Kontaktweg gelten zusätzlich die Datenschutzbedingungen des jeweiligen Anbieters.',
        ],
    },
    {
        title: '4. Cookies und Einwilligung',
        body: [
            'Wir verwenden notwendige Cookies, um Grundfunktionen der Website bereitzustellen, beispielsweise die Sprachwahl und Ihre Cookie-Auswahl. Optionale Analytics-Cookies werden nur gesetzt, wenn Sie ausdrücklich zustimmen.',
            'Sie können Ihre Auswahl jederzeit über den Link Cookie-Einstellungen im Footer ändern.',
        ],
    },
    {
        title: '5. Google Analytics',
        body: [
            'Diese Website verwendet Google Analytics 4, einen Webanalysedienst von Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Irland, sofern Sie Analytics-Cookies akzeptieren.',
            'Google Analytics hilft uns zu verstehen, welche Seiten, Kategorien und Produkte besucht werden. Dabei können Nutzungsdaten, Geräteinformationen, gekürzte oder anderweitig verarbeitete IP-Adressen und Interaktionsdaten verarbeitet werden. Die Verarbeitung erfolgt auf Grundlage Ihrer Einwilligung. Google kann Daten auch auf Servern außerhalb der Europäischen Union verarbeiten.',
            'Sie können Ihre Einwilligung jederzeit über die Cookie-Einstellungen widerrufen. Weitere Informationen finden Sie in den Datenschutzhinweisen von Google.',
        ],
    },
    {
        title: '6. Speicherdauer',
        body: [
            'Personenbezogene Daten werden nur so lange gespeichert, wie es für den jeweiligen Zweck erforderlich ist oder gesetzliche Aufbewahrungspflichten bestehen. Analytics-Daten werden nach den in Google Analytics konfigurierten Aufbewahrungsfristen gelöscht oder anonymisiert.',
        ],
    },
    {
        title: '7. Ihre Rechte',
        body: [
            'Sie haben nach Maßgabe der Datenschutz-Grundverordnung Rechte auf Auskunft, Berichtigung, Löschung, Einschränkung der Verarbeitung, Datenübertragbarkeit und Widerspruch. Sie können außerdem eine erteilte Einwilligung jederzeit mit Wirkung für die Zukunft widerrufen.',
        ],
    },
];

export default function PrivacyPolicy(page: PublicPrivacyPolicyPageProps) {
    return (
        <PublicLayout
            navigation={page.navigation}
            contact={page.contact}
            logo_url={page.logo_url}
            locale={page.locale}
        >
            <Head title={page.meta.title}>
                <meta name="description" content={page.meta.description} />
            </Head>

            <section className="px-4 py-16 md:px-8 md:py-24">
                <div className="mx-auto max-w-4xl">
                    <p className="text-[0.7rem] font-semibold tracking-[0.34em] text-stone-500 uppercase">
                        Datenschutz
                    </p>
                    <h1 className="mt-5 font-display text-5xl leading-tight font-light text-stone-950 md:text-6xl">
                        Datenschutzerklärung
                    </h1>
                    <p className="mt-6 max-w-3xl text-base leading-8 text-stone-600">
                        Diese Datenschutzerklärung informiert darüber, welche
                        personenbezogenen Daten bei der Nutzung dieser Website
                        verarbeitet werden und wie Sie Ihre Rechte ausüben
                        können.
                    </p>
                </div>
            </section>

            <section className="px-4 pb-24 md:px-8 md:pb-32">
                <div className="mx-auto grid max-w-4xl gap-10">
                    {sections.map((section) => (
                        <section
                            key={section.title}
                            className="border-t border-stone-200 pt-8"
                        >
                            <h2 className="font-display text-3xl font-light text-stone-950">
                                {section.title}
                            </h2>
                            <div className="mt-4 grid gap-4 text-base leading-8 text-stone-600">
                                {section.body.map((paragraph) => (
                                    <p key={paragraph}>{paragraph}</p>
                                ))}
                            </div>
                        </section>
                    ))}
                </div>
            </section>
        </PublicLayout>
    );
}
