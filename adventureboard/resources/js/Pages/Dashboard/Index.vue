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

const page = usePage(); 
const heroes = computed(() => page.props.heroes ?? [])

const selectedWeapon = ref(null);
const openWeaponDetails = (weapon) => {
    selectedWeapon.value = weapon;
};
const closeWeaponDetails = () => {
    selectedWeapon.value = null;
};

const props = defineProps({
    purchases: {
        type: Array,
        default: () => []
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
                        </div>
                    </div>
                </div>
            </div>
    </AppLayout>
</template>
