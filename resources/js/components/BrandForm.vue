<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import type { Brand } from '@/types/models';

defineProps<{
    formProps: Record<string, any>;
    buttonText: string;
    brand?: Brand;
}>();
</script>

<template>
    <Form v-bind="formProps" v-slot="{ errors, processing }" class="p-6 w-2xl mx-auto space-y-6">
        <div class="grid gap-4">

            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input id="name" name="name" :default-value="brand?.name" placeholder="Brand name" required />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="logo_url">Logo URL</Label>
                <Input id="logo_url" name="logo_url" :default-value="brand?.logo_url ?? ''" placeholder="https://..." />
                <InputError :message="errors.logo_url" />
            </div>

            <div class="grid gap-2">
                <Label for="website">Website</Label>
                <Input id="website" name="website" :default-value="brand?.website ?? ''" placeholder="https://..." />
                <InputError :message="errors.website" />
            </div>

            <Button type="submit" class="mt-2 w-full" :disabled="processing">
                <Spinner v-if="processing" />
                {{ buttonText }}
            </Button>
        </div>
    </Form>
</template>