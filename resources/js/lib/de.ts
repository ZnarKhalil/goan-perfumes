export const dashboardLabels = {
    dashboard: 'Dashboard',
    products: 'Produkte',
    categories: 'Kategorien',
    attributes: 'Attribute',
    promotions: 'Aktionen',
    pageSections: 'Seiten-Inhalt',
    settings: 'Einstellungen',
    siteSettings: 'Website-Einstellungen',
} as const;

export function adminTitle(title: string): string {
    return `${title} · Goan Perfume Admin`;
}
