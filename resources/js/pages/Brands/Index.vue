<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Trash2, Pencil, Eye } from '@lucide/vue';
import { ref } from 'vue';
import { edit, create, show } from '@/routes/brand';
import type { BrandIndex } from '@/types/models';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Brands', href: '/brands' },
        ],
    },
});

const props = defineProps<{
    brands: BrandIndex[],
    flash?: { success?: string },
}>();

const toast = ref(props.flash?.success ?? '');
if (toast.value) setTimeout(() => toast.value = '', 3000);

const deleteBrand = (id: number) => {
    if (!confirm('Are you sure? This will also delete all locations and discounts under this brand.')) return;
    router.visit(`/brands/${id}`, {
        method: 'delete',
        onSuccess: () => {
            toast.value = 'Brand deleted!';
            setTimeout(() => toast.value = '', 3000);
        },
    });
};
</script>

<template>

    <Head title="Brands" />

    <div v-if="toast"
        class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-300">
        {{ toast }}
    </div>

    <div class="p-6 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Brands</h1>
            <Button as="a" :href="create().url">Add Brand</Button>
        </div>

        <div class="rounded-md border border-border overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-muted text-muted-foreground">
                    <tr>
                        <th class="px-4 py-2 text-left font-medium">Name</th>
                        <th class="px-4 py-2 text-left font-medium">Website</th>
                        <th class="px-4 py-2 text-left font-medium">Locations</th>
                        <th class="px-4 py-2 text-left font-medium">Discounts</th>
                        <th class="px-4 py-2 text-left font-medium"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="brand in brands" :key="brand.id"
                        class="border-t border-border hover:bg-accent/50 transition-colors">
                        <td class="px-4 py-2 font-medium">
                            <div class="flex items-center gap-2">
                                <img v-if="brand.logo_url" :src="brand.logo_url" :alt="brand.name"
                                    class="w-6 h-6 rounded object-cover" />
                                <div v-else
                                    class="w-6 h-6 rounded bg-muted flex items-center justify-center text-xs font-bold text-muted-foreground">
                                    {{ brand.name.charAt(0) }}
                                </div>
                                {{ brand.name }}
                            </div>
                        </td>
                        <td class="px-4 py-2 text-muted-foreground">
                            <a v-if="brand.website" :href="brand.website" target="_blank"
                                class="underline hover:text-foreground">
                                {{ brand.website }}
                            </a>
                            <span v-else>—</span>
                        </td>
                        <td class="px-4 py-2">{{ brand.locations_count ?? '—' }}</td>
                        <td class="px-4 py-2">{{ brand.discounts_count ?? '—' }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <Button variant="outline" size="sm" as="a" :href="show(brand).url">
                                <Eye class="w-4 h-4" />
                            </Button>
                            <Button variant="outline" size="sm" as="a" :href="edit(brand).url">
                                <Pencil class="w-4 h-4" />
                            </Button>
                            <Button variant="destructive" size="sm" @click="deleteBrand(brand.id)">
                                <Trash2 class="w-4 h-4" />
                            </Button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>