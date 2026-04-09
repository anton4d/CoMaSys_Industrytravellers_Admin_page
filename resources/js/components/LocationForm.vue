<script setup lang="ts">
import { Form } from '@inertiajs/vue3';
import { ref } from 'vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import type { Brand, Location, LocationType } from '@/types';

const props = defineProps<{
    formProps: Record<string, any>;
    buttonText: string;
    types: LocationType[];
    brands: Brand[];
    location?: Location;
}>();

const selectedType  = ref(props.location?.type ?? '');
const selectedBrand = ref(props.location?.brand_id ?? '');
</script>

<template>
    <Form v-bind="formProps" v-slot="{ errors, processing }" class="p-6 w-2xl mx-auto space-y-6">
        <div class="grid gap-4">

            <div class="grid gap-2">
                <Label for="name">Name</Label>
                <Input id="name" name="name" :default-value="location?.name" placeholder="Name" required />
                <InputError :message="errors.name" />
            </div>

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
                <Label for="type">Type</Label>
                <select id="type" name="type" v-model="selectedType"
                    class="input bg-background text-foreground" required>
                    <option value="" disabled>Select a type</option>
                    <option v-for="type in types" :key="type.id" :value="type.id">
                        {{ type.name }}
                    </option>
                </select>
                <InputError :message="errors.type" />
            </div>

            <div class="grid gap-2">
                <Label for="latitude">Latitude</Label>
                <Input id="latitude" name="latitude" :default-value="location?.latitude" placeholder="Latitude" required />
                <InputError :message="errors.latitude" />
            </div>

            <div class="grid gap-2">
                <Label for="longitude">Longitude</Label>
                <Input id="longitude" name="longitude" :default-value="location?.longitude" placeholder="Longitude" required />
                <InputError :message="errors.longitude" />
            </div>

            <div class="grid gap-2">
                <Label for="address">Address</Label>
                <Input id="address" name="address" :default-value="location?.info?.address ?? ''" placeholder="Full address" required />
                <InputError :message="errors.address" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <Input id="description" name="description" :default-value="location?.info?.description ?? ''" placeholder="Description" />
                <InputError :message="errors.description" />
            </div>

            <div class="grid gap-2">
                <Label for="link">Link</Label>
                <Input id="link" name="link" :default-value="location?.info?.link ?? ''" placeholder="Link" />
                <InputError :message="errors.link" />
            </div>

            <div class="grid gap-2">
                <Label for="photo_path">Photo Path</Label>
                <Input id="photo_path" name="photo_path" :default-value="location?.info?.photo_path ?? ''" placeholder="Photo Path" />
                <InputError :message="errors.photo_path" />
            </div>

            <Button type="submit" class="mt-2 w-full" :disabled="processing">
                <Spinner v-if="processing" />
                {{ buttonText }}
            </Button>
        </div>
    </Form>
</template>