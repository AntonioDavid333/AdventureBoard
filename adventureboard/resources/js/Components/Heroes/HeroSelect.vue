<script>
export default {
    name: 'HeroSelect'
}
</script>

<script setup>
import { ref, computed } from 'vue'
import { onMounted } from 'vue'
import { watch } from 'vue'

// Para que siempre haya un heroe seleccionado por defecto
/*onMounted(() => {
  if (props.heroes.length > 0) {
    emit('select-hero', props.heroes[0])
  }
})*/



// Recibimos los héroes como propiedad desde la vista Quests
const props = defineProps({
  heroes: {
    type: Object,
    required: true
  }
})

// Estado para el índice actual
const currentIndex = ref(0)

// Computamos el héroe actual
const currentHero = computed(() => props.heroes[currentIndex.value])

// Funciones de navegación
const nextHero = () => {
  if (props.heroes.length > 0) {
    currentIndex.value = (currentIndex.value + 1) % props.heroes.length
  }
}
const prevHero = () => {
  if (props.heroes.length > 0) {
    currentIndex.value = (currentIndex.value - 1 + props.heroes.length) % props.heroes.length
  }
}

// Emitimos el nuevo héroe cuando cambia el índice
watch(currentIndex, (newIndex) => {
  emit('select-hero', props.heroes[newIndex])
})

const emit = defineEmits(['select-hero'])

const openHeroDetails = (hero) => {
  emit('select-hero', hero)
}
 
const openWeaponDetails = (weapon) => {
    emit('select-weapon', weapon)
}
//const deleteHero = (id) => alert(`Eliminar héroe ${id}`)
//const deleteEquipment = (equipment) => alert(`Eliminar equipo`) 

const strengthWithWeapons = (hero) => {
  const bonus = hero.equipments?.reduce((sum, eq) => {
    return sum + (eq.purchase?.weapon?.damage ?? 0)
  }, 0)
  return hero.strength + bonus
}

const defenseWithWeapons = (hero) => {
  const bonus = hero.equipments?.reduce((sum, eq) => {
    return sum + (eq.purchase?.weapon?.defense ?? 0)
  }, 0)
  return hero.defense + bonus
}

</script>

<template>
  <div class="flex flex-col items-center py-8 space-y-4 w-full bg-white" v-if="props.heroes.length">

    <!-- Navegación -->
    <div class="flex flex-col gap-4 items-center justify-between space-x-4 bg-white w-full p-2">
        <div class="flex items-center justify-between gap-2 w-full max-w-md px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 shadow-sm">
            <button @click="prevHero" class="text-sm px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">⬅️</button>

            <div class="flex-1 text-center text-xl font-semibold text-gray-800 truncate">
                {{ currentHero.name }}
            </div>

            <button @click="nextHero" class="text-sm px-3 py-2 bg-gray-200 rounded hover:bg-gray-300">➡️</button>
        </div>

      <!-- Hero Card -->
      <div
        :key="currentHero.id"
        class="bg-white rounded-xl w-72 flex flex-col items-center relative pb-8 overflow-hidden shadow-lg drop-shadow-[6px_8px_12px_rgba(0,0,0,0.15)] transition duration-300 transform hover:scale-105 cursor-pointer"
        @click="openHeroDetails(currentHero)"
      >
        <div class="w-full relative h-56">
          <img
            v-if="currentHero.image_uri"
            :src="`/storage/${currentHero.image_uri}`"
            alt="Hero image"
            class="absolute top-0 left-0 w-full h-56 object-cover object-top rounded-t-xl" />
        </div>

        <div class="flex-1 w-full pt-4 pl-4">
          <!--<div class="font-bold text-xl text-center py-2">{{ currentHero.name }}</div>-->

          <div class="m-2 w-full text-left space-y-2">
            <!-- HP -->
            <div class="flex items-center">
              <span class="w-10">💊</span>
              <div class="flex-1 ml-2 flex items-center">
                <div class="bg-gray-200 h-4 w-3/5">
                  <div class="bg-indigo-500 h-4" :style="{ width: (currentHero.hp / 10) + '%' }"></div>
                </div>
                <span class="ml-2 font-bold text-xs text-gray-700">{{ currentHero.hp }}</span>
              </div>
            </div>

            <!-- Strength -->
            <div class="flex items-center">
              <span class="w-10">💥</span>
              <div class="flex-1 ml-2 flex items-center">
                <div class="bg-gray-200 rounded h-4 w-3/5 relative">
                  <div class="bg-indigo-500 h-4" :style="{ width: (currentHero.strength / 10) + '%' }"></div>
                  <div class="bg-red-300 h-4 absolute top-0 left-0" :style="{
                    width: ((strengthWithWeapons(currentHero) - currentHero.strength) / 10) + '%',
                    left: (currentHero.strength / 10) + '%'
                    }"></div>
                </div>
                <span class="ml-2 font-bold text-xs text-gray-700">{{ strengthWithWeapons(currentHero) }}</span>
              </div>
            </div>

            <!-- Defense -->
            <div class="flex items-center">
              <span class="w-10">🛡️</span>
              <div class="flex-1 ml-2 flex items-center">
                <div class="bg-gray-200 h-4 w-3/5 relative">
                  <div class="bg-indigo-500 h-4" :style="{ width: (currentHero.defense / 10) + '%' }"></div>
                  <div v-if="defenseWithWeapons(currentHero) > currentHero.defense"
                    class="bg-red-300 h-4 absolute top-0 left-0" :style="{
                      width: ((defenseWithWeapons(currentHero) - currentHero.defense) / 10) + '%',
                      left: (currentHero.defense / 10) + '%'
                    }"></div>
                </div>
                <span class="ml-2 font-bold text-xs text-gray-700">{{ defenseWithWeapons(currentHero) }}</span>
              </div>
            </div>

            <!-- KI -->
            <div class="flex items-center">
              <span class="w-10">✨</span>
              <div class="flex-1 ml-2 mb-4 flex items-center">
                <div class="bg-gray-200 h-4 w-3/5">
                  <div class="bg-indigo-500 h-4" :style="{ width: (currentHero.ki / 10) + '%' }"></div>
                </div>
                <span class="ml-2 font-bold text-xs text-gray-700">{{ currentHero.ki }}</span>
              </div>
            </div>
          </div>

          <!-- Nivel y experiencia -->
          <div class="w-full px-2 mt-6 relative">
            <span class="absolute -top-8 right-6 flex items-end">
              <span class="text-3xl font-extrabold text-gray-400 opacity-80 select-none leading-none">{{ currentHero.level ?? 1 }}</span>
              <span class="ml-1 text-xs text-gray-500 mb-1">Lvl</span>
            </span>
            <div class="bg-gray-300 h-1 w-full">
              <div class="bg-indigo-500 h-1" :style="{ width: (currentHero.experience ?? 0) + '%' }"></div>
            </div>
          </div>

          <!-- Botón eliminar -->
          <!--<button
            @click.stop="deleteHero(currentHero.id)"
            class="absolute top-2 right-2 hover:text-red-700 text-red-600 rounded-full p-2 shadow transition"
            title="Eliminar héroe">
            🗑️
          </button>-->
        </div>

        <!-- Equipamiento -->
        <div v-if="currentHero.equipments && currentHero.equipments.length > 0" class="w-full px-4 py-2">
          <h3 class="text-md font-semibold text-gray-600">Equipped Weapons:</h3>
          <ul class="mt-2 space-y-1 border">
            <li v-for="equipment in currentHero.equipments"
              :key="equipment.id"
              class="flex justify-between text-md text-gray-800 border-gray-400 rounded-md shadow-md p-2"
              @click.stop="openWeaponDetails(equipment.purchase.weapon)">
              🔹 {{ equipment.purchase?.weapon?.name ?? 'Unknown' }}
              <!--<button class="text-gray-400 hover:text-gray-600 text-xl" @click.stop="deleteEquipment(equipment)">&times;</button>-->
            </li>
          </ul>
        </div>
      </div>

      
    </div>
  </div>
</template>
