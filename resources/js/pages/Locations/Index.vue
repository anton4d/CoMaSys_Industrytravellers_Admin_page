<script setup lang="ts">
import { Head, router, usePage } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Trash2, Pencil } from '@lucide/vue';
import { computed } from 'vue';
import { edit, create, sync } from '@/routes/locations';
import { locations as csv } from '@/routes/csv'
import type { Location } from '@/types/models';
import Toast from '@/components/Toast.vue';
import PageHeader from '@/components/PageHeader.vue';
import DataTable from '@/components/DataTable.vue';
import IndexButton from '@/components/IndexButton.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Locations', href: '/locations' },
        ],
    },
});

const props = defineProps<{
    locations: Record<string, Location[]>,
    types: { id: number; name: string }[],
}>();

const page = usePage<{
    flash?: { success?: string; error?: string };
}>();

const toastMessage = computed(() => page.props.flash?.success || page.props.flash?.error || '');
const toastType = computed(() => page.props.flash?.error ? 'error' : 'success');

const typeLabel = (id: number) => props.types.find(t => t.id === id)?.name ?? '—';

const deleteLocation = (id: number) => {
    if (!confirm('Are you sure you want to delete this location?')) return;
    router.visit(`/locations/${id}`, {
        method: 'delete',
    });
};
</script>

<template>

    <Head title="Locations" />

    <Toast :message="toastMessage" :type="toastType" />

    <div class="p-6 space-y-10">
        <PageHeader title="Locations">
            <Button @click="router.post('/locations/sync')">
                Sync Locations
            </Button>
            <Button as="a" :href="create().url">Add Location</Button>
            <Button as="a" :href="csv().url">Import from csv</Button>
        </PageHeader>

        <div v-for="(group, brandName) in locations" :key="brandName" class="space-y-3">
            <h2 class="text-xl font-bold">{{ brandName }}</h2>

            <DataTable>
                <template #head>
                    <tr>
                        <th class="px-4 py-2 text-left font-medium">Name</th>
                        <th class="px-4 py-2 text-left font-medium">Address</th>
                        <th class="px-4 py-2 text-left font-medium">Type</th>
                        <th class="px-4 py-2 text-left font-medium"></th>
                    </tr>
                </template>
                <template #body>
                    <tr v-for="location in group" :key="location.id"
                        class="border-t border-border hover:bg-accent/50 transition-colors">
                        <td class="px-4 py-2 font-medium">{{ location.name }}</td>
                        <td class="px-4 py-2 text-muted-foreground">{{ location.info?.address ?? '—' }}</td>
                        <td class="px-4 py-2">{{ typeLabel(location.type) }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <Button variant="outline" size="sm" as="a" :href="edit(location).url">
                                <Pencil class="w-4 h-4" />
                            </Button>
                            <Button variant="destructive" size="sm" @click="deleteLocation(location.id)">
                                <Trash2 class="w-4 h-4" />
                            </Button>
                        </td>
                    </tr>
                </template>
            </DataTable>
        </div>
    </div>
</template>