import { Link, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';
import { useState } from 'react';
import MediaUploader from '@/components/dashboard/media-uploader';
import type { MediaItem } from '@/components/dashboard/media-uploader';
import TranslationTabs, {
    emptyTranslations,
} from '@/components/dashboard/translation-tabs';
import type {
    TranslationField,
    TranslationLocale,
    TranslationsShape,
} from '@/components/dashboard/translation-tabs';
import VariantRowEditor from '@/components/dashboard/variant-row-editor';
import type { VariantRow } from '@/components/dashboard/variant-row-editor';
import InputError from '@/components/input-error';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import productsRoutes from '@/routes/dashboard/products';

const FIELDS: TranslationField[] = [
    { name: 'name', label: 'Name' },
    {
        name: 'short_description',
        label: 'Kurzbeschreibung',
        type: 'textarea',
        rows: 3,
    },
    { name: 'description', label: 'Beschreibung', type: 'textarea', rows: 7 },
];

export type ProductCategoryOption = {
    id: number;
    name: string;
};

export type ProductAttributeGroup = {
    id: number;
    code: string;
    name: string;
    is_multiple: boolean;
    values: {
        id: number;
        name: string;
        slug: string;
        is_active: boolean;
    }[];
};

export type ProductMediaRow = {
    id: number;
    url: string;
    sort_order: number;
    is_primary: boolean;
    alt_text: string;
    alt_text_translations?: {
        de: string;
        ar: string;
        en: string;
    };
};

export type HighlightSlots = {
    max: number;
    used: number;
    remaining: number;
};

export type ProductFormProps = {
    mode: 'create' | 'edit';
    productId?: number;
    initial: {
        slug: string;
        brand: string;
        is_active: boolean;
        is_featured: boolean;
        translations: TranslationsShape;
        categories: number[];
        attribute_values: number[];
        variants: VariantRow[];
        media: ProductMediaRow[];
    };
    categories: ProductCategoryOption[];
    attributes: ProductAttributeGroup[];
    highlightSlots: HighlightSlots;
};

type FormData = {
    slug: string;
    brand: string;
    is_active: boolean;
    is_featured: boolean;
    translations: TranslationsShape;
    categories: number[];
    attribute_values: number[];
    variants: VariantRow[];
    media_uploads: File[];
    media_meta: {
        existing: MediaMetaItem[];
        new: MediaMetaItem[];
        removed: number[];
    };
    _method?: 'PUT';
};

type MediaMetaItem = {
    id?: number;
    sort_order: number;
    is_primary: boolean;
    alt_text: {
        de: string;
        ar: string;
        en: string;
    };
};

export default function ProductForm({
    mode,
    productId,
    initial,
    categories,
    attributes,
    highlightSlots,
}: ProductFormProps) {
    const [mediaItems, setMediaItems] = useState<MediaItem[]>(
        initial.media.map((media) => ({
            id: `existing-${media.id}`,
            serverId: media.id,
            url: media.url,
            sort_order: media.sort_order,
            is_primary: media.is_primary,
            alt_text: media.alt_text,
            alt_text_translations: media.alt_text_translations,
        })),
    );
    const [removedMediaIds, setRemovedMediaIds] = useState<number[]>([]);
    const form = useForm<FormData>({
        slug: '',
        brand: initial.brand,
        is_active: initial.is_active,
        is_featured: initial.is_featured,
        translations: initial.translations ?? emptyTranslations(FIELDS),
        categories: initial.categories,
        attribute_values: initial.attribute_values,
        variants:
            initial.variants.length > 0
                ? initial.variants
                : [
                      {
                          size_ml: '',
                          price: '',
                          compare_at_price: '',
                          is_default: true,
                          is_active: true,
                      },
                  ],
        media_uploads: [],
        media_meta: {
            existing: [],
            new: [],
            removed: [],
        },
        ...(mode === 'edit' ? { _method: 'PUT' as const } : {}),
    });

    const submit = (e: FormEvent) => {
        e.preventDefault();

        const newItems = mediaItems.filter((item) => item.file);
        const existingItems = mediaItems.filter((item) => item.serverId);

        form.transform((data) => ({
            ...data,
            slug: '',
            media_uploads: newItems
                .map((item) => item.file)
                .filter((file): file is File => file instanceof File),
            media_meta: {
                existing: existingItems.map((item) => mediaMeta(item)),
                new: newItems.map((item) => mediaMeta(item)),
                removed: removedMediaIds,
            },
        }));

        const url =
            mode === 'create'
                ? productsRoutes.store().url
                : productsRoutes.update({
                      product: requireProductId(productId),
                  }).url;

        form.post(url, { forceFormData: true });
    };

    const remainingHighlightSlots =
        highlightSlots.max -
        highlightSlots.used -
        (form.data.is_featured ? 1 : 0);
    const highlightUnavailable =
        !form.data.is_featured && highlightSlots.remaining <= 0;

    const setTranslation = (
        locale: TranslationLocale,
        field: string,
        value: string,
    ) => {
        form.setData('translations', {
            ...form.data.translations,
            [locale]: {
                ...form.data.translations[locale],
                [field]: value,
            },
        });
    };

    const updateMediaItems = (items: MediaItem[]) => {
        const previousExistingIds = mediaItems
            .map((item) => item.serverId)
            .filter((id): id is number => typeof id === 'number');
        const nextExistingIds = items
            .map((item) => item.serverId)
            .filter((id): id is number => typeof id === 'number');
        const removedNow = previousExistingIds.filter(
            (id) => !nextExistingIds.includes(id),
        );

        if (removedNow.length > 0) {
            setRemovedMediaIds((current) =>
                Array.from(new Set([...current, ...removedNow])),
            );
        }

        setMediaItems(items);
    };

    const toggleCategory = (id: number, checked: boolean) => {
        const next = checked
            ? [...form.data.categories, id]
            : form.data.categories.filter((categoryId) => categoryId !== id);

        form.setData('categories', Array.from(new Set(next)));
    };

    const toggleAttributeValue = (
        group: ProductAttributeGroup,
        valueId: number,
        checked: boolean,
    ) => {
        const groupValueIds = group.values.map((value) => value.id);
        const withoutGroup = form.data.attribute_values.filter(
            (id) => !groupValueIds.includes(id),
        );

        if (!checked) {
            form.setData(
                'attribute_values',
                form.data.attribute_values.filter((id) => id !== valueId),
            );

            return;
        }

        form.setData(
            'attribute_values',
            group.is_multiple
                ? Array.from(new Set([...form.data.attribute_values, valueId]))
                : [...withoutGroup, valueId],
        );
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
                    values={form.data.translations}
                    errors={form.errors as Record<string, string | undefined>}
                    requiredFields={['name']}
                    onChange={setTranslation}
                />
            </section>

            <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <h3 className="text-sm font-medium">Stammdaten</h3>
                <div className="grid gap-4 md:grid-cols-2">
                    <div className="grid gap-2">
                        <Label htmlFor="brand">Marke</Label>
                        <Input
                            id="brand"
                            value={form.data.brand}
                            onChange={(e) =>
                                form.setData('brand', e.target.value)
                            }
                        />
                        <InputError message={form.errors.brand} />
                    </div>
                    <div className="flex items-center gap-2">
                        <Checkbox
                            id="is_active"
                            checked={form.data.is_active}
                            onCheckedChange={(checked) =>
                                form.setData('is_active', checked === true)
                            }
                        />
                        <Label htmlFor="is_active">Aktiv</Label>
                    </div>
                    <div className="flex items-center gap-2">
                        <Checkbox
                            id="is_featured"
                            checked={form.data.is_featured}
                            disabled={highlightUnavailable}
                            onCheckedChange={(checked) =>
                                form.setData('is_featured', checked === true)
                            }
                        />
                        <div className="grid gap-1">
                            <Label htmlFor="is_featured">
                                Luxus-Highlight auf der Startseite
                            </Label>
                            <p className="text-xs text-muted-foreground">
                                {highlightUnavailable
                                    ? 'Keine Plätze frei. Entferne zuerst ein Highlight, um ein neues hinzuzufügen.'
                                    : `${Math.max(0, remainingHighlightSlots)} von ${highlightSlots.max} Plätzen frei.`}
                            </p>
                            <InputError message={form.errors.is_featured} />
                        </div>
                    </div>
                </div>
            </section>

            <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <div>
                    <h3 className="text-sm font-medium">Kategorien</h3>
                    <p className="text-sm text-muted-foreground">
                        Produkte können in mehreren Menükategorien erscheinen.
                    </p>
                </div>
                <div className="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                    {categories.map((category) => (
                        <label
                            key={category.id}
                            className="flex items-center gap-2 rounded-md border border-sidebar-border/70 px-3 py-2 text-sm dark:border-sidebar-border"
                        >
                            <Checkbox
                                checked={form.data.categories.includes(
                                    category.id,
                                )}
                                onCheckedChange={(checked) =>
                                    toggleCategory(
                                        category.id,
                                        checked === true,
                                    )
                                }
                            />
                            {category.name}
                        </label>
                    ))}
                </div>
                <InputError message={form.errors.categories} />
            </section>

            <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <div>
                    <h3 className="text-sm font-medium">Filterwerte</h3>
                    <p className="text-sm text-muted-foreground">
                        Diese Werte steuern die öffentlichen Filter.
                    </p>
                </div>
                <div className="grid gap-5">
                    {attributes.map((group) => (
                        <div key={group.id} className="grid gap-2">
                            <div className="flex items-center gap-2">
                                <h4 className="text-sm font-medium">
                                    {group.name}
                                </h4>
                                <Badge variant="secondary">
                                    {group.is_multiple ? 'Mehrfach' : 'Einfach'}
                                </Badge>
                            </div>
                            <div className="flex flex-wrap gap-2">
                                {group.values.map((value) => (
                                    <label
                                        key={value.id}
                                        className="flex items-center gap-2 rounded-md border border-sidebar-border/70 px-3 py-2 text-sm dark:border-sidebar-border"
                                    >
                                        <Checkbox
                                            checked={form.data.attribute_values.includes(
                                                value.id,
                                            )}
                                            onCheckedChange={(checked) =>
                                                toggleAttributeValue(
                                                    group,
                                                    value.id,
                                                    checked === true,
                                                )
                                            }
                                        />
                                        {value.name}
                                    </label>
                                ))}
                            </div>
                        </div>
                    ))}
                </div>
                <InputError message={form.errors.attribute_values} />
            </section>

            <VariantRowEditor
                value={form.data.variants}
                onChange={(variants) => form.setData('variants', variants)}
                errors={form.errors as Record<string, string | undefined>}
            />

            <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <h3 className="text-sm font-medium">Produktbilder</h3>
                <MediaUploader
                    mode="multi"
                    items={mediaItems}
                    onItemsChange={updateMediaItems}
                    error={form.errors.media_uploads ?? form.errors.media_meta}
                />
            </section>

            <div className="flex items-center justify-end gap-3">
                <Button asChild variant="ghost">
                    <Link href={productsRoutes.index()}>Abbrechen</Link>
                </Button>
                <Button type="submit" disabled={form.processing}>
                    {mode === 'create' ? 'Anlegen' : 'Speichern'}
                </Button>
            </div>
        </form>
    );
}

function mediaMeta(item: MediaItem): MediaMetaItem {
    const altText = {
        de: item.alt_text_translations?.de ?? item.alt_text ?? '',
        ar: item.alt_text_translations?.ar ?? '',
        en: item.alt_text_translations?.en ?? '',
    };

    return {
        ...(item.serverId ? { id: item.serverId } : {}),
        sort_order: item.sort_order,
        is_primary: item.is_primary,
        alt_text: altText,
    };
}

function requireProductId(id: number | undefined): number {
    if (id === undefined) {
        throw new Error('Product id missing in edit form.');
    }

    return id;
}
