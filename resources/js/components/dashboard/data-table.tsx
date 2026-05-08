import type { ReactNode } from 'react';
import { cn } from '@/lib/utils';

export type DataTableColumn<T> = {
    key: string;
    label: string;
    className?: string;
    render?: (row: T) => ReactNode;
};

type Props<T> = {
    columns: DataTableColumn<T>[];
    rows: T[];
    rowKey: (row: T) => string | number;
    actions?: (row: T) => ReactNode;
    emptyMessage?: string;
    className?: string;
};

export default function DataTable<T>({
    columns,
    rows,
    rowKey,
    actions,
    emptyMessage = 'Keine Einträge.',
    className,
}: Props<T>) {
    return (
        <div
            className={cn(
                'overflow-hidden rounded-lg border border-sidebar-border/70 dark:border-sidebar-border',
                className,
            )}
        >
            <table className="w-full text-sm">
                <thead className="bg-muted/50 text-left text-xs tracking-wide text-muted-foreground uppercase">
                    <tr>
                        {columns.map((col) => (
                            <th
                                key={col.key}
                                className={cn(
                                    'px-4 py-2 font-medium',
                                    col.className,
                                )}
                            >
                                {col.label}
                            </th>
                        ))}
                        {actions && (
                            <th className="px-4 py-2 text-right font-medium">
                                Aktionen
                            </th>
                        )}
                    </tr>
                </thead>
                <tbody className="divide-y divide-sidebar-border/70 dark:divide-sidebar-border">
                    {rows.length === 0 ? (
                        <tr>
                            <td
                                className="px-4 py-6 text-center text-muted-foreground"
                                colSpan={columns.length + (actions ? 1 : 0)}
                            >
                                {emptyMessage}
                            </td>
                        </tr>
                    ) : (
                        rows.map((row) => (
                            <tr key={rowKey(row)} className="hover:bg-muted/30">
                                {columns.map((col) => (
                                    <td
                                        key={col.key}
                                        className={cn(
                                            'px-4 py-3 align-middle',
                                            col.className,
                                        )}
                                    >
                                        {col.render
                                            ? col.render(row)
                                            : String(
                                                  (
                                                      row as Record<
                                                          string,
                                                          unknown
                                                      >
                                                  )[col.key] ?? '',
                                              )}
                                    </td>
                                ))}
                                {actions && (
                                    <td className="px-4 py-3 text-right">
                                        <div className="inline-flex items-center gap-2">
                                            {actions(row)}
                                        </div>
                                    </td>
                                )}
                            </tr>
                        ))
                    )}
                </tbody>
            </table>
        </div>
    );
}
