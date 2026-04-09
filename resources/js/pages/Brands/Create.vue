<script setup lang="ts">
import { Head} from '@inertiajs/vue3';
import { store } from '@/routes/brand';
import BrandForm from '@/components/BrandForm.vue';
import { ref } from 'vue';
import Toast from '@/components/Toast.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            {title: 'Brands', href: '/brands'},
            { title: 'Create Brand', href: '/brands/create' },
        ],
    },
});
const props = defineProps<{
    flash?: { success?: string },
}>();

// Toast state
const toast = ref(props.flash?.success ?? '');

if (toast.value) {
    setTimeout(() => toast.value = '', 3000);
}


</script>
<template>
    <Head title="Create Brand" />
    <Toast :message="flash?.success" />
    <BrandForm :form-props="store.form()" button-text="Create Brand"" />
</template>