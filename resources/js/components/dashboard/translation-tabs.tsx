import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';

const LOCALES = [
    { code: 'de', label: 'Deutsch' },
    { code: 'ar', label: 'العربية' },
    { code: 'en', label: 'English' },
] as const;

export type TranslationLocale = (typeof LOCALES)[number]['code'];

export type TranslationField = {
    name: string;
    label: string;
    type?: 'text' | 'textarea';
    rows?: number;
};

export type TranslationsShape = Record<
    TranslationLocale,
    Record<string, string>
>;

export type TranslationErrors = Record<string, string | undefined>;

type Props = {
    fields: TranslationField[];
    values: TranslationsShape;
    errors?: TranslationErrors;
    requiredLocale?: TranslationLocale;
    requiredFields?: string[];
    onChange: (locale: TranslationLocale, field: string, value: string) => void;
};

export function emptyTranslations(
    fields: TranslationField[],
): TranslationsShape {
    const blank = Object.fromEntries(fields.map((f) => [f.name, '']));

    return {
        de: { ...blank },
        ar: { ...blank },
        en: { ...blank },
    };
}

export default function TranslationTabs({
    fields,
    values,
    errors = {},
    requiredLocale = 'de',
    requiredFields = ['name'],
    onChange,
}: Props) {
    return (
        <Tabs defaultValue={requiredLocale} className="w-full">
            <TabsList>
                {LOCALES.map((locale) => (
                    <TabsTrigger key={locale.code} value={locale.code}>
                        {locale.label}
                        {locale.code === requiredLocale &&
                            requiredFields.length > 0 && (
                                <span className="ml-1 text-destructive">*</span>
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
                    {fields.map((field) => {
                        const errorKey = `translations.${locale.code}.${field.name}`;
                        const value = values[locale.code]?.[field.name] ?? '';
                        const id = `${locale.code}-${field.name}`;
                        const isRequired =
                            locale.code === requiredLocale &&
                            requiredFields.includes(field.name);

                        return (
                            <div key={id} className="grid gap-2">
                                <Label htmlFor={id}>
                                    {field.label}
                                    {isRequired && (
                                        <span className="ml-1 text-destructive">
                                            *
                                        </span>
                                    )}
                                </Label>
                                {field.type === 'textarea' ? (
                                    <textarea
                                        id={id}
                                        rows={field.rows ?? 4}
                                        value={value}
                                        className="flex w-full rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-xs transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-[3px] focus-visible:ring-ring/50 aria-invalid:border-destructive aria-invalid:ring-destructive/20"
                                        onChange={(e) =>
                                            onChange(
                                                locale.code,
                                                field.name,
                                                e.target.value,
                                            )
                                        }
                                    />
                                ) : (
                                    <Input
                                        id={id}
                                        value={value}
                                        onChange={(e) =>
                                            onChange(
                                                locale.code,
                                                field.name,
                                                e.target.value,
                                            )
                                        }
                                    />
                                )}
                                <InputError message={errors[errorKey]} />
                            </div>
                        );
                    })}
                </TabsContent>
            ))}
        </Tabs>
    );
}
