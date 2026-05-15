import { formatPriceRange } from '@/lib/public-format';
import { cn } from '@/lib/utils';

type Props = {
    min: string | null;
    max: string | null;
    className?: string;
};

export default function Price({ min, max, className }: Props) {
    return (
        <span className={cn('tabular-nums', className)}>
            {formatPriceRange(min, max)}
        </span>
    );
}
