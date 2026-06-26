import { Link } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import { Settings2 } from '@/components/public/icons';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import {
    disableGoogleAnalytics,
    initializeGoogleAnalytics,
} from '@/lib/google-analytics';
import { publicNavigationPrefetch } from '@/lib/inertia-cache';
import type { PublicCopy } from '@/lib/public-copy';
import { cn } from '@/lib/utils';

const consentStorageKey = 'goan_cookie_consent_v1';

type ConsentChoice = {
    necessary: true;
    analytics: boolean;
    updatedAt: string;
};

type Props = {
    copy: PublicCopy;
    privacyHref: string;
    theme?: 'light' | 'dark';
};

export default function CookieConsent({
    copy,
    privacyHref,
    theme = 'light',
}: Props) {
    const [choice, setChoice] = useState<ConsentChoice | null>(() =>
        readStoredChoice(),
    );
    const [hasLoadedChoice] = useState(true);
    const [showBanner, setShowBanner] = useState(() => choice === null);
    const [showSettings, setShowSettings] = useState(false);
    const [analyticsEnabled, setAnalyticsEnabled] = useState(
        () => choice?.analytics ?? false,
    );
    const isDark = theme === 'dark';

    useEffect(() => {
        if (choice?.analytics) {
            initializeGoogleAnalytics();

            return;
        }

        disableGoogleAnalytics();
    }, [choice]);

    function saveChoice(nextAnalyticsEnabled: boolean): void {
        const nextChoice: ConsentChoice = {
            necessary: true,
            analytics: nextAnalyticsEnabled,
            updatedAt: new Date().toISOString(),
        };

        localStorage.setItem(consentStorageKey, JSON.stringify(nextChoice));
        setChoice(nextChoice);
        setAnalyticsEnabled(nextAnalyticsEnabled);
        setShowBanner(false);
        setShowSettings(false);
    }

    function openSettings(): void {
        setAnalyticsEnabled(choice?.analytics ?? false);
        setShowBanner(false);
        setShowSettings(true);
    }

    function setSettingsOpen(open: boolean): void {
        setShowSettings(open);

        if (!open && choice === null) {
            setShowBanner(true);
        }
    }

    return (
        <>
            {showBanner && (
                <section
                    className={cn(
                        'fixed right-4 bottom-4 left-4 z-50 mx-auto max-w-5xl rounded-lg border p-4 shadow-2xl backdrop-blur-xl md:right-6 md:bottom-6 md:left-auto md:w-[31rem]',
                        isDark
                            ? 'border-white/15 bg-[#11100e]/95 text-stone-100'
                            : 'border-stone-200 bg-white/95 text-stone-950',
                    )}
                    aria-label={copy.cookies.bannerLabel}
                >
                    <div className="flex flex-col gap-4">
                        <div className="space-y-2">
                            <p className="font-display text-xl leading-tight">
                                {copy.cookies.title}
                            </p>
                            <p
                                className={cn(
                                    'text-sm leading-6',
                                    isDark
                                        ? 'text-stone-300'
                                        : 'text-stone-600',
                                )}
                            >
                                {copy.cookies.description}{' '}
                                <Link
                                    href={privacyHref}
                                    {...publicNavigationPrefetch}
                                    className={cn(
                                        'underline underline-offset-4',
                                        isDark
                                            ? 'text-[#e7c889]'
                                            : 'text-stone-950',
                                    )}
                                >
                                    {copy.cookies.privacyLink}
                                </Link>
                            </p>
                        </div>

                        <div className="grid gap-2 sm:grid-cols-3">
                            <Button
                                type="button"
                                variant="outline"
                                onClick={() => saveChoice(false)}
                                className={cn(
                                    isDark &&
                                        'border-white/15 bg-transparent text-stone-100 hover:bg-white/10 hover:text-stone-100',
                                )}
                            >
                                {copy.cookies.reject}
                            </Button>
                            <Button
                                type="button"
                                variant="outline"
                                onClick={openSettings}
                                className={cn(
                                    isDark &&
                                        'border-white/15 bg-transparent text-stone-100 hover:bg-white/10 hover:text-stone-100',
                                )}
                            >
                                <Settings2 className="size-4" />
                                {copy.cookies.settings}
                            </Button>
                            <Button
                                type="button"
                                onClick={() => saveChoice(true)}
                                className="bg-[#e7c889] text-stone-950 hover:bg-[#d7b66f]"
                            >
                                {copy.cookies.accept}
                            </Button>
                        </div>
                    </div>
                </section>
            )}

            <Dialog open={showSettings} onOpenChange={setSettingsOpen}>
                <DialogContent className="max-h-[calc(100vh-2rem)] overflow-y-auto sm:max-w-2xl">
                    <DialogHeader>
                        <DialogTitle>{copy.cookies.settingsTitle}</DialogTitle>
                        <DialogDescription>
                            {copy.cookies.settingsDescription}
                        </DialogDescription>
                    </DialogHeader>

                    <div className="grid gap-3">
                        <div className="rounded-lg border p-4">
                            <div className="flex items-start gap-3">
                                <Checkbox checked disabled />
                                <div className="space-y-1">
                                    <p className="font-medium">
                                        {copy.cookies.necessaryTitle}
                                    </p>
                                    <p className="text-sm leading-6 text-muted-foreground">
                                        {copy.cookies.necessaryDescription}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <label className="rounded-lg border p-4">
                            <div className="flex items-start gap-3">
                                <Checkbox
                                    checked={analyticsEnabled}
                                    onCheckedChange={(checked) =>
                                        setAnalyticsEnabled(checked === true)
                                    }
                                />
                                <div className="space-y-1">
                                    <p className="font-medium">
                                        {copy.cookies.analyticsTitle}
                                    </p>
                                    <p className="text-sm leading-6 text-muted-foreground">
                                        {copy.cookies.analyticsDescription}
                                    </p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <DialogFooter>
                        <Button
                            type="button"
                            variant="outline"
                            onClick={() => saveChoice(false)}
                        >
                            {copy.cookies.reject}
                        </Button>
                        <Button
                            type="button"
                            onClick={() => saveChoice(analyticsEnabled)}
                        >
                            {copy.cookies.save}
                        </Button>
                        <Button type="button" onClick={() => saveChoice(true)}>
                            {copy.cookies.accept}
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>

            {hasLoadedChoice && (
                <button
                    type="button"
                    onClick={openSettings}
                    className={cn(
                        'text-left text-xs underline-offset-4 transition-colors duration-300 hover:underline',
                        isDark
                            ? 'text-stone-400 hover:text-[#e7c889]'
                            : 'text-stone-500 hover:text-stone-900',
                    )}
                >
                    {copy.cookies.footerSettings}
                </button>
            )}
        </>
    );
}

function readStoredChoice(): ConsentChoice | null {
    try {
        const rawChoice = localStorage.getItem(consentStorageKey);

        if (!rawChoice) {
            return null;
        }

        const parsedChoice = JSON.parse(rawChoice) as Partial<ConsentChoice>;

        return {
            necessary: true,
            analytics: parsedChoice.analytics === true,
            updatedAt:
                typeof parsedChoice.updatedAt === 'string'
                    ? parsedChoice.updatedAt
                    : new Date().toISOString(),
        };
    } catch {
        return null;
    }
}
