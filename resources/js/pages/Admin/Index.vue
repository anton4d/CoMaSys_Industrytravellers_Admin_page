<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';
import { edit, register } from '@/routes/admin';
import { User } from '@/types';
import Toast from '@/components/Toast.vue';
import PageHeader from '@/components/PageHeader.vue';
import DataTable from '@/components/DataTable.vue';
import IndexButton from '@/components/IndexButton.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'admins', href: '/admins' },
        ],
    },
});

const props = defineProps<{
    admins: User[],
    flash?: { success?: string },
}>();


const admins = props.admins || {};

// Toast state
const toast = ref(props.flash?.success ?? '');

if (toast.value) {
    setTimeout(() => toast.value = '', 3000);
}

const deleteAdmin = (id: number) => {
    if (!confirm('Are you sure you want to delete this admin?')) return;

    router.visit(`/admins/${id}`, {
        method: 'delete',
        onSuccess: () => {
            toast.value = 'Location deleted!';
            setTimeout(() => toast.value = '', 3000);
        },
    });
};
</script>


<template>

    <Head title="Admins" />
    <Toast :message="flash?.success" />

    <div class="p-6 space-y-8">
        <PageHeader title="Admins">
            <Button as="a" :href='register().url'>Add Admin</Button>
        </PageHeader>



        <DataTable>
            <template #head>
                <tr>
                    <th class="px-4 py-2 text-left font-medium">Name</th>
                    <th class="px-4 py-2 text-left font-medium">Email</th>
                    <th class="px-4 py-2 text-left font-medium">Created at</th>
                    <th class="px-4 py-2 text-left font-medium"></th>
                </tr>
            </template>
            <template #body>
                <tr v-for="admin in admins" :key="admin.id"
                    class="border-t border-border hover:bg-accent/50 transition-colors">
                    <td class="px-4 py-2 font-medium">{{ admin.name }}</td>
                    <td class="px-4 py-2 font-medium">{{ admin.email }}</td>
                    <td class="px-4 py-2">
                        {{ admin.created_at
                            ? new Date(admin.created_at).toLocaleDateString('en-GB')
                            : '—' }}
                    </td>
                    <td class="px-4 py-2 text-right space-x-2">
                        <IndexButton type="edit" :href="edit(admin.id).url" />
                        <IndexButton type="delete" :onClick="() => deleteAdmin(admin.id)" />
                    </td>
                </tr>
            </template>
        </DataTable>
    </div>
</template>