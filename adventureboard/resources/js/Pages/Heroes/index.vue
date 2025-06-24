<script>
export default {
    name: 'HeroesIndex'
}
</script>

<script setup>
import { router, usePage } from '@inertiajs/vue3'
//import { computed } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import PurchasedWeapons from '../Weapons/PurchasedWeapons.vue';
import { defineProps } from 'vue';
import WeaponDetailsModal from '../Weapons/WeaponDetailsModal.vue';
import { computed, ref } from 'vue';

const props = defineProps({
    weapons: Array,
    purchasedWeapons: Array,
    auth: Object,
    heroes: Array
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

const selectedHero = ref(null)
const heroesList = computed(() => page.props.heroes)

const openHeroDetails = (hero) => { selectedHero.value = hero }
const closeHeroDetails = () => { selectedHero.value = null }

</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Heroes
            </h1>
        </template>

        <WeaponDetailsModal
            :weapon="selectedWeapon"
            @close="closeWeaponDetails" />

            <div class="py-12 ">
                <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex gap-8">
                        <div class="w-1/4">
                            <PurchasedWeapons @show-details="openWeaponDetails" />
                        </div>
                        <div class="flex-1">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="flex gap-4">
                                    <Link class="inline-block px-4 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition" :href="route('heroes.create')">
                                        Create hero
                                    </Link>
                                </div>
                            </div>
                            <div class="bg-white py-8 sm:py-12">
                                <div class="mx-auto w-full px-6 lg:px-8">
                                    <div class="max-w-xl">
                                    <h2 class="text-3xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-4xl">Your heroes</h2>
                                    </div>
                                    <ul role="list" class="flex flex-wrap gap-6 justify-center py-8">
                                    <!--<li
                                        v-for="hero in heroesList" :key="hero.id"
                                        class="w-80 bg-white rounded-md shadow-md flex flex-col items-center text-center transform transition duration-300 hover:scale-105"
                                        @click="openHeroDetails(hero)">
                                        <img class="w-full h-60 object-cover rounded-t-md" :src="hero.image_uri" alt="Hero image" />
                                        <div class="mt-4">
                                            <h3 class="text-xl font-semibold text-gray-900 mx-4">{{ hero.name }}</h3>
                                            <p class="text-sm text-gray-600 mt-1 mx-4">{{ hero.description }}</p>
                                            <p class="text-lg text-gray-800 mt-2 mx-4">💥 Damage: {{ hero.damage }}</p>
                                            <p class="text-lg text-gray-800">🛡️ Defense: {{ hero.defense }}</p>
                                            <p class="text-lg text-indigo-600 mt-2 font-semibold">🪙 {{ hero.price }}</p>
                                            <Link class="text-gray-400 ml-8 mr-2" v-if="isAdmin" @click.stop="editWeapon(hero.id)">Edit</Link>
                                            <span class="text-gray-400 mx-2" v-if="isAdmin">|</span>
                                            <Link class="text-red-600 mx-2" v-if="isAdmin" @click.stop="deleteWeapon(hero.id)">Delete</Link>
                                        </div>
                                    </li>-->

                                    <!-- More heroes... -->
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </AppLayout>

</template>