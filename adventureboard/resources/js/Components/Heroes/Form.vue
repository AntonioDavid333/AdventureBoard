<script>
export default {
    name: 'HeroForm'
}
</script>

<script setup>
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { computed, ref } from 'vue';
import SecondaryButton from '../SecondaryButton.vue';


const props = defineProps({
    form: {
        type: Object,
        required: true
    },
    updating: {
        type: Boolean,
        required: false,
        default: false
    },
    factions: {
        type: Array,
        required: true
    },
    classroles: {
        type: Array,
        required: true
    },
    races: {
        type: Array,
        required: true
    }
});

const { form, factions, updating, classroles, races } = props;

const selectedFaction = computed(() => {
    return props.factions.find(f => f.id === form.faction);
});

const selectedRace = computed(() => {
    return props.races.find(r => r.id === form.race);
});

const selectedClassRole = computed(() => {
    return props.classroles.find(cr => cr.id === form.classrole);
});

defineEmits(['submit'])

const fileInput = ref(null);
const imagePreview = ref(null);

function triggerFileInput() {
    fileInput.value && fileInput.value.click();
}

function onFileChange(event) {
    const file = event.target.files[0];
    if (file) {
        form.image_uri = file;
        // Mostrar preview
        const reader = new FileReader();
        reader.onload = e => {
            imagePreview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        imagePreview.value = null;
    }
}

function removeImage() {
    form.image_uri = '';
    imagePreview.value = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
}
</script>

<template>
    <FormSection @submitted="$emit('submit')">
        <template #title>
            {{ updating ? 'Update Hero' : 'Create Hero' }}
        </template>
        <template #description>
            {{ updating ? 'Updates the selected hero.' : 'Creates new hero' }}
        </template>
        <template #form>
           <div class="col-span-6 sm:col-span-6">
                <!-- Repetible para cada campo -->
                <div class="flex justify-between items-center gap-4 w-full pt-4 pb-2">
                <InputLabel for="name" value="Name" class="w-32 shrink-0" />
                <TextInput id="name" v-model="form.name" type="text" autocomplete="name" class="flex-1" />
                <InputError :message="$page.props.errors.name" class="mt-2"></InputError>
                </div>

                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                <InputLabel for="background" value="Background" class="w-32 shrink-0" />
                <textarea id="background" v-model="form.background" type="text" autocomplete="background" class="flex-1 border border-gray-300 rounded-md"></textarea>
                <InputError :message="$page.props.errors.background" class="mt-2"></InputError>
                </div>

                <!--<div class="flex items-center gap-4 w-full pt-4 pb-2">
                <InputLabel for="image_uri" value="image_uri" class="w-32 shrink-0" />
                <TextInput id="image_uri" v-model="form.image_uri" type="text" autocomplete="image_uri" class="flex-1" />
                <InputError :message="$page.props.errors.image_uri" class="mt-2"></InputError>
                </div>-->
                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                    <InputLabel for="image_uri" value="image_uri" class="w-32 shrink-0" />
                    <!-- Input file oculto -->
                    <input
                        ref="fileInput"
                        id="image_uri"
                        type="file"
                        accept="image/*"
                        class="hidden"
                        @change="onFileChange"
                    />
                    <SecondaryButton class="mt-2 mr-2" type="button" @click="triggerFileInput">
                        Upload Image
                    </SecondaryButton>
                    <span v-if="form.image_uri" class="ml-2 text-sm text-gray-500 flex items-center">
                        {{ form.image_uri.name || form.image_uri }}
                        <button
                            type="button"
                            class="ml-2 text-red-500 hover:text-red-700 font-bold text-xl"
                            @click="removeImage"
                            aria-label="Remove image"
                        >
                            ×
                        </button>
                    </span>
                    <!-- Vista previa de la imagen -->
                    <div v-if="imagePreview" class="ml-4">
                        <img :src="imagePreview" alt="Preview" class="w-16 h-16 object-cover rounded shadow" />
                    </div>
                </div>

                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                    <InputLabel for="race" value="Race" class="w-32 shrink-0" />
                    <select id="race" v-model.number="form.race" class="flex-1 border border-gray-300 rounded-md">
                        <option v-for="race in races" :key="race.id" :value="race.id">
                            {{ race.race_name }} 
                        </option>
                    </select>
                </div>
                <!--<p v-if="selectedRace" class="text-sm text-gray-500 mt-2">
                            +7
                </p>-->

                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                    <InputLabel for="classrole" value="Class" class="w-32 shrink-0" />
                    <select id="classrole" v-model.number="form.classrole" class="flex-1 border border-gray-300 rounded-md">
                        <option v-for="classrole in classroles" :key="classrole.id" :value="classrole.id">
                            {{ classrole.classrole_name }}
                        </option>
                    </select>
                </div>
                <!--<p v-if="selectedClassRole" class="text-sm text-gray-500 mt-2">
                            +3
                </p>-->

                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                    <InputLabel for="faction" value="Faction" class="w-32 shrink-0" />
                    <select id="faction" v-model.number="form.faction" class="flex-1 border border-gray-300 rounded-md">
                        <option v-for="faction in factions" :key="faction.id" :value="faction.id">
                            {{ faction.name }} 
                        </option>
                    </select>
                </div>
                <p v-if="selectedFaction" class="text-sm text-gray-500 mt-2">
                            {{ selectedFaction.description }}
                </p>
            </div> 

        </template>
        <template #actions>
            <PrimaryButton>
                {{ updating? 'Update' : 'Create' }}
            </PrimaryButton>
        </template>
    </FormSection>
</template>