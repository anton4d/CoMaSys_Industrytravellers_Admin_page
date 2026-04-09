<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { update } from '@/routes/admin';
import type { User } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Admins', href: '/admins' },
            { title: 'Edit Admin User', href: '#' },
        ],
    },
});

const props = defineProps<{
    admin: User,
    permissions: { id: string; label: string }[],
}>();

</script>

<template>
    <Head title="Edit Admin User" />

    <Form
        v-bind="update.form(admin.id)"
        v-slot="{ errors, processing }"
        class="p-6 max-w-2xl mx-auto space-y-6"
    >
        <h1 class="text-2xl font-bold">Edit Admin User</h1>
        <p class="text-muted-foreground text-sm">Update administrator account and permissions.</p>

        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input id="name" type="text" required autofocus autocomplete="name" name="name"
                    :default-value="admin.name" placeholder="Full name" />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="email">Email address</Label>
                <Input id="email" type="email" required autocomplete="email" name="email"
                    :default-value="admin.email" placeholder="email@example.com" />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="password">New Password <span class="text-muted-foreground text-xs">(leave blank to keep current)</span></Label>
                <PasswordInput id="password" autocomplete="new-password" name="password" placeholder="Password" />
                <InputError :message="errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation">Confirm new password</Label>
                <PasswordInput id="password_confirmation" autocomplete="new-password" name="password_confirmation" placeholder="Confirm password" />
                <InputError :message="errors.password_confirmation" />
            </div>

            <!-- Permissions -->
            <div class="grid gap-3">
                <Label>Permissions</Label>
                <div class="rounded-md border border-border p-4 grid gap-3">
                    <div v-for="permission in permissions" :key="permission.id" class="flex items-center gap-3">
                        <input
                            :id="permission.id"
                            :name="permission.id"
                            type="checkbox"
                            class="h-4 w-4 rounded border-border"
                            value="1"
                            :checked="(admin as any)[permission.id]"
                        />
                        <Label :for="permission.id" class="font-normal cursor-pointer">
                            {{ permission.label }}
                        </Label>
                    </div>
                </div>
            </div>

            <Button type="submit" class="mt-2 w-full" :disabled="processing">
                <Spinner v-if="processing" />
                Save Changes
            </Button>
        </div>
    </Form>
</template>