<script setup>
import { computed } from 'vue'
import { router } from '@inertiajs/vue3'
import { route } from 'ziggy-js'

defineProps({ hero: Object })

// Calcula fuerza con armas equipadas
function strengthWithWeapons(hero) {
  const baseStrength = hero.strength || 0;
  const weaponsStrength = (hero.equipments ?? []).reduce((sum, eq) => {
    return sum + (eq.purchase?.weapon?.damage ?? 0);
  }, 0);
  return baseStrength + weaponsStrength;
}

// Calcula defensa con armas equipadas
function defenseWithWeapons(hero) {
  const baseDefense = hero.defense || 0;
  const weaponsDefense = (hero.equipments ?? []).reduce((sum, eq) => {
    return sum + (eq.purchase?.weapon?.defense ?? 0);
  }, 0);
  return baseDefense + weaponsDefense;
}

const deleteEquipment = (equipment) => {
    if (!confirm(`Delete ${equipment.purchase?.weapon?.name}?`)) return;
   router.delete(route('equipments.destroy', equipment.id),{
    onSuccess: () => {
      router.reload();
    },
   })
}

</script>

<template>
  
    <div v-if="hero" class="fixed inset-0 z-50 gap-4 flex items-center justify-center bg-black bg-opacity-50 " @click.self="$emit('close')">
      <div class="bg-white max-h-100 rounded-2xl shadow-xl w-full max-w-sm relative ">
        <button @click="$emit('close')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        <img v-if="hero.image_uri" :src="`/storage/${hero.image_uri}`" alt="Hero image" class="w-full  object-contain rounded-xl mb-0 mx-auto block" />
          <div class="p-8">
              <h2 class="text-xl p-2 bg-amber-400 font-bold text-center rounded">{{ hero.name }}</h2>
              
              <p class="mb-2 text-sm text-gray-500 p-2">{{ hero.background }}</p>

              <div class="flex flex-col gap-2 mb-4">
                  <div v-if="hero.race" class="text-md"><b>Race:</b> {{ hero.race.race_name }}</div>
                  <div v-if="hero.classrole" class="text-md"><b>Class Role:</b> {{ hero.classrole.classrole_name }}</div>
                  <div v-if="hero.faction" class="text-md"><b>Faction:</b> {{ hero.faction.name }}</div>
              </div>

              <div class="flex flex-col align-center justify-center bg-gray-200 p-2 pt-4 rounded-lg gap-2">
                  <!-- HP -->
                  <div>
                      <div class="flex justify-between items-center mb-1">
                          <span class="text-lg">💊 <b>HP:</b></span>
                          <span class="font-bold text-gray-700">{{ hero.hp }}</span>
                      </div>
                      <div class="bg-gray-300 rounded h-3 w-full">
                          <div class="bg-indigo-500 h-3 rounded" :style="{ width: (hero.hp / 10) + '%' }"></div>
                      </div>
                  </div>
                  <!-- Strength -->
                  <div>
                      <div class="flex justify-between items-center mb-1">
                          <span class="text-lg">💥 <b>Strength:</b></span>
                          <span class="font-bold text-gray-700">{{ strengthWithWeapons(hero) }}</span>
                      </div>
                      <div class="bg-gray-300 h-3 w-full relative">
                          <div class="bg-indigo-500 h-3" :style="{ width: (hero.strength / 10) + '%' }"></div>
                          <div  class="bg-red-300 h-3 absolute top-0 left-0":style="{
                                                                    width: ((strengthWithWeapons(hero) - hero.strength) / 10) + '%',
                                                                    left: (hero.strength / 10) + '%' 
                                                                    }"></div>
                      </div>
                  </div>
                  <!-- Defense -->
                  <div>
                      <div class="flex justify-between items-center mb-1">
                          <span class="text-lg">🛡️ <b>Defense:</b></span>
                          <span class="font-bold text-gray-700">{{ defenseWithWeapons(hero) }}</span>
                      </div>
                      <div class="bg-gray-300 h-3 w-full relative">
                          <div class="bg-indigo-500 h-3" :style="{ width: (hero.defense / 10) + '%' }"></div>
                          <div  class="bg-red-300 h-3 absolute top-0 left-0":style="{
                                                                    width: ((defenseWithWeapons(hero) - hero.defense) / 10) + '%',
                                                                    left: (hero.defense / 10) + '%' 
                                                                    }"></div>
                      </div>
                  </div>
                  <!-- Ki -->
                  <div>
                      <div class="flex justify-between items-center mb-1">
                          <span class="text-lg">✨ <b>Ki:</b></span>
                          <span class="font-bold text-gray-700">{{ hero.ki }}</span>
                      </div>
                      <div class="bg-gray-300 rounded h-3 w-full">
                          <div class="bg-indigo-500 h-3 rounded" :style="{ width: (hero.ki / 10) + '%' }"></div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div>
      <div class="bg-gray-300 p-4 rounded-lg shadow-md mt-4">
        <h3 class="text-lg font-semibold mb-2">Weapons</h3>
        <ul class=" p-2">
          <li v-for="equipment in hero.equipments" :key="equipment.id" class="bg-white mb-1 border-gray-400 border-b pb-2 shadow-md rounded-lg"
          >
            <div class="flex justify-between items-center">
                <img v-if="equipment.purchase?.weapon?.image_uri" :src="`/storage/${equipment.purchase.weapon.image_uri}`" alt="Weapon Image" class="w-12 h-12 rounded m-4" />

                <div class="flex flex-col justify-between text-left w-full">
                    <span class="font-semibold text-left">{{ equipment.purchase?.weapon?.name }}</span>
                    <span class="text-sm text-gray-500 text-left">💥 {{ equipment.purchase?.weapon?.damage }} | 🛡️ {{ equipment.purchase?.weapon?.defense }}</span>
                </div>
                <button class=" text-gray-400 hover:text-gray-600 text-xl px-4" @click.stop="deleteEquipment(equipment)">&times;</button>
            </div>
          </li>
          <li v-if="!hero.equipments.length" class="text-gray-400">No weapons equipped</li>
        </ul>
      </div>
    </div>
  </div>
</template>