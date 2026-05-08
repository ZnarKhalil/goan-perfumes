import { router, useForm } from '@inertiajs/react';
import { Pencil, Plus, Trash2 } from 'lucide-react';
import { useState } from 'react';
import type { FormEvent } from 'react';
import DataTable from '@/components/dashboard/data-table';
import TranslationTabs, {
    emptyTranslations,
} from '@/components/dashboard/translation-tabs';
import type {
    TranslationField,
    TranslationLocale,
    TranslationsShape,
} from '@/components/dashboard/translation-tabs';
import InputError from '@/components/input-error';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import valueRoutes from '@/routes/dashboard/attributes/values';

const FIELDS: TranslationField[] = [{ name: 'name', label: 'Name' }];

export type AttributeValueRow = {
    id: number;
    slug: string;
    name: string;
    sort_order: number;
    is_active: boolean;
    translations: TranslationsShape;
};

type Props = {
    attributeId: number;
    values: AttributeValueRow[];
};

type FormData = {
    slug: string;
    sort_order: number;
    is_active: boolean;
    translations: TranslationsShape;
    _method?: 'PUT';
};

const blankForm = (): FormData => ({
    slug: '',
    sort_order: 0,
    is_active: true,
    translations: emptyTranslations(FIELDS),
});

export default function AttributeValueEditor({ attributeId, values }: Props) {
    const [editing, setEditing] = useState<AttributeValueRow | null>(null);
    const { data, setData, post, processing, errors, reset, clearErrors } =
        useForm<FormData>(blankForm());

    const selectForEdit = (value: AttributeValueRow) => {
        clearErrors();
        setEditing(value);
        setData({
            slug: value.slug,
            sort_order: value.sort_order,
            is_active: value.is_active,
            translations: value.translations,
            _method: 'PUT',
        });
    };

    const resetToCreate = () => {
        clearErrors();
        setEditing(null);
        reset();
        setData(blankForm());
    };

    const submit = (e: FormEvent) => {
        e.preventDefault();

        const url = editing
            ? valueRoutes.update({
                  attribute: attributeId,
                  value: editing.id,
              }).url
            : valueRoutes.store({ attribute: attributeId }).url;

        post(url, {
            preserveScroll: true,
            onSuccess: () => resetToCreate(),
        });
    };

    const remove = (value: AttributeValueRow) => {
        if (
            !confirm(
                `Wert "${value.name}" wirklich löschen? Diese Aktion lässt sich nicht rückgängig machen.`,
            )
        ) {
            return;
        }

        router.delete(
            valueRoutes.destroy({
                attribute: attributeId,
                value: value.id,
            }).url,
            { preserveScroll: true },
        );
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
        <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
            <div className="flex items-start justify-between gap-4">
                <div>
                    <h3 className="text-sm font-medium">Attributwerte</h3>
                    <p className="text-sm text-muted-foreground">
                        Werte werden direkt diesem Attribut zugeordnet.
                    </p>
                </div>
                <Button type="button" variant="outline" onClick={resetToCreate}>
                    <Plus className="mr-1 h-4 w-4" /> Neuer Wert
                </Button>
            </div>

            <div className="grid gap-6 xl:grid-cols-[minmax(0,1fr)_24rem]">
                <DataTable<AttributeValueRow>
                    rows={values}
                    rowKey={(row) => row.id}
                    columns={[
                        {
                            key: 'name',
                            label: 'Name',
                            render: (row) => (
                                <div>
                                    <div className="font-medium">
                                        {row.name}
                                    </div>
                                    <div className="text-xs text-muted-foreground">
                                        {row.slug}
                                    </div>
                                </div>
                            ),
                        },
                        {
                            key: 'sort_order',
                            label: 'Reihenfolge',
                            className: 'w-28',
                        },
                        {
                            key: 'status',
                            label: 'Status',
                            className: 'w-24',
                            render: (row) =>
                                row.is_active ? (
                                    <Badge variant="outline">Aktiv</Badge>
                                ) : (
                                    <Badge variant="secondary">Inaktiv</Badge>
                                ),
                        },
                    ]}
                    actions={(row) => (
                        <>
                            <Button
                                type="button"
                                variant="ghost"
                                size="sm"
                                onClick={() => selectForEdit(row)}
                            >
                                <Pencil className="h-4 w-4" />
                            </Button>
                            <Button
                                type="button"
                                variant="ghost"
                                size="sm"
                                onClick={() => remove(row)}
                            >
                                <Trash2 className="h-4 w-4" />
                            </Button>
                        </>
                    )}
                />

                <form
                    onSubmit={submit}
                    className="grid content-start gap-4 rounded-lg border border-sidebar-border/70 p-4 dark:border-sidebar-border"
                >
                    <div>
                        <h4 className="text-sm font-medium">
                            {editing ? 'Wert bearbeiten' : 'Neuer Wert'}
                        </h4>
                        <p className="text-xs text-muted-foreground">
                            Der Slug wird automatisch aus dem deutschen Namen
                            erzeugt, wenn er leer bleibt.
                        </p>
                    </div>

                    <TranslationTabs
                        fields={FIELDS}
                        values={data.translations}
                        errors={errors as Record<string, string | undefined>}
                        requiredFields={['name']}
                        onChange={setTranslation}
                    />

                    <div className="grid gap-2">
                        <Label htmlFor="value_slug">Slug</Label>
                        <Input
                            id="value_slug"
                            value={data.slug}
                            onChange={(e) => setData('slug', e.target.value)}
                            placeholder="blumig"
                        />
                        <InputError message={errors.slug} />
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="value_sort_order">Reihenfolge</Label>
                        <Input
                            id="value_sort_order"
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

                    <div className="flex items-center gap-2">
                        <Checkbox
                            id="value_is_active"
                            checked={data.is_active}
                            onCheckedChange={(v) =>
                                setData('is_active', v === true)
                            }
                        />
                        <Label htmlFor="value_is_active">Aktiv</Label>
                    </div>

                    <div className="flex justify-end gap-2">
                        {editing && (
                            <Button
                                type="button"
                                variant="ghost"
                                onClick={resetToCreate}
                            >
                                Abbrechen
                            </Button>
                        )}
                        <Button type="submit" disabled={processing}>
                            {editing ? 'Speichern' : 'Anlegen'}
                        </Button>
                    </div>
                </form>
            </div>
        </section>
    );
}
