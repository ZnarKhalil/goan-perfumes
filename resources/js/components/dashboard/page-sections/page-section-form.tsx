import { Link, useForm } from '@inertiajs/react';
import { Plus, Trash2 } from 'lucide-react';
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
import { publicContentCacheTags } from '@/lib/inertia-cache';
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

export type PageSectionKey = 'hero' | 'about' | 'why_us';

export type PageSectionTranslations = Record<
    TranslationLocale,
    {
        title: string;
        body: string;
        cta_text: string;
        bullet_points: string[];
    }
>;

type Props = {
    section: {
        id: number;
        key: PageSectionKey;
        label: string;
        payload: {
            image_path?: string | null;
            video_path?: string | null;
        };
        image_url: string | null;
        video_url: string | null;
        sort_order: number;
        is_active: boolean;
        translations: PageSectionTranslations;
    };
};

type FormData = {
    hero_image: File | null;
    hero_video: File | null;
    remove_hero_image: boolean;
    remove_hero_video: boolean;
    sort_order: number;
    is_active: boolean;
    translations: PageSectionTranslations;
    _method: 'PUT';
};

export default function PageSectionForm({ section }: Props) {
    const { data, setData, post, processing, errors } = useForm<FormData>({
        hero_image: null,
        hero_video: null,
        remove_hero_image: false,
        remove_hero_video: false,
        sort_order: section.sort_order,
        is_active: section.is_active,
        translations: withDefaultTranslations(section.translations),
        _method: 'PUT',
    });
    const flatErrors = errors as Record<string, string | undefined>;

    const submit = (event: FormEvent) => {
        event.preventDefault();

        post(pageSectionsRoutes.update({ page_section: section.id }).url, {
            forceFormData: true,
            invalidateCacheTags: publicContentCacheTags,
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
                                // Image and video are mutually exclusive.
                                setData('remove_hero_image', false);
                                setData('hero_video', null);
                                setData('remove_hero_video', true);
                            }
                        }}
                        onRemove={() => setData('remove_hero_image', true)}
                        error={errors.hero_image}
                    />
                    <MediaUploader
                        mode="single"
                        label="Hero-Video"
                        value={data.hero_video}
                        existingUrl={
                            data.remove_hero_video ? null : section.video_url
                        }
                        accept="video/mp4,video/webm"
                        previewType="video"
                        onChange={(file) => {
                            setData('hero_video', file);

                            if (file) {
                                // Image and video are mutually exclusive.
                                setData('remove_hero_video', false);
                                setData('hero_image', null);
                                setData('remove_hero_image', true);
                            }
                        }}
                        onRemove={() => setData('remove_hero_video', true)}
                        error={errors.hero_video}
                    />
                    <p className="text-sm text-muted-foreground">
                        Bild oder Video – es wird nur eines angezeigt. Video:
                        MP4 oder WebM, maximal 20 MB.
                    </p>
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
