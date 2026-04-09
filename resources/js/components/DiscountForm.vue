<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import type { Discount, UserType,Brand } from '@/types';

const props = defineProps<{
    formProps: Record<string, any>;
    buttonText: string;
    brands: Brand[];
    user_types: UserType[];
    discount?: Discount;
}>();

const selectedBrand    = ref(props.discount?.brand_id ?? '');
const selectedUserType = ref(props.discount?.user_type ?? '');
</script>

<template>
    <Form v-bind="formProps" v-slot="{ errors, processing }" class="p-6 w-2xl mx-auto space-y-6">
        <div class="grid gap-4">

            <div class="grid gap-2">
                <Label for="brand_id">Brand</Label>
                <select id="brand_id" name="brand_id" v-model="selectedBrand"
                    class="input bg-background text-foreground" required>
                    <option value="" disabled>Select a brand</option>
                    <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                        {{ brand.name }}
                    </option>
                </select>
                <InputError :message="errors.brand_id" />
            </div>

            <div class="grid gap-2">
                <Label for="title">Title</Label>
                <Input id="title" name="title" :default-value="discount?.title" placeholder="Title" required />
                <InputError :message="errors.title" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <Input id="description" name="description" :default-value="discount?.description ?? ''" placeholder="Description" />
                <InputError :message="errors.description" />
            </div>

            <div class="grid gap-2">
                <Label for="user_type">User Type</Label>
                <select id="user_type" name="user_type" v-model="selectedUserType"
                    class="input bg-background text-foreground" required>
                    <option value="" disabled>Select a user type</option>
                    <option v-for="type in user_types" :key="type.id" :value="type.id">
                        {{ type.name }}
                    </option>
                </select>
                <InputError :message="errors.user_type" />
            </div>

            <div class="grid gap-2">
                <Label for="expiration_date">Expiration Date</Label>
                <Input id="expiration_date" name="expiration_date" type="date"
                    :default-value="discount?.expiration_date ?? ''" />
                <InputError :message="errors.expiration_date" />
            </div>

            <Button type="submit" class="mt-2 w-full" :disabled="processing">
                <Spinner v-if="processing" />
                {{ buttonText }}
            </Button>
        </div>
    </Form>
</template>