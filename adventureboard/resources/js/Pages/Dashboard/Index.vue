<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import PurchasedWeapons from '@/Pages/Weapons/PurchasedWeapons.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import WeaponDetailsModal from '@/Pages/Weapons/WeaponDetailsModal.vue';
import { ref } from 'vue';
const selectedWeapon = ref(null);
const openWeaponDetails = (weapon) => {
    selectedWeapon.value = weapon;
};
const closeWeaponDetails = () => {
    selectedWeapon.value = null;
};


</script>

<template>
    <AppLayout>
         <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h1>
        </template>
        <WeaponDetailsModal :weapon="selectedWeapon" @close="closeWeaponDetails" />

        <div class="py-12 ">
                <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex gap-8">
                        <div class="w-1/4">
                            <PurchasedWeapons @show-details="openWeaponDetails" />
                        </div>
                    </div>
                </div>
            </div>
    </AppLayout>
</template>
