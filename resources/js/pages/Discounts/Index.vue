<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Trash2, Pencil } from '@lucide/vue';
import { ref } from 'vue';
import { edit, create } from '@/routes/discount';
import { discounts as csv } from '@/routes/csv'
import type { Discount, UserType } from '@/types/';
import Toast from '@/components/Toast.vue';
import PageHeader from '@/components/PageHeader.vue';
import DataTable from '@/components/DataTable.vue';
import IndexButton from '@/components/IndexButton.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Discounts', href: '/discounts' },
        ],
    },
});

const props = defineProps<{
    discounts: Record<string, Discount[]>,
    flash?: { success?: string },
    user_types: UserType[],
}>();

const userTypeLabel = (id: number) => props.user_types.find(t => t.id === id)?.name ?? '—';

const toast = ref(props.flash?.success ?? '');
if (toast.value) setTimeout(() => toast.value = '', 3000);

const deleteDiscount = (id: number) => {
    if (!confirm('Are you sure you want to delete this discount?')) return;
    router.visit(`/discounts/${id}`, {
        method: 'delete',
        onSuccess: () => {
            toast.value = 'Discount deleted!';
            setTimeout(() => toast.value = '', 3000);
        },
    });
};
</script>

<template>

    <Head title="Discounts" />

    <Toast :message="flash?.success" />

    <div class="p-6 space-y-10">
        <PageHeader title="Discounts">
            <Button as="a" :href="create().url">Add Discount</Button>
            <Button as="a" :href="csv().url">Import from csv</Button>
        </PageHeader>


        <div v-for="(group, brandName) in discounts" :key="brandName" class="space-y-3">
            <h2 class="text-xl font-bold">{{ brandName }}</h2>

            <DataTable>
                <template #head>
                    <tr>
                        <th class="px-4 py-2 text-left font-medium">Title</th>
                        <th class="px-4 py-2 text-left font-medium">Description</th>
                        <th class="px-4 py-2 text-left font-medium">User Type</th>
                        <th class="px-4 py-2 text-left font-medium">Expires</th>
                        <th class="px-4 py-2 text-left font-medium"></th>
                    </tr>
                </template>
                <template #body>
                    <tr v-for="discount in group" :key="discount.id"
                        class="border-t border-border hover:bg-accent/50 transition-colors">
                        <td class="px-4 py-2 font-medium">{{ discount.title }}</td>
                        <td class="px-4 py-2 text-muted-foreground">{{ discount.description ?? '—' }}</td>
                        <td class="px-4 py-2">{{ userTypeLabel(discount.user_type) }}</td>
                        <td class="px-4 py-2">
                            {{ discount.expiration_date
                                ? new Date(discount.expiration_date).toLocaleDateString('en-GB')
                                : '—' }}
                        </td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <IndexButton type="edit" :href="edit(discount).url" />
                            <IndexButton type="delete" :onClick="() => deleteDiscount(discount.id)" />
                        </td>
                    </tr>
                </template>
            </DataTable>
        </div>
    </div>
</template>