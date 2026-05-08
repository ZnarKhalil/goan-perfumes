import { Link, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';
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
import attributesRoutes from '@/routes/dashboard/attributes';

const FIELDS: TranslationField[] = [{ name: 'name', label: 'Name' }];

export type AttributeFormProps = {
    mode: 'create' | 'edit';
    attributeId?: number;
    initial: {
        code: string;
        sort_order: number;
        is_filterable: boolean;
        is_multiple: boolean;
        translations: TranslationsShape;
    };
};

type FormData = {
    code: string;
    sort_order: number;
    is_filterable: boolean;
    is_multiple: boolean;
    translations: TranslationsShape;
    _method?: 'PUT';
};

export default function AttributeForm({
    mode,
    attributeId,
    initial,
}: AttributeFormProps) {
    const { data, setData, post, processing, errors } = useForm<FormData>({
        code: initial.code,
        sort_order: initial.sort_order,
        is_filterable: initial.is_filterable,
        is_multiple: initial.is_multiple,
        translations: initial.translations ?? emptyTranslations(FIELDS),
        ...(mode === 'edit' ? { _method: 'PUT' as const } : {}),
    });

    const submit = (e: FormEvent) => {
        e.preventDefault();
        const url =
            mode === 'create'
                ? attributesRoutes.store().url
                : attributesRoutes.update({
                      attribute: requireAttributeId(attributeId),
                  }).url;

        post(url);
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
        <form onSubmit={submit} className="grid gap-8">
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
                        <Label htmlFor="code">Code</Label>
                        <Input
                            id="code"
                            value={data.code}
                            onChange={(e) => setData('code', e.target.value)}
                            placeholder="familie"
                        />
                        <p className="text-xs text-muted-foreground">
                            Nur Kleinbuchstaben, Zahlen, Bindestrich und
                            Unterstrich.
                        </p>
                        <InputError message={errors.code} />
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

                    <div className="flex items-center gap-2">
                        <Checkbox
                            id="is_filterable"
                            checked={data.is_filterable}
                            onCheckedChange={(v) =>
                                setData('is_filterable', v === true)
                            }
                        />
                        <Label htmlFor="is_filterable">
                            Im Filter anzeigen
                        </Label>
                    </div>

                    <div className="flex items-center gap-2">
                        <Checkbox
                            id="is_multiple"
                            checked={data.is_multiple}
                            onCheckedChange={(v) =>
                                setData('is_multiple', v === true)
                            }
                        />
                        <Label htmlFor="is_multiple">
                            Mehrere Werte pro Produkt erlauben
                        </Label>
                    </div>
                </div>
            </section>

            <div className="flex items-center justify-end gap-3">
                <Button asChild variant="ghost">
                    <Link href={attributesRoutes.index()}>Abbrechen</Link>
                </Button>
                <Button type="submit" disabled={processing}>
                    {mode === 'create' ? 'Anlegen' : 'Speichern'}
                </Button>
            </div>
        </form>
    );
}

function requireAttributeId(id: number | undefined): number {
    if (id === undefined) {
        throw new Error('Attribute id missing in edit form.');
    }

    return id;
}

export { FIELDS as ATTRIBUTE_TRANSLATION_FIELDS };
