<script>
export default {
    name: 'WeaponsIndex'
}
</script>

<script setup>
import { router, usePage } from '@inertiajs/vue3'
//import { computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import PurchasedWeapons from './PurchasedWeapons.vue';
import { defineProps } from 'vue';
import WeaponDetailsModal from './WeaponDetailsModal.vue';
import { computed, ref } from 'vue';

const props = defineProps({
    weapons: Array,
    purchases: Array,
    auth: Object
});

const deleteWeapon = (id) => {
    if (confirm('Are you sure you want to delete this weapon?')) {
        router.delete(route('weapons.destroy', id))
    }
}

const buyWeapon = (weaponId) => {
    router.post(route('weapons.buy', weaponId));
}

const editWeapon = (weaponId) => {
    router.get(route('weapons.edit', weaponId));
}

const page = usePage()
const weapons = computed(() => page.props.weapons)
//const weapon = computed(() => page.props.weapon)
const isAdmin = computed(() => page.props.auth.roles.includes('admin'))

//import { route } from 'vendor/tightenco/ziggy/src/js';

const selectedWeapon = ref(null)
const openWeaponDetails = (weapon) => { selectedWeapon.value = weapon }
const closeWeaponDetails = () => { selectedWeapon.value = null }

const equippedPurchaseIds = computed(() => {
  return (page.props.heroes?.data ?? []).flatMap(hero =>
    (hero.equipments ?? []).map(equipment => equipment.purchase_id)
  )
})

</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Weapons
            </h1>
        </template>

        <div v-if="$page.props.flash && $page.props.flash.success" class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center">
            {{ $page.props.flash.success }}
        </div>
        <div v-if="$page.props.flash && $page.props.flash.error" class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4 text-center">
            {{ $page.props.flash.error }}
        </div>

        <WeaponDetailsModal :weapon="selectedWeapon" @close="closeWeaponDetails" />

        <div class="py-12 ">
                <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex gap-8">
                        <div class="w-1/4">
                            <PurchasedWeapons :purchases="props.purchases" :equippedPurchaseIds="equippedPurchaseIds" @show-details="openWeaponDetails" />
                        </div>
                        <div class="flex-1">
                            <div v-if="isAdmin" class="p-6 bg-white border-b border-gray-200">
                                <div class="flex gap-4">
                                    <Link class="inline-block px-4 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition" :href="route('weapons.create')">
                                        Create weapon
                                    </Link>
                                </div>
                            </div>
                            <div class="bg-white py-8 sm:py-12">
                                <div class="mx-auto w-full px-6 lg:px-8">
                                    <div class="max-w-xl">
                                    <h2 class="text-3xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-4xl">Weapons market</h2>
                                    </div>
                                    <ul role="list" class="flex flex-wrap gap-6 justify-center py-8">
                                    <li
                                        v-for="weapon in weapons" :key="weapon.id"
                                        class="w-80 bg-white rounded-md shadow-md flex flex-col items-center text-center transform transition duration-300 hover:scale-105"
                                        @click="openWeaponDetails(weapon)">
                                        <img class="w-full h-60 object-cover rounded-t-md" :src="`/storage/${weapon.image_uri}`" alt="Weapon image" />
                                        <div class="mt-4">
                                            <h3 class="text-xl font-semibold text-gray-900 mx-4">{{ weapon.name }}</h3>
                                            <p class="text-sm text-gray-600 mt-1 mx-4">{{ weapon.description }}</p>
                                            <p class="text-lg text-gray-800 mt-2 mx-4">💥 Damage: {{ weapon.damage }}</p>
                                            <p class="text-lg text-gray-800">🛡️ Defense: {{ weapon.defense }}</p>
                                            <p class="text-lg text-indigo-600 mt-2 font-semibold">🪙 {{ weapon.price }}</p>
                                            <button
                                                @click="buyWeapon(weapon.id)"
                                                class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition mb-8">
                                                Get it!
                                                </button>
                                            <Link class="text-gray-400 ml-8 mr-2" v-if="isAdmin" @click.stop="editWeapon(weapon.id)">Edit</Link>
                                            <span class="text-gray-400 mx-2" v-if="isAdmin">|</span>
                                            <Link class="text-red-600 mx-2" v-if="isAdmin" @click.stop="deleteWeapon(weapon.id)">Delete</Link>
                                        </div> 
                                    </li>

                                    <!-- More people... -->
                                    </ul>
                                    </div>
                            </div>
                        </div>
                    </div>

                </div>
        </div>
    </AppLayout>
</template>