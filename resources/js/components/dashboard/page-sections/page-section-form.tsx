import { Link, useForm } from '@inertiajs/react';
import { ArrowDown, ArrowUp, Plus, Trash2 } from 'lucide-react';
import type { FormEvent } from 'react';
import MediaUploader from '@/components/dashboard/media-uploader';
import TranslationTabs from '@/components/dashboard/translation-tabs';
import type {
    TranslationField,
    TranslationLocale,
} from '@/components/dashboard/translation-tabs';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import pageSectionsRoutes from '@/routes/dashboard/page-sections';

const LOCALES = [
    { code: 'de', label: 'Deutsch' },
    { code: 'ar', label: 'العربية' },
    { code: 'en', label: 'English' },
] as const;

const HERO_FIELDS: TranslationField[] = [
    { name: 'title', label: 'Titel' },
    { name: 'body', label: 'Text', type: 'textarea', rows: 3 },
    { name: 'cta_text', label: 'Button-Text' },
];

const TEXT_FIELDS: TranslationField[] = [
    { name: 'title', label: 'Titel' },
    { name: 'body', label: 'Text', type: 'textarea', rows: 6 },
];

export type PageSectionKey = 'hero' | 'about' | 'why_us' | 'featured_products';

export type PageSectionTranslations = Record<
    TranslationLocale,
    {
        title: string;
        body: string;
        cta_text: string;
        bullet_points: string[];
    }
>;

type ProductOption = {
    id: number;
    name: string;
    brand: string | null;
};

type Props = {
    section: {
        id: number;
        key: PageSectionKey;
        label: string;
        payload: {
            image_path?: string | null;
            product_ids?: number[];
        };
        image_url: string | null;
        sort_order: number;
        is_active: boolean;
        translations: PageSectionTranslations;
    };
    products: ProductOption[];
};

type FormData = {
    hero_image: File | null;
    remove_hero_image: boolean;
    sort_order: number;
    is_active: boolean;
    payload: {
        product_ids: number[];
    };
    translations: PageSectionTranslations;
    _method: 'PUT';
};

export default function PageSectionForm({ section, products }: Props) {
    const { data, setData, post, processing, errors } = useForm<FormData>({
        hero_image: null,
        remove_hero_image: false,
        sort_order: section.sort_order,
        is_active: section.is_active,
        payload: {
            product_ids: section.payload.product_ids ?? [],
        },
        translations: withDefaultTranslations(section.translations),
        _method: 'PUT',
    });
    const flatErrors = errors as Record<string, string | undefined>;

    const submit = (event: FormEvent) => {
        event.preventDefault();

        post(pageSectionsRoutes.update({ page_section: section.id }).url, {
            forceFormData: true,
            preserveScroll: true,
        });
    };

    const setTranslation = (
        locale: TranslationLocale,
        field: string,
        value: string,
    ) => {
        setData('translations', {
            ...data.translations,
            [locale]: {
                ...data.translations[locale],
                [field]: value,
            },
        });
    };

    const setBullet = (
        locale: TranslationLocale,
        index: number,
        value: string,
    ) => {
        const bullets = [...data.translations[locale].bullet_points];
        bullets[index] = value;
        setData('translations', {
            ...data.translations,
            [locale]: {
                ...data.translations[locale],
                bullet_points: bullets,
            },
        });
    };

    const addBullet = (locale: TranslationLocale) => {
        setData('translations', {
            ...data.translations,
            [locale]: {
                ...data.translations[locale],
                bullet_points: [...data.translations[locale].bullet_points, ''],
            },
        });
    };

    const removeBullet = (locale: TranslationLocale, index: number) => {
        setData('translations', {
            ...data.translations,
            [locale]: {
                ...data.translations[locale],
                bullet_points: data.translations[locale].bullet_points.filter(
                    (_, itemIndex) => itemIndex !== index,
                ),
            },
        });
    };

    const toggleProduct = (productId: number, checked: boolean) => {
        const productIds = checked
            ? [...data.payload.product_ids, productId]
            : data.payload.product_ids.filter((id) => id !== productId);

        setData('payload', { product_ids: productIds });
    };

    const moveProduct = (productId: number, direction: -1 | 1) => {
        const index = data.payload.product_ids.indexOf(productId);
        const target = index + direction;

        if (
            index < 0 ||
            target < 0 ||
            target >= data.payload.product_ids.length
        ) {
            return;
        }

        const productIds = [...data.payload.product_ids];
        [productIds[index], productIds[target]] = [
            productIds[target],
            productIds[index],
        ];
        setData('payload', { product_ids: productIds });
    };

    const selectedProducts = data.payload.product_ids
        .map((id) => products.find((product) => product.id === id))
        .filter((product): product is ProductOption => product !== undefined);

    return (
        <form
            onSubmit={submit}
            className="grid gap-8"
            encType="multipart/form-data"
        >
            <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <h3 className="text-sm font-medium">Einstellungen</h3>
                <div className="grid gap-4 md:grid-cols-2">
                    <div className="grid gap-2">
                        <Label htmlFor="sort_order">Reihenfolge</Label>
                        <Input
                            id="sort_order"
                            type="number"
                            min={0}
                            value={data.sort_order}
                            onChange={(event) =>
                                setData(
                                    'sort_order',
                                    Number(event.target.value || 0),
                                )
                            }
                        />
                        <InputError message={errors.sort_order} />
                    </div>
                    <div className="flex items-center gap-2 pt-7">
                        <Checkbox
                            id="is_active"
                            checked={data.is_active}
                            onCheckedChange={(checked) =>
                                setData('is_active', checked === true)
                            }
                        />
                        <Label htmlFor="is_active">Aktiv</Label>
                    </div>
                </div>
            </section>

            {section.key === 'hero' && (
                <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                    <h3 className="text-sm font-medium">Hero</h3>
                    <TranslationTabs
                        fields={HERO_FIELDS}
                        values={stringTranslations(data.translations)}
                        errors={flatErrors}
                        requiredFields={['title']}
                        onChange={setTranslation}
                    />
                    <MediaUploader
                        mode="single"
                        label="Hero-Bild"
                        value={data.hero_image}
                        existingUrl={
                            data.remove_hero_image ? null : section.image_url
                        }
                        onChange={(file) => {
                            setData('hero_image', file);

                            if (file) {
                                setData('remove_hero_image', false);
                            }
                        }}
                        onRemove={() => setData('remove_hero_image', true)}
                        error={errors.hero_image}
                    />
                </section>
            )}

            {section.key === 'about' && (
                <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                    <h3 className="text-sm font-medium">Über uns</h3>
                    <TranslationTabs
                        fields={TEXT_FIELDS}
                        values={stringTranslations(data.translations)}
                        errors={flatErrors}
                        requiredFields={['title', 'body']}
                        onChange={setTranslation}
                    />
                </section>
            )}

            {section.key === 'why_us' && (
                <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                    <h3 className="text-sm font-medium">Warum GOAN</h3>
                    <Tabs defaultValue="de" className="w-full">
                        <TabsList>
                            {LOCALES.map((locale) => (
                                <TabsTrigger
                                    key={locale.code}
                                    value={locale.code}
                                >
                                    {locale.label}
                                    {locale.code === 'de' && (
                                        <span className="ml-1 text-destructive">
                                            *
                                        </span>
                                    )}
                                </TabsTrigger>
                            ))}
                        </TabsList>
                        {LOCALES.map((locale) => (
                            <TabsContent
                                key={locale.code}
                                value={locale.code}
                                className="space-y-4 pt-4"
                                dir={locale.code === 'ar' ? 'rtl' : undefined}
                            >
                                <div className="grid gap-2">
                                    <Label htmlFor={`${locale.code}-title`}>
                                        Titel
                                        {locale.code === 'de' && (
                                            <span className="ml-1 text-destructive">
                                                *
                                            </span>
                                        )}
                                    </Label>
                                    <Input
                                        id={`${locale.code}-title`}
                                        value={
                                            data.translations[locale.code].title
                                        }
                                        onChange={(event) =>
                                            setTranslation(
                                                locale.code,
                                                'title',
                                                event.target.value,
                                            )
                                        }
                                    />
                                    <InputError
                                        message={
                                            flatErrors[
                                                `translations.${locale.code}.title`
                                            ]
                                        }
                                    />
                                </div>
                                <div className="grid gap-3">
                                    <div className="flex items-center justify-between gap-3">
                                        <Label>Bullet Points</Label>
                                        <Button
                                            type="button"
                                            variant="outline"
                                            size="sm"
                                            onClick={() =>
                                                addBullet(locale.code)
                                            }
                                        >
                                            <Plus className="mr-1 h-4 w-4" />
                                            Punkt
                                        </Button>
                                    </div>
                                    {data.translations[
                                        locale.code
                                    ].bullet_points.map((bullet, index) => (
                                        <div
                                            key={`${locale.code}-${index}`}
                                            className="flex items-start gap-2"
                                        >
                                            <Input
                                                value={bullet}
                                                onChange={(event) =>
                                                    setBullet(
                                                        locale.code,
                                                        index,
                                                        event.target.value,
                                                    )
                                                }
                                            />
                                            <Button
                                                type="button"
                                                variant="ghost"
                                                size="icon"
                                                onClick={() =>
                                                    removeBullet(
                                                        locale.code,
                                                        index,
                                                    )
                                                }
                                            >
                                                <Trash2 className="h-4 w-4" />
                                            </Button>
                                        </div>
                                    ))}
                                    <InputError
                                        message={
                                            flatErrors[
                                                `translations.${locale.code}.bullet_points`
                                            ]
                                        }
                                    />
                                </div>
                            </TabsContent>
                        ))}
                    </Tabs>
                </section>
            )}

            {section.key === 'featured_products' && (
                <section className="grid gap-6 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                    <div>
                        <h3 className="text-sm font-medium">
                            Ausgewählte Produkte
                        </h3>
                        <p className="text-sm text-muted-foreground">
                            {selectedProducts.length} Produkte ausgewählt.
                        </p>
                    </div>
                    <div className="grid gap-4 lg:grid-cols-[minmax(0,1fr)_minmax(280px,360px)]">
                        <div className="grid gap-2">
                            {products.map((product) => (
                                <label
                                    key={product.id}
                                    className="flex items-center gap-3 rounded-md border border-sidebar-border/70 px-3 py-2 text-sm dark:border-sidebar-border"
                                >
                                    <Checkbox
                                        checked={data.payload.product_ids.includes(
                                            product.id,
                                        )}
                                        onCheckedChange={(checked) =>
                                            toggleProduct(
                                                product.id,
                                                checked === true,
                                            )
                                        }
                                    />
                                    <span className="grid">
                                        <span>{product.name}</span>
                                        {product.brand && (
                                            <span className="text-xs text-muted-foreground">
                                                {product.brand}
                                            </span>
                                        )}
                                    </span>
                                </label>
                            ))}
                            <InputError
                                message={flatErrors['payload.product_ids']}
                            />
                        </div>
                        <div className="grid content-start gap-2">
                            <Label>Sortierung</Label>
                            {selectedProducts.length === 0 ? (
                                <div className="rounded-md border border-dashed border-input p-4 text-sm text-muted-foreground">
                                    Keine Produkte ausgewählt.
                                </div>
                            ) : (
                                selectedProducts.map((product, index) => (
                                    <div
                                        key={product.id}
                                        className="flex items-center justify-between gap-2 rounded-md border border-sidebar-border/70 px-3 py-2 text-sm dark:border-sidebar-border"
                                    >
                                        <span>{product.name}</span>
                                        <div className="flex gap-1">
                                            <Button
                                                type="button"
                                                variant="ghost"
                                                size="icon"
                                                disabled={index === 0}
                                                onClick={() =>
                                                    moveProduct(product.id, -1)
                                                }
                                            >
                                                <ArrowUp className="h-4 w-4" />
                                            </Button>
                                            <Button
                                                type="button"
                                                variant="ghost"
                                                size="icon"
                                                disabled={
                                                    index ===
                                                    selectedProducts.length - 1
                                                }
                                                onClick={() =>
                                                    moveProduct(product.id, 1)
                                                }
                                            >
                                                <ArrowDown className="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </div>
                                ))
                            )}
                        </div>
                    </div>
                </section>
            )}

            <div className="flex items-center gap-3">
                <Button type="submit" disabled={processing}>
                    Speichern
                </Button>
                <Button asChild variant="outline">
                    <Link href={pageSectionsRoutes.index()}>Abbrechen</Link>
                </Button>
            </div>
        </form>
    );
}

function withDefaultTranslations(
    translations: PageSectionTranslations,
): PageSectionTranslations {
    return {
        de: withDefaultLocale(translations.de),
        ar: withDefaultLocale(translations.ar),
        en: withDefaultLocale(translations.en),
    };
}

function withDefaultLocale(
    locale?: Partial<PageSectionTranslations[TranslationLocale]>,
): PageSectionTranslations[TranslationLocale] {
    return {
        title: locale?.title ?? '',
        body: locale?.body ?? '',
        cta_text: locale?.cta_text ?? '',
        bullet_points: locale?.bullet_points ?? [],
    };
}

function stringTranslations(translations: PageSectionTranslations) {
    return {
        de: {
            title: translations.de.title,
            body: translations.de.body,
            cta_text: translations.de.cta_text,
        },
        ar: {
            title: translations.ar.title,
            body: translations.ar.body,
            cta_text: translations.ar.cta_text,
        },
        en: {
            title: translations.en.title,
            body: translations.en.body,
            cta_text: translations.en.cta_text,
        },
    };
}
