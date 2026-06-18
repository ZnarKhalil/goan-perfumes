import { Link, router, useForm } from '@inertiajs/react';
import { Pencil, Plus, Trash2 } from 'lucide-react';
import { useEffect, useRef, useState } from 'react';
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
import attributesRoutes from '@/routes/dashboard/attributes';
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

type PaginationLink = {
    url: string | null;
    label: string;
    active: boolean;
};

export type ValuesPagination = {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number | null;
    to: number | null;
    links: PaginationLink[];
};

type Props = {
    attributeId: number;
    values: AttributeValueRow[];
    pagination: ValuesPagination;
    search: string;
    nextSortOrder: number;
};

type FormData = {
    sort_order: number;
    is_active: boolean;
    translations: TranslationsShape;
    _method?: 'PUT';
};

const blankForm = (nextSortOrder: number): FormData => ({
    sort_order: nextSortOrder,
    is_active: true,
    translations: emptyTranslations(FIELDS),
});

export default function AttributeValueEditor({
    attributeId,
    values,
    pagination,
    search,
    nextSortOrder,
}: Props) {
    const [editing, setEditing] = useState<AttributeValueRow | null>(null);
    const [searchTerm, setSearchTerm] = useState(search);
    const isInitialMount = useRef(true);
    const { data, setData, post, processing, errors, reset, clearErrors } =
        useForm<FormData>(blankForm(nextSortOrder));

    // Debounce the search input and refresh only the attribute prop so the form
    // state on the right is preserved while typing.
    useEffect(() => {
        if (isInitialMount.current) {
            isInitialMount.current = false;

            return;
        }

        const timeout = setTimeout(() => {
            if (searchTerm === search) {
                return;
            }

            router.get(
                attributesRoutes.edit({ attribute: attributeId }).url,
                searchTerm ? { value_search: searchTerm } : {},
                {
                    only: ['attribute'],
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                },
            );
        }, 350);

        return () => clearTimeout(timeout);
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [searchTerm]);

    const selectForEdit = (value: AttributeValueRow) => {
        clearErrors();
        setEditing(value);
        setData({
            sort_order: value.sort_order,
            is_active: value.is_active,
            translations: value.translations,
            _method: 'PUT',
        });
    };

    const resetToCreate = (nextSort: number = nextSortOrder) => {
        clearErrors();
        setEditing(null);
        reset();
        setData(blankForm(nextSort));
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
            onSuccess: (page) => {
                // Read the fresh next sort order from the reloaded page so the
                // create default reflects the value just added.
                const freshNextSort =
                    (
                        page.props as {
                            attribute?: { next_value_sort_order?: number };
                        }
                    ).attribute?.next_value_sort_order ?? nextSortOrder;

                resetToCreate(freshNextSort);
            },
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
                <Button
                    type="button"
                    variant="outline"
                    onClick={() => resetToCreate()}
                >
                    <Plus className="mr-1 h-4 w-4" /> Neuer Wert
                </Button>
            </div>

            <div className="grid gap-6 xl:grid-cols-[minmax(0,1fr)_24rem]">
                <div className="grid content-start gap-3">
                    <Input
                        type="search"
                        value={searchTerm}
                        onChange={(e) => setSearchTerm(e.target.value)}
                        placeholder="Werte nach Name suchen…"
                        className="max-w-sm"
                        aria-label="Werte nach Name suchen"
                    />

                    <DataTable<AttributeValueRow>
                        rows={values}
                        rowKey={(row) => row.id}
                        emptyMessage={
                            search
                                ? 'Keine Werte gefunden.'
                                : 'Noch keine Werte angelegt.'
                        }
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
                                        <Badge variant="secondary">
                                            Inaktiv
                                        </Badge>
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

                    {pagination.last_page > 1 && (
                        <nav
                            aria-label="Seitennavigation"
                            className="flex flex-wrap items-center justify-between gap-3"
                        >
                            <p className="text-sm text-muted-foreground">
                                {pagination.from}–{pagination.to} von{' '}
                                {pagination.total} Werten
                            </p>
                            <div className="flex flex-wrap gap-1">
                                {pagination.links.map((link, index) =>
                                    link.url ? (
                                        <Button
                                            key={index}
                                            asChild
                                            variant={
                                                link.active
                                                    ? 'default'
                                                    : 'outline'
                                            }
                                            size="sm"
                                        >
                                            <Link
                                                href={link.url}
                                                only={['attribute']}
                                                preserveState
                                                preserveScroll
                                            >
                                                {paginationLabel(link.label)}
                                            </Link>
                                        </Button>
                                    ) : (
                                        <Button
                                            key={index}
                                            variant="outline"
                                            size="sm"
                                            disabled
                                        >
                                            {paginationLabel(link.label)}
                                        </Button>
                                    ),
                                )}
                            </div>
                        </nav>
                    )}
                </div>

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
                            erzeugt.
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
                                onClick={() => resetToCreate()}
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

function paginationLabel(label: string): string {
    if (label.includes('Previous')) {
        return '‹ Zurück';
    }

    if (label.includes('Next')) {
        return 'Weiter ›';
    }

    return label;
}
