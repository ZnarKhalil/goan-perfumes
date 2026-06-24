import PublicHead from '@/components/public/public-head';
import PublicLayout from '@/layouts/public-layout';
import type { PublicLocaleCode, PublicTermsPageProps } from '@/types/public';

type TermsContent = {
    eyebrow: string;
    title: string;
    intro: string;
    sections: {
        title: string;
        body: string[];
    }[];
};

const content: Record<PublicLocaleCode, TermsContent> = {
    de: {
        eyebrow: 'Rechtliches',
        title: 'Allgemeine Geschäftsbedingungen',
        intro: 'Diese AGB gelten für alle geschäftlichen Kontakte zwischen Goan Perfume und dem Kunden, sowohl für den Direktverkauf im Ladenlokal als auch für Fernabsatzgeschäfte via WhatsApp.',
        sections: [
            {
                title: 'Betreiber',
                body: [
                    'Goan Perfume, Ludwigsplatz 11, 93309 Kelheim, Deutschland.',
                    'Telefon: +49 157 38149500, E-Mail: info@goanperfume.de. Die vollständigen Anbieterangaben finden Sie im Impressum.',
                ],
            },
            {
                title: '1. Geltungsbereich',
                body: [
                    'Diese AGB gelten für alle geschäftlichen Kontakte zwischen dem Anbieter und dem Kunden, sowohl für den Direktverkauf im Ladenlokal als auch für Fernabsatzgeschäfte via WhatsApp. Abweichende AGB des Kunden werden nicht Vertragsbestandteil, es sei denn, der Anbieter stimmt diesen ausdrücklich zu.',
                ],
            },
            {
                title: '2. Vertragsschluss',
                body: [
                    '2.1 Ladenverkauf: Der Vertrag kommt durch die Auswahl der Ware und die Bezahlung an der Kasse zustande.',
                    '2.2 WhatsApp-Bestellung: Der Kunde sendet eine Anfrage via WhatsApp. Der Anbieter übermittelt ein Angebot. Der Vertrag ist geschlossen, sobald der Kunde das Angebot bestätigt und der Anbieter den Auftrag final bestätigt.',
                ],
            },
            {
                title: '3. Preise und Versandkosten (EU-weit)',
                body: [
                    '3.1 Es gelten die zum Zeitpunkt der Anfrage genannten Preise inkl. MwSt.',
                    '3.2 Versandkosten innerhalb Deutschlands: Ab einem Warenwert von 80,00 € versandkostenfrei. Unter 80,00 € beträgt die Versandkostenpauschale 5,00 €.',
                    '3.2 Versandkosten innerhalb der EU (außerhalb Deutschlands): Ab einem Warenwert von 100,00 € versandkostenfrei. Unter 100,00 € beträgt die Versandkostenpauschale 15,00 €.',
                    '3.3 Fehlerhafte Adressdaten: Kosten, die durch eine vom Kunden falsch angegebene Lieferadresse oder Nichtannahme der Ware entstehen, sind vom Kunden zu tragen.',
                ],
            },
            {
                title: '4. Zahlung und Eigentumsvorbehalt',
                body: [
                    '4.1 Im Laden erfolgt die Zahlung in bar oder per Karte. Bei WhatsApp-Bestellungen erfolgt die Zahlung per Vorkasse.',
                    '4.2 Die Ware bleibt bis zur vollständigen Bezahlung Eigentum des Anbieters.',
                ],
            },
            {
                title: '5. Lieferung und Gefahrübergang',
                body: [
                    '5.1 Die Lieferung erfolgt nach Zahlungseingang an die angegebene Adresse innerhalb der Europäischen Union.',
                    '5.2 Die Gefahr des zufälligen Untergangs geht mit Übergabe an das Versandunternehmen auf den Kunden über.',
                ],
            },
            {
                title: '6. Widerrufsrecht und Rückgabebedingungen',
                body: [
                    '6.1 WhatsApp-Bestellung: Verbraucher haben ein 14-tägiges Widerrufsrecht. Bei versiegelten Waren, die aus Hygienegründen nicht zur Rückgabe geeignet sind, erlischt das Recht, wenn die Versiegelung nach der Lieferung entfernt wurde.',
                    '6.2 Ladenlokal: Es besteht kein gesetzliches Widerrufsrecht. Eine Rückgabe einwandfreier Ware erfolgt aus Kulanz ausschließlich gegen einen Warengutschein. Eine Barauszahlung ist ausgeschlossen. Ein Umtausch nach Öffnung der Versiegelung oder Originalverpackung ist aus hygienischen Gründen ausgeschlossen.',
                ],
            },
            {
                title: '7. Haftung',
                body: [
                    '7.1 Der Anbieter haftet für Mängel gemäß den gesetzlichen Bestimmungen. Bei leicht fahrlässigen Pflichtverletzungen ist die Haftung auf den vertragstypischen, vorhersehbaren Schaden begrenzt.',
                    '7.2 Allergie-Hinweis: Da es sich um kosmetische Produkte handelt, sollte die Verträglichkeit vor der Anwendung geprüft werden. Der Anbieter übernimmt keine Haftung für individuelle allergische Reaktionen, die auf die persönliche Beschaffenheit des Kunden zurückzuführen sind.',
                ],
            },
            {
                title: '8. Datenschutz und Kommunikation (WhatsApp)',
                body: [
                    '8.1 Personenbezogene Daten werden nur zur Vertragsabwicklung gespeichert.',
                    '8.2 Der Kunde erkennt an, dass die WhatsApp-Kommunikation über Server der Meta Platforms Ireland Ltd. erfolgt. Die Nutzung erfolgt auf eigene Verantwortung des Kunden.',
                ],
            },
            {
                title: '9. Schlussbestimmungen',
                body: [
                    '9.1 Es gilt das Recht der Bundesrepublik Deutschland. Gerichtsstand ist der Sitz des Anbieters (Kelheim).',
                    '9.2 Sollten einzelne Bestimmungen unwirksam sein, bleibt der Rest der AGB wirksam.',
                ],
            },
        ],
    },
    en: {
        eyebrow: 'Legal',
        title: 'Terms and conditions',
        intro: 'These terms and conditions apply to all business contact between Goan Perfume and the customer, both for direct sales in the store and for distance sales via WhatsApp.',
        sections: [
            {
                title: 'Operator',
                body: [
                    'Goan Perfume, Ludwigsplatz 11, 93309 Kelheim, Germany.',
                    'Phone: +49 157 38149500, email: info@goanperfume.de. Full provider details are available in the legal notice.',
                ],
            },
            {
                title: '1. Scope',
                body: [
                    'These terms apply to all business contact between the provider and the customer, both for direct sales in the store and for distance sales via WhatsApp. Deviating terms of the customer do not become part of the contract unless the provider expressly agrees to them.',
                ],
            },
            {
                title: '2. Conclusion of contract',
                body: [
                    '2.1 In-store sale: The contract is concluded by selecting the goods and paying at the checkout.',
                    '2.2 WhatsApp order: The customer sends a request via WhatsApp. The provider submits an offer. The contract is concluded once the customer confirms the offer and the provider finally confirms the order.',
                ],
            },
            {
                title: '3. Prices and shipping costs (EU-wide)',
                body: [
                    '3.1 The prices quoted at the time of the request, including VAT, apply.',
                    '3.2 Shipping costs within Germany: Free shipping from an order value of €80.00. Below €80.00, the flat-rate shipping fee is €5.00.',
                    '3.2 Shipping costs within the EU (outside Germany): Free shipping from an order value of €100.00. Below €100.00, the flat-rate shipping fee is €15.00.',
                    '3.3 Incorrect address data: Costs arising from a delivery address incorrectly provided by the customer or from non-acceptance of the goods are borne by the customer.',
                ],
            },
            {
                title: '4. Payment and retention of title',
                body: [
                    '4.1 In the store, payment is made in cash or by card. For WhatsApp orders, payment is made in advance.',
                    '4.2 The goods remain the property of the provider until full payment has been made.',
                ],
            },
            {
                title: '5. Delivery and transfer of risk',
                body: [
                    '5.1 Delivery is made after receipt of payment to the specified address within the European Union.',
                    '5.2 The risk of accidental loss passes to the customer upon handover to the shipping company.',
                ],
            },
            {
                title: '6. Right of withdrawal and return conditions',
                body: [
                    '6.1 WhatsApp order: Consumers have a 14-day right of withdrawal. For sealed goods that are not suitable for return for reasons of hygiene, the right expires if the seal was removed after delivery.',
                    '6.2 Store: There is no statutory right of withdrawal. A return of flawless goods is made as a goodwill gesture exclusively in exchange for a merchandise voucher. A cash refund is excluded. An exchange after opening the seal or original packaging is excluded for reasons of hygiene.',
                ],
            },
            {
                title: '7. Liability',
                body: [
                    '7.1 The provider is liable for defects in accordance with the statutory provisions. In the case of slightly negligent breaches of duty, liability is limited to the foreseeable damage typical for the contract.',
                    '7.2 Allergy notice: As these are cosmetic products, tolerance should be checked before use. The provider accepts no liability for individual allergic reactions that are attributable to the personal constitution of the customer.',
                ],
            },
            {
                title: '8. Data protection and communication (WhatsApp)',
                body: [
                    '8.1 Personal data is only stored for the purpose of processing the contract.',
                    '8.2 The customer acknowledges that WhatsApp communication takes place via servers of Meta Platforms Ireland Ltd. Use is at the customer’s own responsibility.',
                ],
            },
            {
                title: '9. Final provisions',
                body: [
                    '9.1 The law of the Federal Republic of Germany applies. The place of jurisdiction is the registered office of the provider (Kelheim).',
                    '9.2 Should individual provisions be invalid, the remainder of the terms remain effective.',
                ],
            },
        ],
    },
    ar: {
        eyebrow: 'قانوني',
        title: 'الشروط والأحكام',
        intro: 'تنطبق هذه الشروط والأحكام على جميع التعاملات التجارية بين Goan Perfume والعميل، سواء في البيع المباشر داخل المتجر أو في معاملات البيع عن بُعد عبر واتساب.',
        sections: [
            {
                title: 'المشغّل',
                body: [
                    'Goan Perfume، Ludwigsplatz 11، 93309 Kelheim، ألمانيا.',
                    'الهاتف: +49 157 38149500، البريد الإلكتروني: info@goanperfume.de. تتوفر بيانات المزوّد الكاملة في صفحة البيانات القانونية.',
                ],
            },
            {
                title: '1. نطاق التطبيق',
                body: [
                    'تنطبق هذه الشروط على جميع التعاملات التجارية بين المزوّد والعميل، سواء في البيع المباشر داخل المتجر أو في معاملات البيع عن بُعد عبر واتساب. لا تصبح الشروط المخالفة الخاصة بالعميل جزءاً من العقد ما لم يوافق المزوّد عليها صراحةً.',
                ],
            },
            {
                title: '2. إبرام العقد',
                body: [
                    '2.1 البيع في المتجر: يُبرم العقد باختيار البضاعة ودفع ثمنها عند الصندوق.',
                    '2.2 الطلب عبر واتساب: يرسل العميل طلباً عبر واتساب. يقدّم المزوّد عرضاً. يُبرم العقد بمجرد تأكيد العميل للعرض وتأكيد المزوّد النهائي للطلب.',
                ],
            },
            {
                title: '3. الأسعار وتكاليف الشحن (داخل الاتحاد الأوروبي)',
                body: [
                    '3.1 تُطبَّق الأسعار المذكورة وقت الطلب شاملةً ضريبة القيمة المضافة.',
                    '3.2 تكاليف الشحن داخل ألمانيا: شحن مجاني ابتداءً من قيمة طلب 80,00 €. وبأقل من 80,00 € تبلغ رسوم الشحن المقطوعة 5,00 €.',
                    '3.2 تكاليف الشحن داخل الاتحاد الأوروبي (خارج ألمانيا): شحن مجاني ابتداءً من قيمة طلب 100,00 €. وبأقل من 100,00 € تبلغ رسوم الشحن المقطوعة 15,00 €.',
                    '3.3 بيانات العنوان الخاطئة: يتحمّل العميل التكاليف الناشئة عن عنوان تسليم خاطئ قدّمه العميل أو عن عدم استلام البضاعة.',
                ],
            },
            {
                title: '4. الدفع والاحتفاظ بحق الملكية',
                body: [
                    '4.1 في المتجر يتم الدفع نقداً أو بالبطاقة. وفي طلبات واتساب يتم الدفع مقدماً.',
                    '4.2 تبقى البضاعة ملكاً للمزوّد حتى سداد كامل الثمن.',
                ],
            },
            {
                title: '5. التسليم وانتقال المخاطر',
                body: [
                    '5.1 يتم التسليم بعد استلام الدفعة إلى العنوان المحدد داخل الاتحاد الأوروبي.',
                    '5.2 تنتقل مخاطر التلف العرضي إلى العميل عند تسليم البضاعة لشركة الشحن.',
                ],
            },
            {
                title: '6. حق الانسحاب وشروط الإرجاع',
                body: [
                    '6.1 الطلب عبر واتساب: للمستهلكين حق انسحاب لمدة 14 يوماً. وبالنسبة للبضائع المختومة غير الصالحة للإرجاع لأسباب صحية، يسقط هذا الحق إذا أُزيل الختم بعد التسليم.',
                    '6.2 المتجر: لا يوجد حق انسحاب قانوني. ويتم إرجاع البضاعة السليمة على سبيل المجاملة مقابل قسيمة شراء فقط. ولا يجوز الاسترداد النقدي. كما يُستبعد الاستبدال بعد فتح الختم أو العبوة الأصلية لأسباب صحية.',
                ],
            },
            {
                title: '7. المسؤولية',
                body: [
                    '7.1 يتحمّل المزوّد المسؤولية عن العيوب وفقاً للأحكام القانونية. وفي حالات الإخلال البسيط بالالتزامات، تقتصر المسؤولية على الضرر المتوقع والمعتاد للعقد.',
                    '7.2 تنبيه بشأن الحساسية: نظراً لأن هذه منتجات تجميلية، يُنصح بفحص مدى التحمّل قبل الاستخدام. لا يتحمّل المزوّد أي مسؤولية عن ردود الفعل التحسسية الفردية الناتجة عن الطبيعة الشخصية للعميل.',
                ],
            },
            {
                title: '8. حماية البيانات والتواصل (واتساب)',
                body: [
                    '8.1 لا تُخزَّن البيانات الشخصية إلا لغرض تنفيذ العقد.',
                    '8.2 يقرّ العميل بأن التواصل عبر واتساب يتم من خلال خوادم Meta Platforms Ireland Ltd. ويكون الاستخدام على مسؤولية العميل الخاصة.',
                ],
            },
            {
                title: '9. أحكام ختامية',
                body: [
                    '9.1 يُطبَّق قانون جمهورية ألمانيا الاتحادية. ويكون مكان الاختصاص القضائي هو مقر المزوّد (Kelheim).',
                    '9.2 إذا كانت بعض الأحكام غير سارية، تبقى بقية الشروط سارية المفعول.',
                ],
            },
        ],
    },
};

export default function Terms(page: PublicTermsPageProps) {
    const locale = page.locale?.current ?? 'de';
    const copy = content[locale];

    return (
        <PublicLayout
            navigation={page.navigation}
            contact={page.contact}
            logo_url={page.logo_url}
            locale={page.locale}
        >
            <PublicHead meta={page.meta} />

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
