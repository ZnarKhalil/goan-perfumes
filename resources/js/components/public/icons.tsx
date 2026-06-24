import type { SVGProps } from 'react';

type IconProps = SVGProps<SVGSVGElement>;

function IconBase({ children, ...props }: IconProps) {
    return (
        <svg
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            strokeWidth="2"
            strokeLinecap="round"
            strokeLinejoin="round"
            aria-hidden
            {...props}
        >
            {children}
        </svg>
    );
}

export function ArrowLeft(props: IconProps) {
    return (
        <IconBase {...props}>
            <path d="m12 19-7-7 7-7" />
            <path d="M19 12H5" />
        </IconBase>
    );
}

export function ArrowRight(props: IconProps) {
    return (
        <IconBase {...props}>
            <path d="M5 12h14" />
            <path d="m12 5 7 7-7 7" />
        </IconBase>
    );
}

export function Check(props: IconProps) {
    return (
        <IconBase {...props}>
            <path d="m20 6-11 11-5-5" />
        </IconBase>
    );
}

export function ChevronDown(props: IconProps) {
    return (
        <IconBase {...props}>
            <path d="m6 9 6 6 6-6" />
        </IconBase>
    );
}

export function ChevronRight(props: IconProps) {
    return (
        <IconBase {...props}>
            <path d="m9 18 6-6-6-6" />
        </IconBase>
    );
}

export function Menu(props: IconProps) {
    return (
        <IconBase {...props}>
            <path d="M4 6h16" />
            <path d="M4 12h16" />
            <path d="M4 18h16" />
        </IconBase>
    );
}

export function Search(props: IconProps) {
    return (
        <IconBase {...props}>
            <circle cx="11" cy="11" r="7" />
            <path d="m20 20-3.5-3.5" />
        </IconBase>
    );
}

export function X(props: IconProps) {
    return (
        <IconBase {...props}>
            <path d="M18 6 6 18" />
            <path d="m6 6 12 12" />
        </IconBase>
    );
}

export function Mail(props: IconProps) {
    return (
        <IconBase {...props}>
            <rect x="3" y="5" width="18" height="14" rx="2" />
            <path d="m3 7 9 6 9-6" />
        </IconBase>
    );
}

export function MessageCircle(props: IconProps) {
    return (
        <IconBase {...props}>
            <path d="M21 11.5a8.4 8.4 0 0 1-9 8.4 8.6 8.6 0 0 1-4-.9L3 20l1.3-4.1a8.5 8.5 0 1 1 16.7-4.4Z" />
        </IconBase>
    );
}

export function Phone(props: IconProps) {
    return (
        <IconBase {...props}>
            <path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.7 19.7 0 0 1-8.6-3.1 19.4 19.4 0 0 1-6-6A19.7 19.7 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.2a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z" />
        </IconBase>
    );
}

export function Send(props: IconProps) {
    return (
        <IconBase {...props}>
            <path d="m22 2-7 20-4-9-9-4Z" />
            <path d="M22 2 11 13" />
        </IconBase>
    );
}

export function Settings2(props: IconProps) {
    return (
        <IconBase {...props}>
            <path d="M20 7h-9" />
            <path d="M14 17H4" />
            <circle cx="7" cy="7" r="3" />
            <circle cx="17" cy="17" r="3" />
        </IconBase>
    );
}

export function Video(props: IconProps) {
    return (
        <IconBase {...props}>
            <path d="M15 10 21 6v12l-6-4" />
            <rect x="3" y="6" width="12" height="12" rx="2" />
        </IconBase>
    );
}

export function Facebook(props: IconProps) {
    return (
        <IconBase {...props}>
            <path d="M15 8h-2a2 2 0 0 0-2 2v3H8v4h3v5h4v-5h3l1-4h-4v-2a1 1 0 0 1 1-1h3V6h-4a4 4 0 0 0-4 4v3" />
        </IconBase>
    );
}

export function Instagram(props: IconProps) {
    return (
        <IconBase {...props}>
            <rect x="3" y="3" width="18" height="18" rx="5" />
            <circle cx="12" cy="12" r="4" />
            <path d="M17.5 6.5h.01" />
        </IconBase>
    );
}

export function Tiktok(props: IconProps) {
    return (
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden {...props}>
            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
        </svg>
    );
}

export function Circle(props: IconProps) {
    return (
        <IconBase {...props}>
            <circle cx="12" cy="12" r="4" />
        </IconBase>
    );
}
