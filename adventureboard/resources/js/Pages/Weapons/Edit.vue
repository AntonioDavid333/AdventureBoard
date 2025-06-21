<script>
export default {
    name: 'WeaponEdit'
}
</script>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import WeaponForm from '@/Components/Weapons/Form.vue'
//import Form from '@/Components/Weapons/Form.vue';
//import { route } from 'vendor/tightenco/ziggy/src/js';
import { route } from 'ziggy-js';
import { defineProps } from 'vue';


const props = defineProps({
    weapon: {
        type: Object,
        required: true
    }

});

const form = useForm({
    //id: props.weapon.id,
    name: props.weapon.name,
    description: props.weapon.description,
    image_uri: props.weapon.image_uri,
    damage: props.weapon.damage,
    defense: props.weapon.defense,
    price: props.weapon.price
});
</script>

<template>
    <AppLayout title="Edit Weapon">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">Edit weapon</h1>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <WeaponForm :updating="true" :form="form" @submit="form.put(route('weapons.update', weapon.id))"/>
                    </div>
                    <pre>{{ props.weapon }}</pre>
                    <pre>{{ form }}</pre>
                </div>
            </div>
        </div>

    </AppLayout>
</template>