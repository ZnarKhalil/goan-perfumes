import { Link, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';
import MediaUploader from '@/components/dashboard/media-uploader';
import SlugField from '@/components/dashboard/slug-field';
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
import categoriesRoutes from '@/routes/dashboard/categories';

const FIELDS: TranslationField[] = [
    { name: 'name', label: 'Name' },
    { name: 'description', label: 'Beschreibung', type: 'textarea', rows: 5 },
    { name: 'meta_title', label: 'Meta Title' },
    {
        name: 'meta_description',
        label: 'Meta Description',
        type: 'textarea',
        rows: 3,
    },
];

export type CategoryParentOption = {
    id: number;
    name: string;
};

export type CategoryFormProps = {
    mode: 'create' | 'edit';
    categoryId?: number;
    initial: {
        slug: string;
        parent_id: number | null;
        sort_order: number;
        is_active: boolean;
        image_url: string | null;
        translations: TranslationsShape;
    };
    parents: CategoryParentOption[];
};

type FormData = {
    slug: string;
    parent_id: string;
    sort_order: number;
    is_active: boolean;
    image: File | null;
    remove_image: boolean;
    translations: TranslationsShape;
    _method?: 'PUT';
};

export default function CategoryForm({
    mode,
    categoryId,
    initial,
    parents,
}: CategoryFormProps) {
    const { data, setData, post, processing, errors } = useForm<FormData>({
        slug: initial.slug,
        parent_id: initial.parent_id ? String(initial.parent_id) : 'none',
        sort_order: initial.sort_order,
        is_active: initial.is_active,
        image: null,
        remove_image: false,
        translations: initial.translations ?? emptyTranslations(FIELDS),
        ...(mode === 'edit' ? { _method: 'PUT' as const } : {}),
    });

    const submit = (e: FormEvent) => {
        e.preventDefault();
        const url =
            mode === 'create'
                ? categoriesRoutes.store().url
                : categoriesRoutes.update({
                      category: categoriesRoute(categoryId),
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
            [locale]: { ...data.translations[locale], [field]: value },
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
                    requiredFields={['name']}
                    onChange={setTranslation}
                />
            </section>

            <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                <h3 className="text-sm font-medium">Stammdaten</h3>
                <div className="grid gap-4 md:grid-cols-2">
                    <SlugField
                        value={data.slug}
                        source={data.translations.de?.name ?? ''}
                        error={errors.slug}
                        onChange={(slug) => setData('slug', slug)}
                    />
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
                <h3 className="text-sm font-medium">Banner</h3>
                <MediaUploader
                    mode="single"
                    value={data.image}
                    existingUrl={data.remove_image ? null : initial.image_url}
                    onChange={(file) => {
                        setData('image', file);

                        if (file) {
                            setData('remove_image', false);
                        }
                    }}
                    onRemove={() => setData('remove_image', true)}
                    error={errors.image}
                    label="Header-Banner (optional)"
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

function categoriesRoute(id: number | undefined): number {
    if (id === undefined) {
        throw new Error('Category id missing in edit form.');
    }

    return id;
}
