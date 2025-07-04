<script>
export default {
    name: 'HeroesList'
}
</script>

<script setup>
import { usePage } from '@inertiajs/vue3'
//import { computed, ref } from 'vue' 
//import { route } from 'ziggy-js'

defineProps({
  heroes: {
    type: Array,
    default: () => []
  }
})

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
    <div class="flex w-full bg-white p-4 rounded shadow mb-2">
        <h2 class="text-xl font-bold">My Heroes</h2>
    </div>
    <div class="p-4 bg-gray-100 rounded shadow ">
        <ul class="flex flex-wrap gap-4">
            <li v-for="hero in heroes" :key="hero.id" class="flex flex-col mb-4 bg-white rounded-xl shadow hover:bg-gray-50 transition cursor-pointer w-1/5 h-full"
                @click="$emit('show-details', hero)">
                <!--<div class="flex flex-col flex-1 items-center gap-4 w-full">-->
                    <img v-if="hero.image_uri" :src="`/storage/${hero.image_uri}`" alt="Hero image" class="w-full h-40 rounded-xl object-cover" />
                    <div class="flex flex-col flex-1 justify-between p-2">
                        <h3 class="text-lg font-semibold px-2">{{ hero.name }}</h3>
                        <div class=" flex items-center gap-2 justify-end mt-auto">
                            <span class="text-gray-400 text-3xl ml-auto">{{ hero.level }} </span><span class="text-md text-gray-400">Lvl</span>
                        </div>
                    <!--</div>-->
                    <!--<span class="text-sm text-gray-500">HP: {{ hero.hp }}</span>-->
                </div>


            </li>
        </ul>

    
    </div>

</template>