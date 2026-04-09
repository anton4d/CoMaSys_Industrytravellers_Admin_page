<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            { title: 'CSV Import', href: '/csv-import' },
        ],
    },
});

const props = defineProps<{
    flash?: { success?: string },
    model?: string,
}>();

const models = [
    { id: 'brands',    name: 'Brands',    hint: 'name, logo_url, website' },
    { id: 'locations', name: 'Locations', hint: 'brand, name, type, latitude, longitude, address, description, link, photo_path, discount_info' },
    { id: 'discounts', name: 'Discounts', hint: 'brand, title, description, expiration_date, user_type' },
];

const form = useForm({
    file:  null as File | null,
    model: props.model ?? '',
});

const fileName     = ref('');
const selectedModel = ref(models.find(m => m.id === props.model) ?? models[0]);

const onFileChange = (e: Event) => {
    const file     = (e.target as HTMLInputElement).files?.[0] ?? null;
    form.file      = file;
    fileName.value = file?.name ?? '';
};

const onModelChange = () => {
    selectedModel.value = models.find(m => m.id === form.model) ?? models[0];
};

const submit = () => {
    form.post('/csv-import', {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="CSV Import" />

    <div class="p-6 max-w-xl space-y-8">
        <h1 class="text-2xl font-bold">CSV Import</h1>

        <div v-if="flash?.success" class="bg-green-500 text-white px-4 py-2 rounded shadow">
            {{ flash.success }}
        </div>

        <form @submit.prevent="submit" class="space-y-6">

            <div class="grid gap-2">
                <Label for="model">Import Into</Label>
                <select id="model" v-model="form.model" @change="onModelChange"
                    class="input bg-background text-foreground" required>
                    <option value="" disabled>Select a model</option>
                    <option v-for="m in models" :key="m.id" :value="m.id">
                        {{ m.name }}
                    </option>
                </select>
                <InputError :message="form.errors.model" />
            </div>

            <div v-if="form.model" class="rounded-md bg-muted px-4 py-3 text-sm space-y-1">
                <p class="font-medium text-muted-foreground">Expected CSV columns:</p>
                <p class="font-mono text-xs">{{ selectedModel.hint }}</p>
                <p class="text-muted-foreground text-xs">Column order does not matter, names must match.</p>
            </div>

            <div class="grid gap-2">
                <Label for="file">CSV File</Label>
                <div class="border border-dashed border-border rounded-md px-4 py-6 text-center cursor-pointer hover:bg-accent/50 transition-colors"
                    @click="($refs.fileInput as HTMLInputElement).click()">
                    <p class="text-sm text-muted-foreground">
                        {{ fileName || 'Click to select a CSV file' }}
                    </p>
                </div>
                <input ref="fileInput" id="file" type="file" accept=".csv,.txt"
                    class="hidden" @change="onFileChange" />
                <InputError :message="form.errors.file" />
            </div>

            <Button type="submit" class="w-full" :disabled="form.processing || !form.file || !form.model">
                <span v-if="form.processing">Importing...</span>
                <span v-else>Import CSV</span>
            </Button>

        </form>
    </div>
</template>