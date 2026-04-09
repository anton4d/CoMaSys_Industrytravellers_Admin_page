<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Globe, LayoutGrid,MapPin,Pencil, ShoppingBasket, Store, Toolbox } from '@lucide/vue';
import AppLogo from '@/components/AppLogo.vue';
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard} from '@/routes';
import {index as locationIndex} from '@/routes/locations'
import { index as adminIndex } from '@/routes/admin';
import {index as discountIndex } from '@/routes/discount';
import { index as brandIndex } from '@/routes/brand';
import {index as csvIndex} from '@/routes/csv'
import type { NavItem } from '@/types';

const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
    },
    {
        title: 'Admins',
        href:adminIndex(),
        icon: Pencil,
    },
    {
        title: 'Brands',
        href: brandIndex(),
        icon: Store,
    },
    {
        title: 'Locations',
        href:locationIndex(),
        icon: MapPin,
    },
    {
        title: 'Discounts',
        href: discountIndex(),
        icon: ShoppingBasket,
    },
    
    
];

const footerNavItems: NavItem[] = [
    {
        title: 'Csv Import to database',
        href: csvIndex(),
        icon: Toolbox,
    },
    {
        title: 'Main Page',
        href: 'https://industrytravellers.com/',
        icon: Globe,
    },
    {
        title: 'Members Page',
        href: 'https://member.industrytravellers.com/',
        icon: Globe,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
