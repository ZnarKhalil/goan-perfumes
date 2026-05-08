import { useEffect, useRef } from 'react';
import InputError from '@/components/input-error';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const TRANSLITERATIONS: Record<string, string> = {
    ä: 'ae',
    ö: 'oe',
    ü: 'ue',
    Ä: 'ae',
    Ö: 'oe',
    Ü: 'ue',
    ß: 'ss',
};

function slugify(input: string): string {
    if (!input) {
        return '';
    }

    const transliterated = input.replace(
        /[äöüÄÖÜß]/g,
        (c) => TRANSLITERATIONS[c] ?? c,
    );

    return transliterated
        .toLowerCase()
        .normalize('NFKD')
        .replace(/[̀-ͯ]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-+|-+$/g, '');
}

type Props = {
    id?: string;
    label?: string;
    value: string;
    source: string;
    error?: string;
    onChange: (value: string) => void;
    description?: string;
};

export default function SlugField({
    id = 'slug',
    label = 'URL-Kennung (Slug)',
    value,
    source,
    error,
    onChange,
    description = 'Wird automatisch aus dem deutschen Namen erzeugt. Manuell überschreibbar.',
}: Props) {
    const touchedRef = useRef(value.length > 0);
    const onChangeRef = useRef(onChange);

    useEffect(() => {
        onChangeRef.current = onChange;
    }, [onChange]);

    useEffect(() => {
        if (touchedRef.current) {
            return;
        }

        const next = slugify(source);
        onChangeRef.current(next);
    }, [source]);

    return (
        <div className="grid gap-2">
            <Label htmlFor={id}>{label}</Label>
            <Input
                id={id}
                value={value}
                onChange={(e) => {
                    touchedRef.current = e.target.value.length > 0;
                    onChange(e.target.value);
                }}
                placeholder={slugify(source) || 'damenparfums'}
            />
            {description && (
                <p className="text-xs text-muted-foreground">{description}</p>
            )}
            <InputError message={error} />
        </div>
    );
}
