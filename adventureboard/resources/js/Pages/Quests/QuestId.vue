<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import HeroSelect from '@/Components/Heroes/HeroSelect.vue';
import HeroDetailsModal from '../Heroes/HeroDetailsModal.vue';
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

const errors = usePage().props.errors


const selectedHero = ref(null)
const selectedWeapon = ref(null)
const showSubmissionModal = ref(false)

function openSubmissionModal() {
  selectedHero.value = props.heroes.length > 0 ? props.heroes[0] : null;
  showSubmissionModal.value = true;
}

const submissionDescription = ref('')

const props = defineProps({
    quest: {
        type: Object,
        required: true
    },
    quests: {
        type: Object,
        required: true
    },
    heroes: {
        type: Object,
        required: true
    },
    purchases: {
        type: Object,
        required: true
    },
    createdQuests: {
        type: Array,
        required: true
    },
    joinedQuests: {
        type: Object,
        required: true
    },
    isCreatedByUser: {
        type: Boolean,
        required: true
    },
    submissions: {
        type: Object,
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

// Mensaje de alerta en caso de que el heroe seleccionado no cumpla con los requisitos
const isHeroEligible = computed(() => {
  if (!selectedHero.value) return false

  return (
    selectedHero.value.strength >= props.quest.strength_required &&
    selectedHero.value.defense >= props.quest.defense_required &&
    selectedHero.value.ki >= props.quest.ki_required
  )
})

const descriptionError = ref('')
const submissionError = ref('')


const submitQuest = () => {
  descriptionError.value = ''

  if (!selectedHero.value) {
    alert('Debes seleccionar un héroe primero.')
    return
  }

  if (!submissionDescription.value.trim()) {
    descriptionError.value = 'La descripción es obligatoria.'
    return
  }

  router.post('/submissions', {
    heroe_id: selectedHero.value.id,
    quest_id: props.quest.id,
    description: submissionDescription.value,
  }, {
    onSuccess: () => {
      showSubmissionModal.value = false
      submissionDescription.value = ''
    },
    onError: (errors) => {
        if (errors.description) {
            descriptionError.value = errors.description
        } else if (errors.submission) {
            submissionError.value = errors.submission
        } else {
            alert('Error al enviar la submission.')
            console.error(errors)
        }
        }
  })
}

</script>
<template>
<AppLayout>
    <template #header>
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ props.quest.title }}</h1> 
    </template>

    <div class="py-12 ">
                <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex gap-8">
                        <div v-if="!isCreatedByUser" class="w-1/4">
                            <HeroSelect :heroes="heroes" @select-hero="selectedHero = $event" @select-weapon="selectedWeapon = $event" />
                        </div>
                        <div class="w-3/4 items-center justify-center" :class="{ 'mx-auto': isCreatedByUser }">
                            <div class=" flex p-4 bg-white border-b border-gray-200 text-lg  text-gray-400 gap-8">
                                <div>{{ props.quest.user.name }}</div>
                                <div>{{ formatDate(props.quest.created_at) }}</div>
                            </div>
                            <img class="w-full h-50 object-cover" :src="`/storage/${quest.image_uri}`" alt="Quest image" />
                            <div class="p-6 bg-white border-b border-gray-200 text-2xl font-bold text-gray-800">
                                {{ props.quest.title }}
                            </div>
                            <div class="p-6 bg-white border-b border-gray-200 text-lg font-semibold text-gray-400">
                                {{ props.quest.description }}
                            </div>
                            <div class="p-6 bg-white border-b border-gray-200 text-lg font-semibold text-gray-800">
                                <div>Requirements</div>
                                <div class="flex justify-between w-1/4 mt-4 text-gray-400">
                                    <div>💥 {{ props.quest.strength_required }}</div>
                                    <div>🛡️ {{ props.quest.defense_required }}</div>
                                    <div>✨ {{ props.quest.ki_required }}</div>
                                </div>
                            </div>
                            <div class="p-6 bg-white border-b border-gray-200 text-lg font-semibold text-gray-800">
                                <div class="flex justify-between w-1/4 mt-4 text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <div>Difficulty</div>
                                        <div class="p-2 bg-gray-200 rounded-xl text-gray-800 w-full text-center">{{ props.quest.difficulty }}</div>
                                    </div>
                                    <div class="flex flex-col items-center">
                                        <div>Status</div>
                                        <div class="p-2 bg-gray-200 rounded-xl text-gray-800 w-full text-center">{{ props.quest.status }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col p-6 bg-white border-b border-gray-200 text-lg font-semibold text-gray-800">
                                <div>Reguard</div>
                                <div class="flex justify-between w-1/4 mt-4 text-gray-400">
                                    <div>🪙 {{ props.quest.reguard }}</div>
                                </div>
                                <div v-if="!isCreatedByUser" class=" flex justify-center items-center">
                                    <button @click="openSubmissionModal" class="p-2 bg-green-600 text-white text-center rounded-xl mt-8 w-1/6">Submit</button>
                                </div>
                            </div>
                            <div class="p-6 bg-white border-b border-gray-200 text-lg font-semibold text-gray-400">
                                <ul>
                                    <h3 class="font-semibold text-xl text-gray-800 mb-4">Submissions</h3>
                                    <li v-for="submission in submissions" :key="submission.id" class="flex gap-2 border border-gray-300 shadow-md rounded-lg p-4 hover:scale-105 ">
                                        <div class="font-semibold text-gray-800">
                                            {{ submission.heroe.name }}
                                        </div>
                                        <div>
                                            {{ submission.status }}
                                        </div>

                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</AppLayout>
<div v-if="showSubmissionModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
    <div v-if="errors.submission" class="text-red-500">
        {{ errors.submission }}
    </div>
    <div class="bg-white rounded-xl p-6 w-1/3 text-gray-800">
      <h2 class="text-xl font-semibold mb-4">Send Submission</h2>
      <label for="heroSelector" class="text-lg">Select your hero:</label>
      <select v-model="selectedHero" name="heroSelector" class="w-full border rounded-md p-2 my-2">
        <option  v-for="hero in props.heroes" :key="hero.id" :value="hero">
            {{ hero.name }}  💥{{ hero.strength }} | 🛡️ {{ hero.defense }} | ✨ {{ hero.ki }}
        </option>
    </select>
    <p v-if="selectedHero && !isHeroEligible" class="text-red-600 font-semibold my-2">
        ⚠️ This hero does not meet the minimum strength, defense, or ki requirements for this quest. 💥{{ quest.strength_required }} | 🛡️{{ quest.defense_required }} | ✨{{ quest.ki_required }}
    </p>
    <label for="submissionDescription" class="text-lg">Description:</label>
    <textarea name="submissionDescription" v-model="submissionDescription" class="w-full border rounded-md p-2 mb-4" required rows="4" placeholder="Describe your adventure to solve this quest..."></textarea>
    <p v-if="submissionError" class="text-red-600 font-semibold mb-2">
        {{ submissionError }}
    </p>
      <div class="flex justify-end gap-4">
        <button @click="showSubmissionModal = false" class="bg-gray-300 px-4 py-2 rounded">Cancel</button>
        <button @click="submitQuest" :disabled="!selectedHero || !isHeroEligible" class="bg-green-600 text-white px-4 py-2 rounded">Send</button>
      </div>
    </div>
  </div>
</template>