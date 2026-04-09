<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Trash2, Pencil, Eye } from '@lucide/vue';
import { ref } from 'vue';
import { edit, create, show } from '@/routes/brand';
import { brands as csvBrands } from '@/routes/csv'
import type { BrandIndex } from '@/types/models';
import Toast from '@/components/Toast.vue';
import PageHeader from '@/components/PageHeader.vue';
import DataTable from '@/components/DataTable.vue';
import IndexButton from '@/components/IndexButton.vue';

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
    <Toast :message="flash?.success" />

    <div class="p-6 space-y-6">
        <PageHeader title="Brands">
            <Button as="a" :href="create().url">Add Brand</Button>
            <Button as="a" :href="csvBrands().url">Import from CSV</Button>
        </PageHeader>

        <DataTable>
            <template #head>
                <tr>
                    <th class="px-4 py-2 text-left font-medium">Name</th>
                    <th class="px-4 py-2 text-left font-medium">Website</th>
                    <th class="px-4 py-2 text-left font-medium">Locations</th>
                    <th class="px-4 py-2 text-left font-medium">Discounts</th>
                    <th class="px-4 py-2 text-left font-medium"></th>
                </tr>
            </template>
            <template #body>
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
                        <IndexButton type="show" :href="show(brand).url" />
                        <IndexButton type="edit" :href="edit(brand).url" />
                        <IndexButton type="delete" :onClick="() => deleteBrand(brand.id)" />
                    </td>
                </tr>
            </template>
        </DataTable>
    </div>
</template>
