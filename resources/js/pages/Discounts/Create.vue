<script setup lang="ts">
import { Head} from '@inertiajs/vue3';
import { store } from '@/routes/discount';
import DiscountForm from '@/components/DiscountForm.vue';
import { Brand,UserType } from '@/types';
import { ref } from 'vue';
import Toast from '@/components/Toast.vue';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            {title: 'Discounts', href: '/discounts'},
            { title: 'Create Discount', href: '/discounts/create' },
        ],
    },
});
const props = defineProps<{
    user_types: UserType[];
    brands: Brand[];
    flash?: { success?: string },
}>();

const toast = ref(props.flash?.success ?? '');

if (toast.value) {
    setTimeout(() => toast.value = '', 3000);
}

</script>

<template>
    <Head title="Create Discount" />
    <Toast :message="flash?.success" />
    <DiscountForm :form-props="store.form()" button-text="Create Discount" :user_types="user_types" :brands="brands" />
</template>