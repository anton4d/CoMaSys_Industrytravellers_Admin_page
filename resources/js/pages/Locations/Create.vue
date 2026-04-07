<script setup lang="ts">
import { Head, Form } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/locations';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'Create Location', href: '/locations/create' },
        ],
    },
});

const types = [
    { id: 1, name: 'Restaurant' },
    { id: 2, name: 'Cafe' },
    { id: 3, name: 'Shop' },
    { id: 4, name: 'Hotel' },
];
const selectedType = ref('');
const expirationDate = ref('');
</script>

<template>

    <Head title="Create Location" />
    <Form v-bind="store.form()" v-slot="{ errors, processing }" class="p-6 max-w-2xl space-y-6">
        <h1 class="text-2xl font-bold">Create Location</h1>
        <div class="grid gap-4">

            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input id="name" name="name" placeholder="Name" required />
                <InputError :message="errors.name" />
            </div>

            <div class="grid gap-2">
                <Label for="latitude">Latitude</Label>
                <Input id="latitude" name="latitude" placeholder="latitude" required />
                <InputError :message="errors.latitude" />
            </div>

            <div class="grid gap-2">
                <Label for="longitude">Longitude</Label>
                <Input id="longitude" name="longitude" placeholder="longitude" required />
                <InputError :message="errors.longitude" />
            </div>

            <div class="grid gap-2">
                <Label for="expiration_date">Expiration Date</Label>
                <input id="expiration_date" name="expiration_date" type="date" v-model="expirationDate"
                    class="input bg-background text-foreground" required />
                <InputError :message="errors.expiration_date" />
            </div>

            <div class="grid gap-2">
                <Label for="type">Type</Label>
                <select id="type" name="type" v-model="selectedType" class="input bg-background text-foreground"
                    required>
                    <option value="" disabled>Select a type</option>
                    <option v-for="type in types" :key="type.id" :value="type.id">
                        {{ type.name }}
                    </option>
                </select>
                <InputError :message="errors.type" />
            </div>

            <div class="grid gap-2">
                <Label for="address">Address</Label>
                <Input id="address" name="address" placeholder="Full address e.g. Ølsgårdsvej 1, 4180 Sorø" required />
                <InputError :message="errors.address" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <Input id="description" name="description" placeholder="Description" />
                <InputError :message="errors.description" />
            </div>

            <div class="grid gap-2">
                <Label for="link">Link</Label>
                <Input id="link" name="link" placeholder="Link" />
                <InputError :message="errors.link" />
            </div>

            <div class="grid gap-2">
                <Label for="photo_path">Photo Path</Label>
                <Input id="photo_path" name="photo_path" placeholder="Photo Path" />
                <InputError :message="errors.photo_path" />
            </div>

            <div class="grid gap-2">
                <Label for="discount_info">Discount Info</Label>
                <Input id="discount_info" name="discount_info" placeholder="Discount Info" />
                <InputError :message="errors.discount_info" />
            </div>

            <Button type="submit" class="mt-2 w-full" :disabled="processing">
                <Spinner v-if="processing" />
                Create Location
            </Button>
        </div>
    </Form>
</template>