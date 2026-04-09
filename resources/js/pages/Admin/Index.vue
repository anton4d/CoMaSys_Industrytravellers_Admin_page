<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Trash2, Pencil } from '@lucide/vue';
import { ref } from 'vue';
import { edit,register } from '@/routes/admin';
import { User } from '@/types';

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

const deleteLocation = (id: number) => {
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

    <Head title="admins" />
    <div v-if="toast"
        class="fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-300">
        {{ toast }}
    </div>
    <div class="p-6 space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold">admins</h1>
            <Button as="a" :href='register().url'>Add Admin</Button>
        </div>

        

            <div class="rounded-md border border-border overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-muted text-muted-foreground">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium">Name</th>
                            <th class="px-4 py-2 text-left font-medium">Email</th>
                            <th class="px-4 py-2 text-left font-medium">Created at</th>
                            <th class="px-4 py-2 text-left font-medium"></th>
                        </tr>
                    </thead>
                    <tbody>
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
                                <Button variant="outline" size="sm" as="a" :href="edit(admin.id).url">
                                    <Pencil class="w-4 h-4" />
                                </Button>
                                <Button variant="destructive" size="sm" @click="deleteLocation(admin.id)">
                                    <Trash2 class="w-4 h-4" />
                                </Button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    
</template>