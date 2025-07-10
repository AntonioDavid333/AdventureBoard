<script>

</script>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import HeroSelect from '@/Components/Heroes/HeroSelect.vue';
import HeroDetailsModal from '../Heroes/HeroDetailsModal.vue';
import { ref } from 'vue';
import WeaponDetailsModal from '../Weapons/WeaponDetailsModal.vue';
import QuestsList from '@/Components/Quests/QuestsList.vue';

const props = defineProps({
    quests: {
        type: Array,
        required: true
    },
    heroes: {
        type: Object,
        required: true
    },
    purchases: {
        type: Object,
        required: true
    },
    createdQuests: {
        type: Array,
        required: true
    },
    joinedQuests: {
        type: Object,
        required: true
    }

})

const activeTab = ref('all'); // 'all' | 'created' | 'joined'


const selectedHero = ref(null);
const selectedWeapon = ref(null);

function formatDate(dateString) {
  const date = new Date(dateString)
  return new Intl.DateTimeFormat('es-ES', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  }).format(date)
}
/*onMounted(() => {
    console.log('quests prop:', quests);
});*/
</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Quests
            </h1>
        </template>

        <HeroDetailsModal v-if="selectedHero" :hero="selectedHero" @close="selectedHero = null" />
        <WeaponDetailsModal v-if="selectedWeapon" :weapon="selectedWeapon" @close="selectedWeapon = null" />

        <div class="py-12 ">
                <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex gap-8">
                        <div class="w-1/4">
                            <HeroSelect :heroes="heroes" @select-hero="selectedHero = $event" @select-weapon="selectedWeapon = $event" />
                        </div>
                        <div class="flex-1">
                            <div class="bg-white py-8 sm:py-12">
                                <div class="mx-auto w-full px-6 lg:px-8">
                                    <div class="w-full">
                                        <h2 class="text-3xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-4xl">Quests</h2>
                                        <div class="mt-8 flex gap-4 border-b border-gray-200">
                                            <button
                                            @click="activeTab = 'all'"
                                            :class="['pb-2 px-4', activeTab === 'all' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500']"
                                            >
                                                All
                                            </button>
                                            <button
                                            @click="activeTab = 'created'"
                                            :class="['pb-2 px-4', activeTab === 'created' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500']"
                                            >
                                                My Quests
                                            </button>
                                            <button
                                            @click="activeTab = 'joined'"
                                            :class="['pb-2 px-4', activeTab === 'joined' ? 'border-b-2 border-blue-600 text-blue-600 font-semibold' : 'text-gray-500']"
                                            >
                                                Submissions
                                            </button>
                                        </div>
                                        <div class="mt-6">
                                            <QuestsList v-if="activeTab === 'all'" :quests="quests" />
                                            <QuestsList v-else-if="activeTab === 'created'" :quests="createdQuests" />
                                            <QuestsList v-else-if="activeTab === 'joined'" :quests="joinedQuests" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div> 
               
    </AppLayout>

</template>