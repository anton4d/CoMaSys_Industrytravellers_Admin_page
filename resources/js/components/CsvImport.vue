<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';

const props = defineProps<{
    model: { id: string; name: string; hint: string };
    flash?: { success?: string };
}>();

const form = useForm({
    file:  null as File | null,
    model: props.model.id,
});

const fileName = ref('');

const onFileChange = (e: Event) => {
    const file     = (e.target as HTMLInputElement).files?.[0] ?? null;
    form.file      = file;
    fileName.value = file?.name ?? '';
};

const submit = () => {
    form.post('/csv-import', { forceFormData: true });
};
</script>

<template>
    <div class="p-6 max-w-xl space-y-8">
        <h1 class="text-2xl font-bold">Import {{ model.name }}</h1>

        <div v-if="flash?.success" class="bg-green-500 text-white px-4 py-2 rounded shadow">
            {{ flash.success }}
        </div>

        <div class="rounded-md bg-muted px-4 py-3 text-sm space-y-1">
            <p class="font-medium text-muted-foreground">Expected CSV columns:</p>
            <p class="font-mono text-xs">{{ model.hint }}</p>
            <p class="text-muted-foreground text-xs">Column order does not matter, names must match.</p>
        </div>

        <form @submit.prevent="submit" class="space-y-6">
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

            <Button type="submit" class="w-full" :disabled="form.processing || !form.file">
                <span v-if="form.processing">Importing...</span>
                <span v-else>Import {{ model.name }}</span>
            </Button>
        </form>
    </div>
</template>