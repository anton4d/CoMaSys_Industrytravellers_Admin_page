<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { dashboard } from '@/routes';
import type { Location, PlatformUser } from '@/types/models';

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Dashboard', href: dashboard() }],
    },
});

type Discount = {
    id: number;
    title: string;
    expiration_date: string;
    brand?: { name: string };
};

defineProps<{
    recentLocations: Location[];
    expiringDiscounts: Discount[];
    recentUsers: PlatformUser[];
    pendingVerifications: PlatformUser[];
}>();
</script>

<template>
    <Head title="Dashboard" />

    <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">

            <!-- Recent Locations -->
            <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4 space-y-2">
                <h2 class="font-semibold text-sm text-muted-foreground">Recent Locations</h2>
                <ul class="space-y-1">
                    <li v-for="location in recentLocations" :key="location.id" class="text-sm">
                        <span class="font-medium">{{ location.name }}</span>
                        <span class="text-muted-foreground ml-1">— {{ location.info?.address ?? '—' }}</span>
                    </li>
                </ul>
            </div>

            <!-- Expiring Discounts -->
            <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4 space-y-2">
                <h2 class="font-semibold text-sm text-muted-foreground">Expiring Soon</h2>
                <ul class="space-y-1">
                    <li v-for="discount in expiringDiscounts" :key="discount.id" class="text-sm">
                        <span class="font-medium">{{ discount.title }}</span>
                        <span class="text-muted-foreground ml-1">— {{ discount.brand?.name }}</span>
                        <span class="text-xs text-red-500 ml-1">
                            {{ new Date(discount.expiration_date).toLocaleDateString('en-GB') }}
                        </span>
                    </li>
                </ul>
            </div>

            <!-- Pending Verifications -->
            <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4 space-y-2">
                <h2 class="font-semibold text-sm text-muted-foreground">Pending Verifications</h2>
                <ul class="space-y-1">
                    <li v-for="user in pendingVerifications" :key="user.id" class="text-sm">
                        <span class="font-medium">{{ user.name }}</span>
                        <span class="text-muted-foreground ml-1">— {{ user.email }}</span>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Recent Users -->
        <div class="rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-4 space-y-2">
            <h2 class="font-semibold text-sm text-muted-foreground">Recent Users</h2>
            <ul class="divide-y divide-border">
                <li v-for="user in recentUsers" :key="user.id"
                    class="py-2 flex items-center justify-between text-sm">
                    <span class="font-medium">{{ user.name }}</span>
                    <span class="text-muted-foreground">{{ user.email }}</span>
                    <span :class="user.is_verified ? 'text-green-500' : 'text-yellow-500'" class="text-xs">
                        {{ user.is_verified ? 'Verified' : 'Pending' }}
                    </span>
                </li>
            </ul>
        </div>
    </div>
</template>