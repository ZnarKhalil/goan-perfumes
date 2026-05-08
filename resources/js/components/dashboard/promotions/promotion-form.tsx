import { Link, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';
import MediaUploader from '@/components/dashboard/media-uploader';
import SlugField from '@/components/dashboard/slug-field';
import TranslationTabs, {
    emptyTranslations,
} from '@/components/dashboard/translation-tabs';
import type {
    TranslationField,
    TranslationLocale,
    TranslationsShape,
} from '@/components/dashboard/translation-tabs';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import promotionsRoutes from '@/routes/dashboard/promotions';

const FIELDS: TranslationField[] = [
    { name: 'badge', label: 'Badge' },
    { name: 'title', label: 'Titel' },
    { name: 'subtitle', label: 'Untertitel', type: 'textarea', rows: 3 },
    { name: 'cta_text', label: 'Button-Text' },
];

export type PromotionFormProps = {
    mode: 'create' | 'edit';
    promotionId?: number;
    initial: {
        slug: string;
        background_image_url: string | null;
        background_color: string;
        link_url: string;
        promo_code: string;
        discount_percent: number | '';
        starts_at: string;
        ends_at: string;
        sort_order: number;
        is_active: boolean;
        translations: TranslationsShape;
    };
};

type FormData = {
    slug: string;
    background_image: File | null;
    remove_background_image: boolean;
    background_color: string;
    link_url: string;
    promo_code: string;
    discount_percent: number | '';
    starts_at: string;
    ends_at: string;
    sort_order: number;
    is_active: boolean;
    translations: TranslationsShape;
    _method?: 'PUT';
};

export default function PromotionForm({
    mode,
    promotionId,
    initial,
}: PromotionFormProps) {
    const { data, setData, post, processing, errors } = useForm<FormData>({
        slug: initial.slug,
        background_image: null,
        remove_background_image: false,
        background_color: initial.background_color,
        link_url: initial.link_url,
        promo_code: initial.promo_code,
        discount_percent: initial.discount_percent,
        starts_at: initial.starts_at,
        ends_at: initial.ends_at,
        sort_order: initial.sort_order,
        is_active: initial.is_active,
        translations: initial.translations ?? emptyTranslations(FIELDS),
        ...(mode === 'edit' ? { _method: 'PUT' as const } : {}),
    });

    const submit = (e: FormEvent) => {
        e.preventDefault();

        const url =
            mode === 'create'
                ? promotionsRoutes.store().url
                : promotionsRoutes.update({
                      promotion: requirePromotionId(promotionId),
                  }).url;

        post(url, { forceFormData: true });
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

    return (
        <form
            onSubmit={submit}
            className="grid gap-8"
            encType="multipart/form-data"
        >
            <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <h3 className="text-sm font-medium">Inhalte (mehrsprachig)</h3>
                <TranslationTabs
                    fields={FIELDS}
                    values={data.translations}
                    errors={errors as Record<string, string | undefined>}
                    requiredFields={['title']}
                    onChange={setTranslation}
                />
            </section>

            <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <h3 className="text-sm font-medium">Stammdaten</h3>
                <div className="grid gap-4 md:grid-cols-2">
                    <SlugField
                        value={data.slug}
                        source={data.translations.de?.title ?? ''}
                        error={errors.slug}
                        onChange={(slug) => setData('slug', slug)}
                    />
                    <div className="grid gap-2">
                        <Label htmlFor="background_color">
                            Hintergrundfarbe
                        </Label>
                        <Input
                            id="background_color"
                            value={data.background_color}
                            placeholder="#1a1530"
                            onChange={(e) =>
                                setData('background_color', e.target.value)
                            }
                        />
                        <InputError message={errors.background_color} />
                    </div>
                    <div className="grid gap-2">
                        <Label htmlFor="link_url">Link URL</Label>
                        <Input
                            id="link_url"
                            value={data.link_url}
                            placeholder="/nischenparfums"
                            onChange={(e) =>
                                setData('link_url', e.target.value)
                            }
                        />
                        <InputError message={errors.link_url} />
                    </div>
                    <div className="grid gap-2">
                        <Label htmlFor="promo_code">Promo-Code</Label>
                        <Input
                            id="promo_code"
                            value={data.promo_code}
                            onChange={(e) =>
                                setData('promo_code', e.target.value)
                            }
                        />
                        <InputError message={errors.promo_code} />
                    </div>
                    <div className="grid gap-2">
                        <Label htmlFor="discount_percent">Rabatt (%)</Label>
                        <Input
                            id="discount_percent"
                            type="number"
                            min={1}
                            max={100}
                            value={data.discount_percent}
                            onChange={(e) =>
                                setData(
                                    'discount_percent',
                                    e.target.value
                                        ? Number(e.target.value)
                                        : '',
                                )
                            }
                        />
                        <InputError message={errors.discount_percent} />
                    </div>
                    <div className="grid gap-2">
                        <Label htmlFor="sort_order">Reihenfolge</Label>
                        <Input
                            id="sort_order"
                            type="number"
                            min={0}
                            value={data.sort_order}
                            onChange={(e) =>
                                setData(
                                    'sort_order',
                                    Number(e.target.value || 0),
                                )
                            }
                        />
                        <InputError message={errors.sort_order} />
                    </div>
                    <div className="grid gap-2">
                        <Label htmlFor="starts_at">Start</Label>
                        <Input
                            id="starts_at"
                            type="datetime-local"
                            value={data.starts_at}
                            onChange={(e) =>
                                setData('starts_at', e.target.value)
                            }
                        />
                        <InputError message={errors.starts_at} />
                    </div>
                    <div className="grid gap-2">
                        <Label htmlFor="ends_at">Ende</Label>
                        <Input
                            id="ends_at"
                            type="datetime-local"
                            value={data.ends_at}
                            onChange={(e) => setData('ends_at', e.target.value)}
                        />
                        <InputError message={errors.ends_at} />
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

            <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <h3 className="text-sm font-medium">Hero-Hintergrund</h3>
                <MediaUploader
                    mode="single"
                    value={data.background_image}
                    existingUrl={
                        data.remove_background_image
                            ? null
                            : initial.background_image_url
                    }
                    onChange={(file) => {
                        setData('background_image', file);

                        if (file) {
                            setData('remove_background_image', false);
                        }
                    }}
                    onRemove={() => setData('remove_background_image', true)}
                    error={errors.background_image}
                    label="Hintergrundbild"
                />
            </section>

            <div className="flex items-center justify-end gap-3">
                <Button asChild variant="ghost">
                    <Link href={promotionsRoutes.index()}>Abbrechen</Link>
                </Button>
                <Button type="submit" disabled={processing}>
                    {mode === 'create' ? 'Anlegen' : 'Speichern'}
                </Button>
            </div>
        </form>
    );
}

export { FIELDS as PROMOTION_TRANSLATION_FIELDS };

function requirePromotionId(id: number | undefined): number {
    if (id === undefined) {
        throw new Error('Promotion id missing in edit form.');
    }

    return id;
}
