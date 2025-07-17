<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import HeroSelect from '@/Components/Heroes/HeroSelect.vue';
import HeroDetailsModal from '../Heroes/HeroDetailsModal.vue';
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import SubmissionDetailModal from '@/Components/Submissions/SubmissionDetailModal.vue';
import { route } from 'ziggy-js'

//import { route } from 'ziggy-js'



const errors = usePage().props.errors

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

const selectedHero = ref(null)
const selectedWeapon = ref(null)
const showSubmissionModal = ref(false)

function openSubmissionModal() {
  selectedHero.value = props.heroes.length > 0 ? props.heroes[0] : null;
  showSubmissionModal.value = true;
}

const submissionDescription = ref('')

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

const acceptSubmission = (submissionId) => {
  const confirmed = confirm('Are you sure you want to accept this submission? All other submissions will be rejected.');

  if (confirmed) {
    router.put(`/submissions/${submissionId}/accept`, {}, {
      preserveScroll: true,
      onSuccess: () => {
        
      },
      onError: (error) => {
        alert('Error while accepting the submission');
        console.error(error);
      }
    });
  }
};

const denySubmission = (submissionId) => {
  const confirmed = confirm('Are you sure you want to reject this submission?');

  if (confirmed) {
    router.put(`/submissions/${submissionId}/deny`, {}, {
      preserveScroll: true,
      onSuccess: () => {
        
      },
      onError: (error) => {
        alert('Error while rejecting the submission');
        console.error(error);
      }
    });
  }
};



const showSubmissionDetailModal = ref(false)
const selectedSubmissionDetail = ref(null)

function openSubmissionDetail(submission) {
    console.log('Opening modal with submission:', submission)
  selectedSubmissionDetail.value = submission
  showSubmissionDetailModal.value = true
}

function confirmDeleteQuest() {
  if (confirm('¿Sure you want to delete this quest?.')) {
    router.delete(`/quests/${props.quest.id}`, {
      preserveScroll: true,
      onSuccess: () => {
        alert('Quest deleted.')
        router.visit('quests.index') 
      },
      onError: (error) => {
        alert('Error on deleting quest')
        console.error(error)
      }
    })
  }
}


</script>
<template>
<AppLayout>
    <template #header>
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">{{ props.quest.title }}</h1> 
    </template>

    <SubmissionDetailModal
    v-if="showSubmissionDetailModal && selectedSubmissionDetail"
    :submission="selectedSubmissionDetail"
    :isCreatedByUser="isCreatedByUser"
    @close="showSubmissionDetailModal = false"
    @accept="acceptSubmission"
    @deny="denySubmission"
    />



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
                            <div class="flex p-6 bg-white border-b border-gray-200 text-2xl font-bold text-gray-800 justify-between">
                                {{ props.quest.title }}
                                <div v-if="isCreatedByUser" class="flex gap-4 mb-4">
                                  <button
                                    @click="confirmDeleteQuest"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm"
                                  >
                                    Delete
                                  </button>

                                  <button
                                    @click="() => router.get(route('quests.create'), { updating: true })"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm"
                                  >
                                    Edit
                                  </button>
                                </div>
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
                                <h3 class="font-semibold text-xl text-gray-800 mb-4">Submissions</h3>
                                <ul class="space-y-4">
                                    <li
                                    v-for="submission in submissions"
                                    @click="openSubmissionDetail(submission)"
                                    :key="submission.id"
                                    :class="[
                                    'flex items-center gap-4 border shadow-md rounded-xl p-4 hover:scale-[1.02] transition-transform',
                                    submission.status === 'accepted' ? 'bg-green-100 border-green-300' : '',
                                    submission.status === 'rejected' ? 'bg-red-100 border-red-300' : '',
                                    submission.status === 'pending' ? 'bg-white border-gray-300' : ''
                                    ]"
                                    >
                                    <!-- Imagen del héroe -->
                                    <img
                                        class="w-16 h-16 object-cover rounded-md"
                                        :src="`/storage/${submission.heroe.image_uri}`"
                                        alt="Heroe"
                                    />

                                    <!-- Información del héroe -->
                                    <div class=" flex justify-between flex-1 px-4">
                                        <div class="text-gray-900 font-semibold text-lg">
                                        {{ submission.heroe.name }}
                                        </div>

                                        <!-- Descripción truncada -->
                                        <p class="text-gray-600 text-sm line-clamp-2 max-w-full justify-center items-center">
                                        {{ submission.description }}
                                        </p>

                                        <!-- Estado opcional -->
                                        <div class="text-sm text-gray-500 mt-1 bg-gray-200 px-2 rounded-xl py-4">
                                        {{ submission.status }}
                                        </div>
                                    </div>

                                    <!-- Botones -->
                                    <div v-if="isCreatedByUser && submission.status === 'pending'"   class="flex gap-2 items-center justify-center ml-4" @click.stop>
                                        <button
                                        @click="acceptSubmission(submission.id)"
                                        class="bg-green-500 hover:bg-green-600 text-white px-4 py-1 rounded-md text-sm transition"
                                        >
                                        Acept
                                        </button>
                                        <button
                                        @click="denySubmission(submission.id)"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded-md text-sm transition"
                                        >
                                        Deny
                                        </button>
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