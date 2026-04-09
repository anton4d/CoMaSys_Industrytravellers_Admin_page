<script setup lang="ts">
import { Head} from '@inertiajs/vue3';
import { update } from '@/routes/discount';
import DiscountForm from '@/components/DiscountForm.vue';
import { Brand,Discount,UserType } from '@/types';

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
    discount:Discount;
}>();


</script>

<template>
    <Head title="Create Location" />
    <DiscountForm :form-props="update.form(discount.id)" button-text="Update Discount" :user_types="user_types" :brands="brands" :discount="discount"/>
</template>