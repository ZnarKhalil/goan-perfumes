import { Head, useForm } from '@inertiajs/react';
import type { FormEvent } from 'react';
import MediaUploader from '@/components/dashboard/media-uploader';
import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { adminTitle, dashboardLabels } from '@/lib/de';
import { publicContentCacheTags } from '@/lib/inertia-cache';
import siteSettingsRoutes from '@/routes/dashboard/settings/site';

type Settings = {
    whatsapp_number: string;
    email: string;
    phone: string;
    instagram_url: string;
    tiktok_url: string;
    facebook_url: string;
    default_locale: 'de' | 'ar' | 'en';
    logo_path: string;
    logo_url: string | null;
};

type Props = {
    settings: Settings;
};

type FormData = Omit<Settings, 'logo_path' | 'logo_url'> & {
    logo: File | null;
    remove_logo: boolean;
    _method: 'PUT';
};

const localeLabels = {
    de: 'Deutsch',
    ar: 'العربية',
    en: 'English',
};

export default function SiteSettings({ settings }: Props) {
    const { data, setData, post, processing, errors } = useForm<FormData>({
        whatsapp_number: settings.whatsapp_number ?? '',
        email: settings.email ?? '',
        phone: settings.phone ?? '',
        instagram_url: settings.instagram_url ?? '',
        tiktok_url: settings.tiktok_url ?? '',
        facebook_url: settings.facebook_url ?? '',
        default_locale: settings.default_locale ?? 'de',
        logo: null,
        remove_logo: false,
        _method: 'PUT',
    });

    const submit = (event: FormEvent) => {
        event.preventDefault();

        post(siteSettingsRoutes.update().url, {
            forceFormData: true,
            invalidateCacheTags: publicContentCacheTags,
            preserveScroll: true,
        });
    };

    return (
        <>
            <Head title={adminTitle(dashboardLabels.siteSettings)} />
            <div className="flex h-full flex-1 flex-col gap-4 p-4">
                <Heading
                    title="Website-Einstellungen"
                    description="Verwalte Kontaktinformationen, Social Links, Sprache und Logo."
                />

                <form
                    onSubmit={submit}
                    className="grid gap-8"
                    encType="multipart/form-data"
                >
                    <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                        <h3 className="text-sm font-medium">Kontakt</h3>
                        <div className="grid gap-4 md:grid-cols-2">
                            <Field
                                id="whatsapp_number"
                                label="WhatsApp"
                                value={data.whatsapp_number}
                                error={errors.whatsapp_number}
                                placeholder="+49 170 0000000"
                                onChange={(value) =>
                                    setData('whatsapp_number', value)
                                }
                            />
                            <Field
                                id="phone"
                                label="Telefon"
                                value={data.phone}
                                error={errors.phone}
                                placeholder="+49 30 0000000"
                                onChange={(value) => setData('phone', value)}
                            />
                            <Field
                                id="email"
                                label="E-Mail"
                                type="email"
                                value={data.email}
                                error={errors.email}
                                placeholder="kontakt@goanperfume.de"
                                onChange={(value) => setData('email', value)}
                            />
                            <div className="grid gap-2">
                                <Label htmlFor="default_locale">
                                    Standardsprache
                                </Label>
                                <Select
                                    value={data.default_locale}
                                    onValueChange={(value) =>
                                        setData(
                                            'default_locale',
                                            value as FormData['default_locale'],
                                        )
                                    }
                                >
                                    <SelectTrigger
                                        id="default_locale"
                                        className="w-full"
                                    >
                                        <SelectValue />
                                    </SelectTrigger>
                                    <SelectContent>
                                        {Object.entries(localeLabels).map(
                                            ([value, label]) => (
                                                <SelectItem
                                                    key={value}
                                                    value={value}
                                                >
                                                    {label}
                                                </SelectItem>
                                            ),
                                        )}
                                    </SelectContent>
                                </Select>
                                <InputError message={errors.default_locale} />
                            </div>
                        </div>
                    </section>

                    <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                        <h3 className="text-sm font-medium">Social Links</h3>
                        <div className="grid gap-4 md:grid-cols-2">
                            <Field
                                id="instagram_url"
                                label="Instagram URL"
                                type="url"
                                value={data.instagram_url}
                                error={errors.instagram_url}
                                placeholder="https://instagram.com/..."
                                onChange={(value) =>
                                    setData('instagram_url', value)
                                }
                            />
                            <Field
                                id="tiktok_url"
                                label="TikTok URL"
                                type="url"
                                value={data.tiktok_url}
                                error={errors.tiktok_url}
                                placeholder="https://tiktok.com/@..."
                                onChange={(value) =>
                                    setData('tiktok_url', value)
                                }
                            />
                            <Field
                                id="facebook_url"
                                label="Facebook URL"
                                type="url"
                                value={data.facebook_url}
                                error={errors.facebook_url}
                                placeholder="https://facebook.com/..."
                                onChange={(value) =>
                                    setData('facebook_url', value)
                                }
                            />
                        </div>
                    </section>

                    <section className="grid gap-4 rounded-lg border border-sidebar-border/70 p-6 dark:border-sidebar-border">
                        <h3 className="text-sm font-medium">Logo</h3>
                        <MediaUploader
                            mode="single"
                            label="Logo"
                            value={data.logo}
                            existingUrl={
                                data.remove_logo ? null : settings.logo_url
                            }
                            onChange={(file) => {
                                setData('logo', file);

                                if (file) {
                                    setData('remove_logo', false);
                                }
                            }}
                            onRemove={() => setData('remove_logo', true)}
                            error={errors.logo}
                        />
                    </section>

                    <div>
                        <Button type="submit" disabled={processing}>
                            Speichern
                        </Button>
                    </div>
                </form>
            </div>
        </>
    );
}

function Field({
    id,
    label,
    value,
    error,
    placeholder,
    type = 'text',
    onChange,
}: {
    id: string;
    label: string;
    value: string;
    error?: string;
    placeholder?: string;
    type?: string;
    onChange: (value: string) => void;
}) {
    return (
        <div className="grid gap-2">
            <Label htmlFor={id}>{label}</Label>
            <Input
                id={id}
                type={type}
                value={value}
                placeholder={placeholder}
                onChange={(event) => onChange(event.target.value)}
            />
            <InputError message={error} />
        </div>
    );
}

SiteSettings.layout = {
    breadcrumbs: [
        { title: dashboardLabels.dashboard, href: '/dashboard' },
        {
            title: dashboardLabels.siteSettings,
            href: siteSettingsRoutes.edit(),
        },
    ],
};
