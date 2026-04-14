<script setup lang="ts">
import { ref, watch } from 'vue';
import { Form } from '@inertiajs/vue3';
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
    flash?: { success?: string; city_not_found?: string };
}>();

const selectedType = ref(props.location?.type ?? '');
const selectedBrand = ref(props.location?.brand_id ?? '');
const cityName = ref(props.location?.info?.city?.name ?? '');
const showCityModal = ref(false);
const cityLat = ref('');
const cityLng = ref('');
const pendingCityName = ref('');
const confirmedCityLat = ref('');
const confirmedCityLng = ref('');
const cityChecked = ref(false);

async function onCityBlur() {
    const name = cityName.value.trim();
    if (!name) return;

    if (props.location?.info?.city?.name === name) {
        cityChecked.value = true;
        return;
    }

    const res = await fetch(`/cities/check?name=${encodeURIComponent(name)}`);
    const data = await res.json();

    if (data.exists) {
        cityChecked.value = true;
        confirmedCityLat.value = data.latitude;
        confirmedCityLng.value = data.longitude;
    } else {
        pendingCityName.value = name;
        cityLat.value = '';
        cityLng.value = '';
        cityChecked.value = false;
        showCityModal.value = true;
    }
}

watch(cityName, () => {
    cityChecked.value = false;
    confirmedCityLat.value = '';
    confirmedCityLng.value = '';
});

function confirmCity() {
    confirmedCityLat.value = cityLat.value;
    confirmedCityLng.value = cityLng.value;
    cityChecked.value = true;
    showCityModal.value = false;
}
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
                <Label for="latitude">Latitude</Label>
                <Input id="latitude" name="latitude" :default-value="location?.latitude" placeholder="Latitude"
                    required />
                <InputError :message="errors.latitude" />
            </div>

            <div class="grid gap-2">
                <Label for="longitude">Longitude</Label>
                <Input id="longitude" name="longitude" :default-value="location?.longitude" placeholder="Longitude"
                    required />
                <InputError :message="errors.longitude" />
            </div>

            <input type="hidden" name="city_latitude" :value="confirmedCityLat" />
            <input type="hidden" name="city_longitude" :value="confirmedCityLng" />

            <div class="grid gap-2">
                <Label for="city_name">City</Label>
                <Input id="city_name" name="city_name" v-model="cityName" placeholder="City name" required
                    @blur="onCityBlur" />
                <InputError :message="errors.city_name" />
            </div>


            <div class="grid gap-2">
                <Label for="address">Address</Label>
                <Input id="address" name="address" :default-value="location?.info?.address ?? ''"
                    placeholder="Full address" required />
                <InputError :message="errors.address" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <Input id="description" name="description" :default-value="location?.info?.description ?? ''"
                    placeholder="Description" />
                <InputError :message="errors.description" />
            </div>

            <div class="grid gap-2">
                <Label for="link">Link</Label>
                <Input id="link" name="link" :default-value="location?.info?.link ?? ''" placeholder="Link" />
                <InputError :message="errors.link" />
            </div>

            <div class="grid gap-2">
                <Label for="photo_path">Photo Path</Label>
                <Input id="photo_path" name="photo_path" :default-value="location?.info?.photo_path ?? ''"
                    placeholder="Photo Path" />
                <InputError :message="errors.photo_path" />
            </div>

            <Button type="submit" class="mt-2 w-full" :disabled="processing">
                <Spinner v-if="processing" />
                {{ buttonText }}
            </Button>
        </div>
    </Form>


    <div v-if="showCityModal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-background rounded-lg p-6 w-96 space-y-4 shadow-xl">
            <h2 class="text-lg font-semibold">New City: {{ pendingCityName }}</h2>
            <p class="text-sm text-muted-foreground">
                This city doesn't exist yet. Enter the coordinates for the city center.
            </p>

            <div class="grid gap-2">
                <Label for="modal_lat">Latitude</Label>
                <Input id="modal_lat" v-model="cityLat" placeholder="e.g. 55.4038"/>
            </div>

            <div class="grid gap-2">
                <Label for="modal_lng">Longitude</Label>
                <Input id="modal_lng" v-model="cityLng" placeholder="e.g. 10.3951"/>
            </div>

            <div class="flex gap-2 justify-end">
                <Button variant="outline" @click="showCityModal = false">Cancel</Button>
                <Button @click="confirmCity" :disabled="!cityLat || !cityLng">Confirm</Button>
            </div>
        </div>
    </div>
</template>