<script setup lang="ts">
import { Head} from '@inertiajs/vue3';
import { store } from '@/routes/discount';
import DiscountForm from '@/components/DiscountForm.vue';
import { Brand,UserType } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Dashboard', href: '/dashboard' },
            {title: 'Locations', href: '/locations'},
            { title: 'Create Location', href: '/locations/create' },
        ],
    },
});
const props = defineProps<{
    user_types: UserType[];
    brands: Brand[];
}>();


</script>

<template>
    <Head title="Create Location" />
    <DiscountForm :form-props="store.form()" button-text="Create Discount" :user_types="user_types" :brands="brands" />
</template>