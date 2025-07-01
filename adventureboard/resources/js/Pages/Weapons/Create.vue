<script>
export default {
    name: 'WeaponsCreate'
}
</script>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import WeaponForm from '@/Components/Weapons/Form.vue'
import Form from '@/Components/Weapons/Form.vue';

const form = useForm({
    name: '',
    description: '',
    image_uri: 'storage/app/public/Weapons_images/default.jpg', 
    damage: 0,
    defense: 0,
    price: 0,
})
</script>

<template>
    <AppLayout title="Create Weapon">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                New Weapon
            </h1>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border border-gray-200 rounded-lg w-500">
                        <WeaponForm :form="form" @submit="form.post(route('weapons.store'))" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

</template>