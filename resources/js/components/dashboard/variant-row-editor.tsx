import { Plus, Trash2 } from 'lucide-react';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

export type VariantRow = {
    id?: number;
    size_ml: number | '';
    price: string;
    compare_at_price: string;
    is_default: boolean;
    is_active: boolean;
};

type Props = {
    value: VariantRow[];
    onChange: (variants: VariantRow[]) => void;
    errors?: Record<string, string | undefined>;
};

const emptyVariant = (): VariantRow => ({
    size_ml: '',
    price: '',
    compare_at_price: '',
    is_default: false,
    is_active: true,
});

export default function VariantRowEditor({
    value,
    onChange,
    errors = {},
}: Props) {
    const variants =
        value.length > 0 ? value : [{ ...emptyVariant(), is_default: true }];

    const update = (
        index: number,
        patch: Partial<VariantRow>,
        options: { makeDefault?: boolean } = {},
    ) => {
        const next = variants.map((variant, currentIndex) => {
            if (currentIndex !== index) {
                return options.makeDefault
                    ? { ...variant, is_default: false }
                    : variant;
            }

            return { ...variant, ...patch };
        });

        onChange(ensureOneDefault(next));
    };

    const add = () => {
        onChange([...variants, emptyVariant()]);
    };

    const remove = (index: number) => {
        onChange(ensureOneDefault(variants.filter((_, i) => i !== index)));
    };

    return (
        <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
            <div className="flex items-start justify-between gap-4">
                <div>
                    <h3 className="text-sm font-medium">Varianten</h3>
                    <p className="text-sm text-muted-foreground">
                        Preise werden pro Größe gepflegt. Eine Variante ist der
                        Standard für Produktkarten.
                    </p>
                </div>
                <Button type="button" variant="outline" onClick={add}>
                    <Plus className="mr-1 h-4 w-4" /> Variante
                </Button>
            </div>

            <div className="grid gap-3">
                {variants.map((variant, index) => (
                    <div
                        key={variant.id ?? index}
                        className="grid gap-3 rounded-md border border-sidebar-border/70 p-4 dark:border-sidebar-border"
                    >
                        <div className="grid gap-3 md:grid-cols-[8rem_1fr_1fr_auto]">
                            <div className="grid gap-2">
                                <Label htmlFor={`variant-${index}-size`}>
                                    Größe (ml)
                                </Label>
                                <Input
                                    id={`variant-${index}-size`}
                                    type="number"
                                    min={1}
                                    step={1}
                                    value={variant.size_ml}
                                    onChange={(e) =>
                                        update(index, {
                                            size_ml: e.target.value
                                                ? Number(e.target.value)
                                                : '',
                                        })
                                    }
                                />
                                <InputError
                                    message={
                                        errors[`variants.${index}.size_ml`]
                                    }
                                />
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor={`variant-${index}-price`}>
                                    Preis
                                </Label>
                                <Input
                                    id={`variant-${index}-price`}
                                    type="number"
                                    min={0}
                                    step="0.01"
                                    value={variant.price}
                                    onChange={(e) =>
                                        update(index, {
                                            price: e.target.value,
                                        })
                                    }
                                />
                                <InputError
                                    message={errors[`variants.${index}.price`]}
                                />
                            </div>

                            <div className="grid gap-2">
                                <Label htmlFor={`variant-${index}-compare`}>
                                    Vergleichspreis
                                </Label>
                                <Input
                                    id={`variant-${index}-compare`}
                                    type="number"
                                    min={0}
                                    step="0.01"
                                    value={variant.compare_at_price}
                                    onChange={(e) =>
                                        update(index, {
                                            compare_at_price: e.target.value,
                                        })
                                    }
                                />
                                <InputError
                                    message={
                                        errors[
                                            `variants.${index}.compare_at_price`
                                        ]
                                    }
                                />
                            </div>

                            <div className="flex items-start justify-end pt-7">
                                <Button
                                    type="button"
                                    variant="ghost"
                                    size="sm"
                                    onClick={() => remove(index)}
                                    disabled={variants.length === 1}
                                >
                                    <Trash2 className="h-4 w-4" />
                                </Button>
                            </div>
                        </div>

                        <div className="flex flex-wrap gap-4">
                            <div className="flex items-center gap-2">
                                <Checkbox
                                    id={`variant-${index}-default`}
                                    checked={variant.is_default}
                                    onCheckedChange={(checked) => {
                                        if (checked === true) {
                                            update(
                                                index,
                                                { is_default: true },
                                                { makeDefault: true },
                                            );
                                        }
                                    }}
                                />
                                <Label htmlFor={`variant-${index}-default`}>
                                    Standard
                                </Label>
                            </div>

                            <div className="flex items-center gap-2">
                                <Checkbox
                                    id={`variant-${index}-active`}
                                    checked={variant.is_active}
                                    onCheckedChange={(checked) =>
                                        update(index, {
                                            is_active: checked === true,
                                        })
                                    }
                                />
                                <Label htmlFor={`variant-${index}-active`}>
                                    Aktiv
                                </Label>
                            </div>
                        </div>
                    </div>
                ))}
            </div>

            <InputError message={errors.variants} />
        </section>
    );
}

function ensureOneDefault(variants: VariantRow[]): VariantRow[] {
    if (variants.length === 0) {
        return [{ ...emptyVariant(), is_default: true }];
    }

    if (variants.some((variant) => variant.is_default)) {
        return variants;
    }

    return variants.map((variant, index) => ({
        ...variant,
        is_default: index === 0,
    }));
}
