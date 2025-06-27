<script>
export default {
    name: 'HeroesCreate'
}
</script>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import HeroForm from '@/Components/Heroes/Form.vue';

defineProps({
    factions:{
        type: Array,
        required: true,
    },
    classroles:{
        type: Array,
        required: true,
    },
    races:{
        type: Array,
        required: true,
    }
});

const form = useForm({
    name: '',
    background: '',
    image_uri: '',
    hp: 100,
    strength: 20,
    defense: 20,
    ki: 20,
    classrole_id: 1,
    race_id: 1,
    faction_id: null, 
})
</script>

<template>
    <AppLayout title="Create Hero">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                New Hero
            </h1>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border border-gray-200 rounded-lg w-500">
                        <HeroForm :form="form" :factions="factions" :classroles="classroles" :races="races" @submit="form.post(route('heroes.store'))" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

</template>