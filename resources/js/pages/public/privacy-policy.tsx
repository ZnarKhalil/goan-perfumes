import { Head } from '@inertiajs/react';
import PublicLayout from '@/layouts/public-layout';
import type {
    PublicLocaleCode,
    PublicPrivacyPolicyPageProps,
} from '@/types/public';

type PrivacyContent = {
    eyebrow: string;
    title: string;
    intro: string;
    sections: {
        title: string;
        body: string[];
    }[];
};

const content: Record<PublicLocaleCode, PrivacyContent> = {
    de: {
        eyebrow: 'Datenschutz',
        title: 'Datenschutzerklärung',
        intro: 'Diese Datenschutzerklärung informiert darüber, welche personenbezogenen Daten bei der Nutzung dieser Website verarbeitet werden und wie Sie Ihre Rechte ausüben können.',
        sections: [
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
        ],
    },
    en: {
        eyebrow: 'Privacy',
        title: 'Privacy policy',
        intro: 'This privacy policy explains which personal data may be processed when you use this website and how you can exercise your rights.',
        sections: [
            {
                title: '1. Controller',
                body: [
                    'The controller responsible for this website is Goan Perfume. Contact requests can be made through the communication channels listed on the contact page.',
                ],
            },
            {
                title: '2. Access data',
                body: [
                    'When you visit the website, technically necessary access data may be processed, such as visited pages, access time, browser and device information, and IP address. This data is used to provide the website securely and reliably.',
                ],
            },
            {
                title: '3. Contact requests',
                body: [
                    'If you contact us by WhatsApp, phone, email, or social media, we process the information you provide in order to handle your request. Depending on the communication channel, the privacy terms of the respective provider may also apply.',
                ],
            },
            {
                title: '4. Cookies and consent',
                body: [
                    'We use necessary cookies to provide basic website functions, such as language preference and your cookie choice. Optional analytics cookies are only set if you explicitly consent.',
                    'You can change your choice at any time using the cookie settings link in the footer.',
                ],
            },
            {
                title: '5. Google Analytics',
                body: [
                    'This website uses Google Analytics 4, a web analytics service provided by Google Ireland Limited, Gordon House, Barrow Street, Dublin 4, Ireland, if you accept analytics cookies.',
                    'Google Analytics helps us understand which pages, categories, and products are visited. Usage data, device information, shortened or otherwise processed IP addresses, and interaction data may be processed. Processing is based on your consent. Google may also process data on servers outside the European Union.',
                    'You can withdraw your consent at any time through the cookie settings. More information is available in Google’s privacy notices.',
                ],
            },
            {
                title: '6. Retention period',
                body: [
                    'Personal data is stored only for as long as required for the relevant purpose or as required by statutory retention obligations. Analytics data is deleted or anonymized according to the retention settings configured in Google Analytics.',
                ],
            },
            {
                title: '7. Your rights',
                body: [
                    'Under the General Data Protection Regulation, you have rights to access, rectification, erasure, restriction of processing, data portability, and objection. You may also withdraw any consent you have given at any time with effect for the future.',
                ],
            },
        ],
    },
    ar: {
        eyebrow: 'الخصوصية',
        title: 'سياسة الخصوصية',
        intro: 'توضح سياسة الخصوصية هذه البيانات الشخصية التي قد تتم معالجتها عند استخدام هذا الموقع وكيف يمكنك ممارسة حقوقك.',
        sections: [
            {
                title: '1. الجهة المسؤولة',
                body: [
                    'الجهة المسؤولة عن هذا الموقع هي Goan Perfume. يمكن إرسال طلبات التواصل عبر وسائل الاتصال الموضحة في صفحة التواصل.',
                ],
            },
            {
                title: '2. بيانات الوصول',
                body: [
                    'عند زيارة الموقع، قد تتم معالجة بيانات وصول ضرورية تقنياً، مثل الصفحات التي تمت زيارتها، ووقت الوصول، ومعلومات المتصفح والجهاز، وعنوان IP. تُستخدم هذه البيانات لتوفير الموقع بشكل آمن ومستقر.',
                ],
            },
            {
                title: '3. التواصل معنا',
                body: [
                    'إذا تواصلت معنا عبر واتساب أو الهاتف أو البريد الإلكتروني أو وسائل التواصل الاجتماعي، فإننا نعالج المعلومات التي ترسلها إلينا للرد على طلبك. وبحسب وسيلة التواصل المختارة، قد تنطبق أيضاً شروط الخصوصية الخاصة بمزود الخدمة المعني.',
                ],
            },
            {
                title: '4. ملفات تعريف الارتباط والموافقة',
                body: [
                    'نستخدم ملفات تعريف الارتباط الضرورية لتوفير الوظائف الأساسية للموقع، مثل تفضيل اللغة واختيار ملفات تعريف الارتباط. لا يتم استخدام ملفات تعريف الارتباط الاختيارية الخاصة بالتحليلات إلا إذا وافقت عليها صراحة.',
                    'يمكنك تغيير اختيارك في أي وقت من خلال رابط إعدادات ملفات تعريف الارتباط في أسفل الصفحة.',
                ],
            },
            {
                title: '5. Google Analytics',
                body: [
                    'يستخدم هذا الموقع Google Analytics 4، وهي خدمة تحليل ويب مقدمة من Google Ireland Limited، Gordon House, Barrow Street, Dublin 4, Ireland، وذلك إذا وافقت على ملفات تعريف الارتباط الخاصة بالتحليلات.',
                    'يساعدنا Google Analytics على فهم الصفحات والفئات والمنتجات التي تتم زيارتها. قد تتم معالجة بيانات الاستخدام ومعلومات الجهاز وعناوين IP المختصرة أو المعالجة بطرق أخرى وبيانات التفاعل. تتم المعالجة بناءً على موافقتك. وقد تعالج Google البيانات أيضاً على خوادم خارج الاتحاد الأوروبي.',
                    'يمكنك سحب موافقتك في أي وقت من خلال إعدادات ملفات تعريف الارتباط. تتوفر معلومات إضافية في إشعارات الخصوصية الخاصة بـ Google.',
                ],
            },
            {
                title: '6. مدة الاحتفاظ',
                body: [
                    'لا يتم الاحتفاظ بالبيانات الشخصية إلا للمدة اللازمة للغرض المعني أو وفقاً للالتزامات القانونية الخاصة بالاحتفاظ. يتم حذف بيانات التحليلات أو إخفاء هويتها وفقاً لإعدادات الاحتفاظ المكونة في Google Analytics.',
                ],
            },
            {
                title: '7. حقوقك',
                body: [
                    'وفقاً للائحة العامة لحماية البيانات، لديك حقوق في الوصول إلى البيانات وتصحيحها وحذفها وتقييد معالجتها ونقلها والاعتراض على معالجتها. كما يمكنك سحب أي موافقة منحتها في أي وقت بأثر مستقبلي.',
                ],
            },
        ],
    },
};

export default function PrivacyPolicy(page: PublicPrivacyPolicyPageProps) {
    const locale = page.locale?.current ?? 'de';
    const copy = content[locale];

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
                        {copy.eyebrow}
                    </p>
                    <h1 className="mt-5 font-display text-5xl leading-tight font-light text-stone-950 md:text-6xl">
                        {copy.title}
                    </h1>
                    <p className="mt-6 max-w-3xl text-base leading-8 text-stone-600">
                        {copy.intro}
                    </p>
                </div>
            </section>

            <section className="px-4 pb-24 md:px-8 md:pb-32">
                <div className="mx-auto grid max-w-4xl gap-10">
                    {copy.sections.map((section) => (
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
