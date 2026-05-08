import { Link } from '@inertiajs/react';
import {
    BookOpen,
    FolderGit2,
    FolderTree,
    LayoutGrid,
    LayoutTemplate,
    Package,
    Megaphone,
    Settings,
    SlidersHorizontal,
} from 'lucide-react';
import AppLogo from '@/components/app-logo';
import { NavFooter } from '@/components/nav-footer';
import { NavMain } from '@/components/nav-main';
import { NavUser } from '@/components/nav-user';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboardLabels } from '@/lib/de';
import { dashboard } from '@/routes';
import attributesRoutes from '@/routes/dashboard/attributes';
import categoriesRoutes from '@/routes/dashboard/categories';
import pageSectionsRoutes from '@/routes/dashboard/page-sections';
import productsRoutes from '@/routes/dashboard/products';
import promotionsRoutes from '@/routes/dashboard/promotions';
import siteSettingsRoutes from '@/routes/dashboard/settings/site';
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: dashboardLabels.dashboard,
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: dashboardLabels.products,
        href: productsRoutes.index(),
        icon: Package,
    },
    {
        title: dashboardLabels.categories,
        href: categoriesRoutes.index(),
        icon: FolderTree,
    },
    {
        title: dashboardLabels.attributes,
        href: attributesRoutes.index(),
        icon: SlidersHorizontal,
    },
    {
        title: dashboardLabels.promotions,
        href: promotionsRoutes.index(),
        icon: Megaphone,
    },
    {
        title: dashboardLabels.pageSections,
        href: pageSectionsRoutes.index(),
        icon: LayoutTemplate,
    },
    {
        title: dashboardLabels.settings,
        href: siteSettingsRoutes.edit(),
        icon: Settings,
        separatorBefore: true,
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Repository',
        href: 'https://github.com/laravel/react-starter-kit',
        icon: FolderGit2,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#react',
        icon: BookOpen,
    },
];

export function AppSidebar() {
    return (
        <Sidebar collapsible="icon" variant="inset">
            <SidebarHeader>
                <SidebarMenu>
                    <SidebarMenuItem>
                        <SidebarMenuButton size="lg" asChild>
                            <Link href={dashboard()} prefetch>
                                <AppLogo />
                            </Link>
                        </SidebarMenuButton>
                    </SidebarMenuItem>
                </SidebarMenu>
            </SidebarHeader>

            <SidebarContent>
                <NavMain items={mainNavItems} />
            </SidebarContent>

            <SidebarFooter>
                <NavFooter items={footerNavItems} className="mt-auto" />
                <NavUser />
            </SidebarFooter>
        </Sidebar>
    );
}
