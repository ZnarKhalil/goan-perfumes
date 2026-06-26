import type { ReactNode } from 'react';

type RevealElement = 'div' | 'li';

type Props = {
    children: ReactNode;
    className?: string;
    /** Render element, preserving valid semantics inside lists. */
    as?: RevealElement;
};

/**
 * Semantic wrapper retained so home sections can keep consistent structure
 * without loading a client animation runtime on the initial public page.
 */
export default function Reveal({
    children,
    className,
    as = 'div',
}: Props) {
    if (as === 'li') {
        return <li className={className}>{children}</li>;
    }

    return <div className={className}>{children}</div>;
}
