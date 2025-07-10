<script>

</script>

<script setup>
import { toRefs } from 'vue'

const props = defineProps({
  quests: {
    type: Array,
    required: true
  }
})

function formatDate(dateString) {
  const date = new Date(dateString)
  return new Intl.DateTimeFormat('es-ES', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric'
  }).format(date)
}
</script>

<template>
  <ul class="mt-8 space-y-4">
    <li
      v-for="quest in quests"
      :key="quest.id"
      class="flex gap-6 justify-between items-center p-4 rounded-xl border border-gray-200 shadow-sm bg-white w-full"
    >
      <!-- Info básica -->
      <div class="w-1/3 space-y-1">
            <div class="flex gap-4">
                <div class="text-sm text-gray-500 italic">{{ quest.user.name }}</div>
                <div class="text-xs text-gray-400">{{ formatDate(quest.created_at) }}</div>
            </div>
        <div class="text-xl font-semibold text-gray-800">{{ quest.title }}</div>
      </div>

      <!-- Requisitos -->
      <div class="flex items-center text-gray-600 gap-4">
        <div>💥 {{ quest.strength_required }}</div>
        <div>🛡️ {{ quest.defense_required }}</div>
      </div>

      <!-- Dificultad y estado -->
      <div class="flex gap-2 w-60 text-center">
        <div class="w-60 items-center text-center">
          <div class="text-sm text-gray-500">Difficulty</div>
          <div class="bg-gray-100 rounded-md py-1 italic w-full">{{ quest.difficulty }}</div>
        </div>
        <div class="w-60 items-center text-center">
          <div class="text-sm text-gray-500">Status</div>
          <div class="bg-gray-100 rounded-md py-1 italic w-full">{{ quest.status }}</div>
        </div>
      </div>

      <!-- Recompensa -->
      <div class="text-xl text-yellow-600 font-medium">🪙 {{ quest.reguard }}</div>
    </li>
  </ul>
</template>