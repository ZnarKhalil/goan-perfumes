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
        starts_at: string;
        ends_at: string;
        sort_order: number;
        is_active: boolean;
        translations: TranslationsShape;
    };
};

type FormData = {
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

        post(url);
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
        <form onSubmit={submit} className="grid gap-8">
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
