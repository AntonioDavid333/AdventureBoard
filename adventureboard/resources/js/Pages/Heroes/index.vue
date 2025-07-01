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
import HeroDetailsModal from './HeroDetailsModal.vue';

const props = defineProps({
    weapons: Array,
    purchases: Array,
    auth: Object,
    heroes: Object
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


const heroesList = computed(() => page.props.heroes?.data ?? []);

const selectedHero = ref(null)
const openHeroDetails = (hero) => { selectedHero.value = hero }
const closeHeroDetails = () => { selectedHero.value = null }

const deleteHero = (id) => {
    if (confirm('Are you sure you want to delete this hero?')) {
        router.delete(route('heroes.destroy', id))
    }
}

console.log('props.heroes:', props.heroes);
console.log('page.props.heroes:', page.props.heroes);

const draggedWeapon = ref(null)

function onDragStart(purchase) {
  draggedWeapon.value = purchase
}

function onDrop(hero) {
  if (!draggedWeapon.value) return

  router.post(route('heroe.attach'), {
    purchase_id: draggedWeapon.value.id,
    heroe_id: hero.id
  }/*, {
    onSuccess: () => {
        draggedWeapon.value = null
 
    },
    onError: (error) => {
        draggedWeapon.value = null
        alert('Failed to attach weapon to ${hero.name}')
    }
  }*/)
}

const isDragOverHero = ref(null)

//Calcular daño y defensa al sumar las armas equipadas
function strengthWithWeapons(hero) {
  const baseStrength = hero.strength || 0;
  const weaponsStrength = (hero.equipments ?? []).reduce((sum, eq) => {
    return sum + (eq.purchase?.weapon?.damage ?? 0);
  }, 0);
  return baseStrength + weaponsStrength;
}

function defenseWithWeapons(hero) {
  const baseDefense = hero.defense || 0;
  const weaponsDefense = (hero.equipments ?? []).reduce((sum, eq) => {
    return sum + (eq.purchase?.weapon?.defense ?? 0);
  }, 0);
  return baseDefense + weaponsDefense;
}

//Eliminar equipamiento
const deleteEquipment = (equipment) => {
   router.delete(route('equipments.destroy', equipment.id))
}

// filtrar armas equipadas para que no aparezcan en el inventario
const purchases = computed(() => page.props.purchases ?? []);


const equippedPurchaseIds = computed(() => {
  return heroesList.value.flatMap(hero => 
    (hero.equipments ?? []).map(equipment => equipment.purchase_id)
  );
});

const purchasesFiltered = computed(() => {
  return purchases.value.filter(purchase => !equippedPurchaseIds.value.includes(purchase.id));
});

</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Heroes
            </h1>
        </template>

        <div v-if="$page.props.flash && $page.props.flash.success" class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center">
            {{ $page.props.flash.success }}
        </div>
        <div v-if="$page.props.flash && $page.props.flash.error" class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4 text-center">
            {{ $page.props.flash.error }}
        </div>

        <HeroDetailsModal :hero="selectedHero" @close="closeHeroDetails" />

        <WeaponDetailsModal
            :weapon="selectedWeapon"
            @close="closeWeaponDetails"
             />

            <div class="py-12 ">
                <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex gap-8">
                        <div class="w-1/4">
                            <PurchasedWeapons :purchases="purchasesFiltered" @show-details="openWeaponDetails" @drag-start="onDragStart" />
                        </div>
                        <div class="flex-1">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="flex gap-4">
                                    <Link class="inline-block px-4 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition" :href="route('heroes.create')">
                                        Create hero 🪙100
                                    </Link>
                                </div>
                            </div>
                            <div class="bg-white">
                                <div class="mx-auto w-full px-6 lg:px-8">
                                    <div class="max-w-xl">
                                    <h2 class="text-3xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-4xl">Your heroes</h2>
                                    </div>
                                    <ul role="list" class="flex flex-wrap gap-6 justify-start py-8">
                                        <li
                                        v-for="hero in heroesList"
                                        :key="hero.id"
                                        :class="{ 'border-4 border-green-400': isDragOverHero === hero.id }"
                                        class="bg-white rounded-xl w-72 flex flex-col items-center relative pb-8 overflow-hidden shadow-lg drop-shadow-[6px_8px_12px_rgba(0,0,0,0.15)] transition duration-300 transform hover:scale-105 cursor-pointer"
                                        @click="openHeroDetails(hero)"
                                        @dragover.prevent="isDragOverHero = hero.id"       
                                        @dragleave="isDragOverHero = null"               
                                        @drop.prevent="() => { onDrop(hero); isDragOverHero = null }" 
                                        >

                                            <div class="w-full relative h-56">
                                                <img
                                                    v-if="hero.image_uri"
                                                    :src="`/storage/${hero.image_uri}`"
                                                    alt="Hero image"
                                                    class="absolute top-0 left-0 w-full h-56 object-cover object-top rounded-t-xl"
                                                />
                                            </div>
                                            <div class="flex-1 w-full pt-4 pl-4">
                                                <div class="font-bold text-xl text-center py-2">{{ hero.name }}</div>
                                                <!--<div class="text-gray-600 text-sm text-center m-2">{{ hero.background }}</div>-->
                                                <div class="m-2 w-full text-left space-y-2">
                                                    <div class="flex items-center">
                                                        <span class="w-10">💊</span>
                                                        <div class="flex-1 ml-2 flex items-center">
                                                            <div class="bg-gray-200 h-4 w-3/5">
                                                                <div class="bg-indigo-500 h-4" :style="{ width: (hero.hp / 10) + '%' }"></div>
                                                                
                                                            </div>
                                                            <span class="ml-2 font-bold text-xs text-gray-700">{{ hero.hp }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <span class="w-10">💥</span>
                                                        <div class="flex-1 ml-2 flex items-center">
                                                            <div class="bg-gray-200 rounded h-4 w-3/5 relative">
                                                                <div class="bg-indigo-500 h-4" :style="{ width: (hero.strength / 10) + '%' }"></div>
                                                                <div  class="bg-red-300 h-4 absolute top-0 left-0":style="{
                                                                    width: ((strengthWithWeapons(hero) - hero.strength) / 10) + '%',
                                                                    left: (hero.strength / 10) + '%' 
                                                                    }"></div>
                                                            </div>
                                                            <span class="ml-2 font-bold text-xs text-gray-700">{{ strengthWithWeapons(hero) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center">
                                                        <span class="w-10">🛡️</span>
                                                        <div class="flex-1 ml-2 flex items-center">
                                                            <div class="bg-gray-200  h-4 w-3/5 relative">
                                                                <div class="bg-indigo-500 h-4 " :style="{ width: (hero.defense / 10) + '%' }"></div>
                                                                <div v-if="defenseWithWeapons(hero) > hero.defense" class="bg-red-300 h-4 absolute top-0 left-0" :style="{
                                                                    width: ((defenseWithWeapons(hero) - hero.defense) / 10) + '%',
                                                                    left: (hero.defense / 10) + '%'
                                                                    }"></div>
                                                            </div>
                                                            <span class="ml-2 font-bold text-xs text-gray-700">{{ defenseWithWeapons(hero) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center ">
                                                        <span class="w-10">✨</span>
                                                        <div class="flex-1 ml-2 mb-4 flex items-center">
                                                            <div class="bg-gray-200 h-4 w-3/5">
                                                                <div class="bg-indigo-500 h-4" :style="{ width: (hero.ki / 10) + '%' }"></div>
                                                            </div>
                                                            <span class="ml-2 font-bold text-xs text-gray-700">{{ hero.ki }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full px-2 mt-6 relative">
                                                    <span class="absolute -top-8 right-6 flex items-end">
                                                        <span class="text-3xl font-extrabold text-gray-400 opacity-80 select-none leading-none">{{ hero.level ?? 1 }}</span>
                                                        <span class="ml-1 text-xs text-gray-500 mb-1">Lvl</span>
                                                    </span>
                                                    <div class="bg-gray-300 h-1 w-full">
                                                        <div class="bg-indigo-500 h-1" :style="{ width: (hero.experience ?? 0) + '%' }"></div>
                                                    </div>
                                                </div>
                                                <!-- Botón eliminar -->
                                                <button
                                                    @click.stop="deleteHero(hero.id)"
                                                    class="absolute top-2 right-2 hover:text-red-700 text-red-600 rounded-full p-2 shadow transition"
                                                    title="Eliminar héroe"
                                                >
                                                    🗑️
                                                </button>
                                            </div>
                                            <div v-if="hero.equipments && hero.equipments.length > 0"  class="w-full px-4 py-2">
                                                <h3 class="text-md font-semibold text-gray-600">Equipped Weapons:</h3>
                                                <ul class="mt-2 space-y-1 border">
                                                    <li v-for="equipment in hero.equipments" 
                                                    :key="equipment.id" 
                                                    class=" flex justify-between text-md text-gray-800 border-gray-400 rounded-md shadow-md p-2"
                                                    @click.stop="openWeaponDetails(equipment.purchase.weapon)">
                                                        🔹 {{ equipment.purchase?.weapon?.name ?? 'Unknown' }}
                                                         <button class=" text-gray-400 hover:text-gray-600 text-xl" @click.stop="deleteEquipment(equipment)">&times;</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </AppLayout>

</template>