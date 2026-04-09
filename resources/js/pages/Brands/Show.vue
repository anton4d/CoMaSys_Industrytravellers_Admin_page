<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type { Location } from '@/types/models';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Brands', href: '/brands' },
            { title: 'Brand Details', href: '#' },
        ],
    },
});

type Discount = {
    id: number;
    brand_id: number;
    title: string;
    description: string | null;
    expiration_date: string | null;
    user_type: number;
    created_at: string;
    updated_at: string;
};

type Brand = {
    id: number;
    name: string;
    logo_url: string | null;
    website: string | null;
    discounts: Discount[];
    created_at: string;
    updated_at: string;
};

const props = defineProps<{
    brand: Brand;
    locations: Location[];
}>();
</script>

<template>
    <Head :title="brand.name" />

    <div class="p-6 space-y-8 max-w-5xl mx-auto">

        <!-- Brand Header -->
        <div class="flex items-center gap-6">
            <img v-if="brand.logo_url" :src="brand.logo_url" :alt="brand.name"
                class="w-20 h-20 rounded-lg object-contain border border-border" />
            <div v-else
                class="w-20 h-20 rounded-lg border border-border bg-muted flex items-center justify-center text-2xl font-bold text-muted-foreground">
                {{ brand.name.charAt(0) }}
            </div>
            <div>
                <h1 class="text-3xl font-bold">{{ brand.name }}</h1>
                <a v-if="brand.website" :href="brand.website" target="_blank"
                    class="text-sm text-muted-foreground hover:underline">
                    {{ brand.website }}
                </a>
            </div>
        </div>

        <!-- Discounts -->
        <div class="space-y-3">
            <h2 class="text-xl font-semibold">Discounts</h2>
            <div v-if="brand.discounts.length === 0" class="text-muted-foreground text-sm">
                No discounts found.
            </div>
            <div v-else class="rounded-md border border-border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-muted text-muted-foreground">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium">Title</th>
                            <th class="px-4 py-2 text-left font-medium">Description</th>
                            <th class="px-4 py-2 text-left font-medium">User Type</th>
                            <th class="px-4 py-2 text-left font-medium">Expires</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="discount in brand.discounts" :key="discount.id"
                            class="border-t border-border hover:bg-accent/50 transition-colors">
                            <td class="px-4 py-2 font-medium">{{ discount.title }}</td>
                            <td class="px-4 py-2 text-muted-foreground">{{ discount.description ?? '—' }}</td>
                            <td class="px-4 py-2">{{ discount.user_type }}</td>
                            <td class="px-4 py-2">
                                {{ discount.expiration_date
                                    ? new Date(discount.expiration_date).toLocaleDateString('en-GB')
                                    : '—' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Locations -->
        <div class="space-y-3">
            <h2 class="text-xl font-semibold">Locations</h2>
            <div v-if="locations.length === 0" class="text-muted-foreground text-sm">
                No locations found.
            </div>
            <div v-else class="rounded-md border border-border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-muted text-muted-foreground">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium">Name</th>
                            <th class="px-4 py-2 text-left font-medium">Address</th>
                            <th class="px-4 py-2 text-left font-medium">Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="location in locations" :key="location.id"
                            class="border-t border-border hover:bg-accent/50 transition-colors">
                            <td class="px-4 py-2 font-medium">{{ location.name }}</td>
                            <td class="px-4 py-2 text-muted-foreground">{{ location.info?.address ?? '—' }}</td>
                            <td class="px-4 py-2">{{ location.type }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>