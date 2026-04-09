<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/admin';
import { ref } from 'vue';
import Toast from '@/components/Toast.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Admins', href: '/admins' },
            { title: 'Create Admin User', href: '/admins/register' },
        ],
    },
});
const props = defineProps<{
    permissions: { id: string; label: string }[],
    flash?: { success?: string },
}>();


// Toast state
const toast = ref(props.flash?.success ?? '');

if (toast.value) {
    setTimeout(() => toast.value = '', 3000);
}



</script>

<template>
    <Head title="Create Admin User" />
    <Toast :message="flash?.success" />

    <Form
        v-bind="store.form()"
        :reset-on-success="['password', 'password_confirmation']"
        v-slot="{ errors, processing }"
        class="p-6 max-w-2xl mx-auto space-y-6"
    >
        <h1 class="text-2xl font-bold">Create Admin User</h1>
        <p class="text-muted-foreground text-sm">Create a new administrator account for the backend.</p>

        <div class="grid gap-6">
            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input id="name" type="text" required autofocus autocomplete="name" name="name" placeholder="Full name" />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="email">Email address</Label>
                <Input id="email" type="email" required autocomplete="email" name="email" placeholder="email@example.com" />
                <InputError :message="errors.email" />
            </div>

            <div class="grid gap-2">
                <Label for="password">Password</Label>
                <PasswordInput id="password" required autocomplete="new-password" name="password" placeholder="Password" />
                <InputError :message="errors.password" />
            </div>

            <div class="grid gap-2">
                <Label for="password_confirmation">Confirm password</Label>
                <PasswordInput id="password_confirmation" required autocomplete="new-password" name="password_confirmation" placeholder="Confirm password" />
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
                        />
                        <Label :for="permission.id" class="font-normal cursor-pointer">
                            {{ permission.label }}
                        </Label>
                    </div>
                </div>
            </div>

            <Button type="submit" class="mt-2 w-full" :disabled="processing">
                <Spinner v-if="processing" />
                Create Admin User
            </Button>
        </div>
    </Form>
</template>