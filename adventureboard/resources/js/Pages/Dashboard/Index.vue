<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import PurchasedWeapons from '@/Pages/Weapons/PurchasedWeapons.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import WeaponDetailsModal from '@/Pages/Weapons/WeaponDetailsModal.vue';
import HeroesList from '../Heroes/HeroesList.vue';
import HeroDetailsModal from '../Heroes/HeroDetailsModal.vue';
import { ref } from 'vue';
import { defineProps } from 'vue';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import QuestsList from '@/Components/Quests/QuestsList.vue';

const page = usePage(); 
const heroes = computed(() => page.props.heroes ?? [])

const selectedWeapon = ref(null);
const openWeaponDetails = (weapon) => {
    selectedWeapon.value = weapon;
};
const closeWeaponDetails = () => {
    selectedWeapon.value = null;
};
const activeTab = ref('created');

const props = defineProps({
    purchases: {
        type: Array,
        default: () => []
    },
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
});

const equippedPurchaseIds = computed(() => {
  return (page.props.heroes?.data ?? []).flatMap(hero =>
    (hero.equipments ?? []).map(equipment => equipment.purchase_id)
  )
})

const selectedHero = ref(null)
const openHeroDetails = (hero) => { selectedHero.value = hero }
const closeHeroDetails = () => { selectedHero.value = null }

</script>

<template>
    <AppLayout>
         <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h1>
        </template> 
        <WeaponDetailsModal :weapon="selectedWeapon" @close="closeWeaponDetails" />
        <HeroDetailsModal :hero="selectedHero" @close="closeHeroDetails" />

        <div class="py-12 ">
                <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex gap-8">
                        <div class="w-1/4">
                            <PurchasedWeapons :purchases="props.purchases" :equippedPurchaseIds="equippedPurchaseIds" @show-details="openWeaponDetails" />
                        </div>
                        <div class="w-3/4">
                            <HeroesList :heroes="heroes" @show-details="openHeroDetails" />
                            <div class="bg-white py-8 sm:py-12 rounded-lg mt-2">
                                <div class="mx-auto w-full px-6 lg:px-8">
                                    <div class="w-full">
                                        <h2 class="text-2xl font-semibold tracking-tight text-pretty text-gray-900">Quests</h2>
                                        <div class="mt-8 flex gap-4 border-b border-gray-200">
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
