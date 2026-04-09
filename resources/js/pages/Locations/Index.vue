<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Trash2, Pencil } from '@lucide/vue';
import { ref } from 'vue';
import { edit, create } from '@/routes/locations';
import type { Location } from '@/types/models';

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
    flash?: { success?: string },
    types: { id: number; name: string }[],
}>();

const typeLabel = (id: number) => props.types.find(t => t.id === id)?.name ?? '—';

const toast = ref(props.flash?.success ?? '');
if (toast.value) setTimeout(() => toast.value = '', 3000);

const deleteLocation = (id: number) => {
    if (!confirm('Are you sure you want to delete this location?')) return;
    router.visit(`/locations/${id}`, {
        method: 'delete',
        onSuccess: () => {
            toast.value = 'Location deleted!';
            setTimeout(() => toast.value = '', 3000);
        },
    });
};
</script>

<template>
    <Head title="Locations" />

    <div v-if="toast"
        class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-300">
        {{ toast }}
    </div>

    <div class="p-6 space-y-10">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">Locations</h1>
            <Button as="a" :href="create().url">Add Location</Button>
        </div>

        <div v-for="(group, brandName) in locations" :key="brandName" class="space-y-3">
            <h2 class="text-xl font-bold">{{ brandName }}</h2>

            <div class="rounded-md border border-border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-muted text-muted-foreground">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium">Name</th>
                            <th class="px-4 py-2 text-left font-medium">Address</th>
                            <th class="px-4 py-2 text-left font-medium">Type</th>
                            <th class="px-4 py-2 text-left font-medium"></th>
                        </tr>
                    </thead>
                    <tbody>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>