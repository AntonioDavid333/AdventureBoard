<script setup>
defineProps({
  submission: {
    type: Object,
    required: true
  },
  isCreatedByUser: {
    type: Boolean,
    required: true
  }
})

const emit = defineEmits(['close', 'accept', 'deny'])

function accept() {
  emit('accept', submission.id)
  emit('close')
}

function deny() {
  emit('deny', submission.id)
  emit('close')
}

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
  <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div class="bg-white rounded-xl p-6 w-[32rem] max-w-full text-gray-800 relative">
      <button @click="$emit('close')" class="absolute top-2 right-3 text-gray-500 hover:text-black text-2xl">&times;</button>

      <h2 class="text-2xl font-semibold mb-4">Submission Detail</h2>

     <div v-if="submission.heroe" class="flex items-center gap-4 mb-4">
        <img
          class="w-20 h-20 object-cover rounded-md"
          :src="`/storage/${submission.heroe.image_uri}`"
          alt="Hero Image"
        />
        <div>
          <div class="text-lg font-bold">{{ submission.heroe.name }}</div>
          <div class="text-gray-600 text-sm">
            💥 {{ submission.heroe.strength }} |
            🛡️ {{ submission.heroe.defense }} |
            ✨ {{ submission.heroe.ki }}
          </div>
        </div>
      </div>

      <div v-else class="text-red-500 mb-4">
        ⚠️ Hero not found or not linked to this submission.
      </div>


      <!--<div class="mb-2">
        <strong>User:</strong> {{ submission.user.name }}
      </div>-->

      <div class="mb-2">
        <strong>Submitted on:</strong> {{ formatDate(submission.created_at) }}
      </div>

      <div class="mb-4">
        <strong>Description:</strong>
        <p class="p-2 text-gray-700 mt-1 whitespace-pre-line border rounded-md border-gray-400 w-100">{{ submission.description }}</p>
      </div>

      <div v-if="isCreatedByUser" class="flex justify-end gap-3">
        <button class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded-md text-sm transition" @click="$emit('accept', submission.id)">Accept</button>
        <button class="bg-red-500 hover:bg-green-600 text-white px-4 py-1 rounded-md text-sm transition" @click="$emit('deny', submission.id)">Deny</button>
      </div>
    </div>
  </div>
</template>
