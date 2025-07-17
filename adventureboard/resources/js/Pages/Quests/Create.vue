<script>
export default {
    name: 'QuestCreate'
}
</script>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import QuestForm from '@/Components/Quests/Form.vue';

const form = useForm({
    title: '',
    description: '',
    strength_required: 20,
    defense_required: 20,
    ki_required: 20,
    reguard: 20,
    image_uri: null,
    difficulty: 'medium'
})

</script>
<template>
    <AppLayout title="Create Hero">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                New Quest
            </h1>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border border-gray-200 rounded-lg w-500">
                        <QuestForm :form="form" @submitted="form.post(route('quests.store'))" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

</template>