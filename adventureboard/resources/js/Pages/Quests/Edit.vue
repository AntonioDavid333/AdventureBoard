<script>
export default {
    name: 'QuestCreate'
}
</script>

<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import QuestForm from '@/Components/Quests/Form.vue';

const props = defineProps({
    quest: {
        type: Object,
        required: true
    }

});

const form = useForm({
    title: props.quest.title,
    description: props.quest.description,
    strength_required: props.quest.strength_required,
    defense_required: props.quest.defense_required,
    ki_required: props.quest.ki_required,
    reguard: props.quest.reguard,
    image_uri: props.quest.image_uri,
    difficulty: props.quest.difficulty
})

</script>
<template>
    <AppLayout title="Create Hero">
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Quest
            </h1>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border border-gray-200 rounded-lg w-500">
                        <QuestForm :form="form" :updating="true" @submitted="form.put(route('quests.update', quest.id))" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>

</template>