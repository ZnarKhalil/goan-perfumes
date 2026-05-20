import {
    closestCenter,
    DndContext,
    KeyboardSensor,
    PointerSensor,
    useSensor,
    useSensors,
} from '@dnd-kit/core';
import type { DragEndEvent } from '@dnd-kit/core';
import {
    arrayMove,
    horizontalListSortingStrategy,
    SortableContext,
    sortableKeyboardCoordinates,
    useSortable,
} from '@dnd-kit/sortable';
import { CSS } from '@dnd-kit/utilities';
import { GripVertical, Star, Trash2, Upload } from 'lucide-react';
import { useEffect, useId, useMemo, useRef } from 'react';
import type { ChangeEvent, DragEvent } from 'react';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';

export type MediaItem = {
    /** A stable identifier — server id for existing rows, a generated string for new uploads. */
    id: string;
    /** Server-side primary key when this row already exists. */
    serverId?: number;
    /** Existing public URL if the item is already stored. */
    url?: string;
    /** New file pending upload. */
    file?: File;
    sort_order: number;
    is_primary: boolean;
    alt_text?: string;
    alt_text_translations?: MediaAltText;
};

export type MediaAltText = {
    de: string;
    ar: string;
    en: string;
};

type SingleProps = {
    mode: 'single';
    value: File | null;
    existingUrl?: string | null;
    onChange: (file: File | null) => void;
    onRemove?: () => void;
    error?: string;
    label?: string;
    accept?: string;
    previewType?: 'image' | 'video';
};

type MultiProps = {
    mode: 'multi';
    items: MediaItem[];
    onItemsChange: (items: MediaItem[]) => void;
    error?: string;
    label?: string;
    accept?: string;
    /** Max items for client-side guard. Server still authoritative. */
    max?: number;
};

type Props = SingleProps | MultiProps;

const ACCEPT_DEFAULT = 'image/png,image/jpeg,image/webp,image/avif';

export default function MediaUploader(props: Props) {
    if (props.mode === 'single') {
        return <SingleUploader {...props} />;
    }

    return <MultiUploader {...props} />;
}

function SingleUploader({
    value,
    existingUrl,
    onChange,
    onRemove,
    error,
    label = 'Bild',
    accept = ACCEPT_DEFAULT,
    previewType = 'image',
}: SingleProps) {
    const inputId = useId();
    const inputRef = useRef<HTMLInputElement | null>(null);
    const objectUrl = useMemo(
        () => (value ? URL.createObjectURL(value) : null),
        [value],
    );
    const preview = objectUrl ?? existingUrl ?? null;

    useEffect(() => {
        if (!objectUrl) {
            return;
        }

        return () => URL.revokeObjectURL(objectUrl);
    }, [objectUrl]);

    const onPick = (event: ChangeEvent<HTMLInputElement>) => {
        const file = event.target.files?.[0] ?? null;
        onChange(file);
    };

    const clear = () => {
        onChange(null);

        if (inputRef.current) {
            inputRef.current.value = '';
        }

        if (existingUrl && onRemove) {
            onRemove();
        }
    };

    return (
        <div className="grid gap-2">
            <label htmlFor={inputId} className="text-sm font-medium">
                {label}
            </label>
            <div
                onDragOver={(e: DragEvent<HTMLDivElement>) =>
                    e.preventDefault()
                }
                onDrop={(e: DragEvent<HTMLDivElement>) => {
                    e.preventDefault();
                    const file = e.dataTransfer.files?.[0];

                    if (file) {
                        onChange(file);
                    }
                }}
                className="relative flex min-h-32 items-center justify-center overflow-hidden rounded-lg border border-dashed border-input bg-muted/30 px-4 py-6"
            >
                {preview ? (
                    <div className="flex w-full items-start gap-4">
                        {previewType === 'video' ? (
                            <video
                                src={preview}
                                className="h-32 w-48 rounded-md object-cover"
                                muted
                                playsInline
                                controls
                            />
                        ) : (
                            <img
                                src={preview}
                                alt=""
                                className="h-32 w-32 rounded-md object-cover"
                            />
                        )}
                        <div className="flex flex-col gap-2">
                            <Button
                                type="button"
                                variant="outline"
                                size="sm"
                                onClick={() => inputRef.current?.click()}
                            >
                                Datei ersetzen
                            </Button>
                            <Button
                                type="button"
                                variant="ghost"
                                size="sm"
                                onClick={clear}
                            >
                                <Trash2 className="mr-1 h-4 w-4" /> Entfernen
                            </Button>
                        </div>
                    </div>
                ) : (
                    <button
                        type="button"
                        onClick={() => inputRef.current?.click()}
                        className="flex flex-col items-center gap-1 text-sm text-muted-foreground"
                    >
                        <Upload className="h-6 w-6" />
                        Datei auswählen oder hierher ziehen
                    </button>
                )}
                <input
                    id={inputId}
                    ref={inputRef}
                    type="file"
                    className="sr-only"
                    accept={accept}
                    onChange={onPick}
                />
            </div>
            <InputError message={error} />
        </div>
    );
}

function MultiUploader({
    items,
    onItemsChange,
    error,
    label = 'Bilder',
    accept = ACCEPT_DEFAULT,
    max = 20,
}: MultiProps) {
    const inputId = useId();
    const inputRef = useRef<HTMLInputElement | null>(null);
    const sensors = useSensors(
        useSensor(PointerSensor, { activationConstraint: { distance: 4 } }),
        useSensor(KeyboardSensor, {
            coordinateGetter: sortableKeyboardCoordinates,
        }),
    );

    const onPick = (event: ChangeEvent<HTMLInputElement>) => {
        const files = Array.from(event.target.files ?? []);
        appendFiles(files);

        if (inputRef.current) {
            inputRef.current.value = '';
        }
    };

    const appendFiles = (files: File[]) => {
        if (files.length === 0) {
            return;
        }

        const next = [...items];
        files.forEach((file) => {
            if (next.length >= max) {
                return;
            }

            next.push({
                id: `new-${Date.now()}-${Math.random().toString(36).slice(2, 8)}`,
                file,
                sort_order: next.length,
                is_primary:
                    next.length === 0 && !items.some((i) => i.is_primary),
                alt_text: '',
                alt_text_translations: emptyAltText(),
            });
        });
        onItemsChange(reindex(next));
    };

    const onDragEnd = (event: DragEndEvent) => {
        const { active, over } = event;

        if (!over || active.id === over.id) {
            return;
        }

        const oldIndex = items.findIndex((i) => i.id === active.id);
        const newIndex = items.findIndex((i) => i.id === over.id);

        if (oldIndex < 0 || newIndex < 0) {
            return;
        }

        onItemsChange(reindex(arrayMove(items, oldIndex, newIndex)));
    };

    const setPrimary = (id: string) => {
        onItemsChange(
            items.map((item) => ({ ...item, is_primary: item.id === id })),
        );
    };

    const remove = (id: string) => {
        onItemsChange(reindex(items.filter((i) => i.id !== id)));
    };

    const setAlt = (id: string, locale: keyof MediaAltText, value: string) => {
        onItemsChange(
            items.map((item) => {
                if (item.id !== id) {
                    return item;
                }

                const translations = {
                    ...altTextFor(item),
                    [locale]: value,
                };

                return {
                    ...item,
                    alt_text: translations.de,
                    alt_text_translations: translations,
                };
            }),
        );
    };

    return (
        <div className="grid gap-2">
            <div className="flex items-center justify-between">
                <span className="text-sm font-medium">{label}</span>
                <Button
                    type="button"
                    variant="outline"
                    size="sm"
                    onClick={() => inputRef.current?.click()}
                    disabled={items.length >= max}
                >
                    <Upload className="mr-1 h-4 w-4" /> Bilder hinzufügen
                </Button>
            </div>
            <div
                onDragOver={(e: DragEvent<HTMLDivElement>) =>
                    e.preventDefault()
                }
                onDrop={(e: DragEvent<HTMLDivElement>) => {
                    e.preventDefault();
                    appendFiles(Array.from(e.dataTransfer.files ?? []));
                }}
                className="rounded-lg border border-dashed border-input bg-muted/30 p-3"
            >
                {items.length === 0 ? (
                    <p className="py-8 text-center text-sm text-muted-foreground">
                        Bilder hierher ziehen oder auswählen.
                    </p>
                ) : (
                    <DndContext
                        sensors={sensors}
                        collisionDetection={closestCenter}
                        onDragEnd={onDragEnd}
                    >
                        <SortableContext
                            items={items.map((i) => i.id)}
                            strategy={horizontalListSortingStrategy}
                        >
                            <div className="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
                                {items.map((item) => (
                                    <SortableMedia
                                        key={item.id}
                                        item={item}
                                        onSetPrimary={setPrimary}
                                        onRemove={remove}
                                        onAltChange={setAlt}
                                    />
                                ))}
                            </div>
                        </SortableContext>
                    </DndContext>
                )}
                <input
                    id={inputId}
                    ref={inputRef}
                    type="file"
                    className="sr-only"
                    accept={accept}
                    multiple
                    onChange={onPick}
                />
            </div>
            <InputError message={error} />
        </div>
    );
}

function reindex(items: MediaItem[]): MediaItem[] {
    return items.map((item, index) => ({ ...item, sort_order: index }));
}

function emptyAltText(): MediaAltText {
    return { de: '', ar: '', en: '' };
}

function altTextFor(item: MediaItem): MediaAltText {
    return {
        ...emptyAltText(),
        ...(item.alt_text_translations ?? {}),
        de: item.alt_text_translations?.de ?? item.alt_text ?? '',
    };
}

type SortableMediaProps = {
    item: MediaItem;
    onSetPrimary: (id: string) => void;
    onRemove: (id: string) => void;
    onAltChange: (
        id: string,
        locale: keyof MediaAltText,
        value: string,
    ) => void;
};

function SortableMedia({
    item,
    onSetPrimary,
    onRemove,
    onAltChange,
}: SortableMediaProps) {
    const {
        attributes,
        listeners,
        setNodeRef,
        transform,
        transition,
        isDragging,
    } = useSortable({ id: item.id });

    const objectUrl = useMemo(
        () => (item.file ? URL.createObjectURL(item.file) : null),
        [item.file],
    );
    const previewUrl = objectUrl ?? item.url ?? '';
    const altText = altTextFor(item);

    useEffect(() => {
        if (!objectUrl) {
            return;
        }

        return () => URL.revokeObjectURL(objectUrl);
    }, [objectUrl]);

    const style = {
        transform: CSS.Transform.toString(transform),
        transition,
        opacity: isDragging ? 0.6 : 1,
    };

    return (
        <div
            ref={setNodeRef}
            style={style}
            className={cn(
                'group relative overflow-hidden rounded-md border border-input bg-background',
                item.is_primary && 'ring-2 ring-primary',
            )}
        >
            <button
                type="button"
                aria-label="Verschieben"
                className="absolute top-1 left-1 z-10 rounded bg-background/70 p-1"
                {...attributes}
                {...listeners}
            >
                <GripVertical className="h-4 w-4" />
            </button>
            <button
                type="button"
                aria-label="Als Hauptbild"
                onClick={() => onSetPrimary(item.id)}
                className={cn(
                    'absolute top-1 right-1 z-10 rounded bg-background/70 p-1',
                    item.is_primary ? 'text-primary' : 'text-muted-foreground',
                )}
            >
                <Star
                    className="h-4 w-4"
                    fill={item.is_primary ? 'currentColor' : 'none'}
                />
            </button>
            <button
                type="button"
                aria-label="Entfernen"
                onClick={() => onRemove(item.id)}
                className="absolute right-1 bottom-1 z-10 rounded bg-background/70 p-1 text-destructive"
            >
                <Trash2 className="h-4 w-4" />
            </button>
            {previewUrl && (
                <img
                    src={previewUrl}
                    alt=""
                    className="aspect-square w-full object-cover"
                />
            )}
            <div className="grid gap-1 border-t border-input p-2">
                {(
                    [
                        ['de', 'Alt-Text DE'],
                        ['ar', 'Alt-Text AR'],
                        ['en', 'Alt-Text EN'],
                    ] as const
                ).map(([locale, placeholder]) => (
                    <input
                        key={locale}
                        type="text"
                        dir={locale === 'ar' ? 'rtl' : undefined}
                        placeholder={placeholder}
                        value={altText[locale]}
                        onChange={(e) =>
                            onAltChange(item.id, locale, e.target.value)
                        }
                        className="block w-full rounded border border-input bg-transparent px-2 py-1 text-xs outline-none"
                    />
                ))}
            </div>
        </div>
    );
}
