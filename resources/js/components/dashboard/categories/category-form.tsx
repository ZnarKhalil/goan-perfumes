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
    TranslationsShape,
    TranslationLocale,
} from '@/components/dashboard/translation-tabs';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { publicAllCacheTags } from '@/lib/inertia-cache';
import categoriesRoutes from '@/routes/dashboard/categories';

const FIELDS: TranslationField[] = [
    { name: 'name', label: 'Name' },
    { name: 'description', label: 'Beschreibung', type: 'textarea', rows: 5 },
];

export type CategoryParentOption = {
    id: number;
    name: string;
};

export type CategoryMediaRow = {
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

export type CategoryFormProps = {
    mode: 'create' | 'edit';
    categoryId?: number;
    initial: {
        parent_id: number | null;
        sort_order: number;
        is_active: boolean;
        translations: TranslationsShape;
        media: CategoryMediaRow[];
    };
    parents: CategoryParentOption[];
};

type FormData = {
    parent_id: string;
    sort_order: number;
    is_active: boolean;
    translations: TranslationsShape;
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
};

export default function CategoryForm({
    mode,
    categoryId,
    initial,
    parents,
}: CategoryFormProps) {
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
    const { data, setData, post, processing, errors, transform } =
        useForm<FormData>({
            parent_id: initial.parent_id ? String(initial.parent_id) : 'none',
            sort_order: initial.sort_order,
            is_active: initial.is_active,
            translations: initial.translations ?? emptyTranslations(FIELDS),
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

        transform((current) => ({
            ...current,
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
                ? categoriesRoutes.store().url
                : categoriesRoutes.update({
                      category: categoriesRoute(categoryId),
                  }).url;
        post(url, {
            forceFormData: true,
            invalidateCacheTags: publicAllCacheTags,
        });
    };

    const setTranslation = (
        locale: TranslationLocale,
        field: string,
        value: string,
    ) => {
        setData('translations', {
            ...data.translations,
            [locale]: { ...data.translations[locale], [field]: value },
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
                    requiredFields={['name']}
                    onChange={setTranslation}
                />
            </section>

            <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <h3 className="text-sm font-medium">Stammdaten</h3>
                <div className="grid gap-4 md:grid-cols-2">
                    <div className="grid gap-2">
                        <Label htmlFor="parent_id">
                            Übergeordnete Kategorie
                        </Label>
                        <Select
                            value={data.parent_id}
                            onValueChange={(v) => setData('parent_id', v)}
                        >
                            <SelectTrigger id="parent_id">
                                <SelectValue placeholder="Keine" />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectItem value="none">Keine</SelectItem>
                                {parents.map((p) => (
                                    <SelectItem key={p.id} value={String(p.id)}>
                                        {p.name}
                                    </SelectItem>
                                ))}
                            </SelectContent>
                        </Select>
                        <InputError message={errors.parent_id} />
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
                    <div className="flex items-center gap-2 pt-7">
                        <Checkbox
                            id="is_active"
                            checked={data.is_active}
                            onCheckedChange={(v) =>
                                setData('is_active', v === true)
                            }
                        />
                        <Label htmlFor="is_active">
                            Aktiv (auf der öffentlichen Seite sichtbar)
                        </Label>
                    </div>
                </div>
            </section>

            <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <div>
                    <h3 className="text-sm font-medium">Kategoriebild</h3>
                    <p className="text-sm text-muted-foreground">
                        Wird auf der Startseite und als Produkt-Fallback für
                        diese Kategorie verwendet.
                    </p>
                </div>
                <MediaUploader
                    mode="multi"
                    items={mediaItems}
                    onItemsChange={updateMediaItems}
                    error={errors.media_uploads ?? errors.media_meta}
                    label="Kategoriebild"
                    max={1}
                    showAltTextFields={false}
                />
            </section>

            <div className="flex items-center justify-end gap-3">
                <Button asChild variant="ghost">
                    <Link href={categoriesRoutes.index()}>Abbrechen</Link>
                </Button>
                <Button type="submit" disabled={processing}>
                    {mode === 'create' ? 'Anlegen' : 'Speichern'}
                </Button>
            </div>
        </form>
    );
}

function mediaMeta(item: MediaItem): MediaMetaItem {
    return {
        ...(item.serverId ? { id: item.serverId } : {}),
        sort_order: item.sort_order,
        is_primary: item.is_primary,
    };
}

function categoriesRoute(id: number | undefined): number {
    if (id === undefined) {
        throw new Error('Category id missing in edit form.');
    }

    return id;
}
