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
    return props.factions.find(f => f.id === form.faction_id);
});

const selectedRace = computed(() => {
    return props.races.find(r => r.id === form.race_id);
});

const selectedClassRole = computed(() => {
    return props.classroles.find(cr => cr.id === form.classrole_id);
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

const totalBonuses = computed(() => {
    const base = {hp: 20, at: 20, def: 20, ki: 20};
    if (selectedFaction.value) {
        base.hp += selectedFaction.value.bonus_hp || 0;
        base.at += selectedFaction.value.bonus_at || 0;
        base.def += selectedFaction.value.bonus_def || 0;
        base.ki += selectedFaction.value.bonus_ki || 0;
    }
    if (selectedRace.value) {
        base.hp += selectedRace.value.bonus_hp || 0;
        base.at += selectedRace.value.bonus_at || 0;
        base.def += selectedRace.value.bonus_def || 0;
        base.ki += selectedRace.value.bonus_ki || 0;
    }
    if (selectedClassRole.value) {
        base.hp += selectedClassRole.value.bonus_hp || 0;
        base.at += selectedClassRole.value.bonus_at || 0;
        base.def += selectedClassRole.value.bonus_def || 0;
        base.ki += selectedClassRole.value.bonus_ki || 0;
    }
    return base;
});

function handleSubmit() {
    form.hp = totalBonuses.value.hp;
    form.strength = totalBonuses.value.at;
    form.defense = totalBonuses.value.def;
    form.ki = totalBonuses.value.ki;
    form.post(route('heroes.store')); // <-- Esto es necesario
}
</script>

<template>
    <FormSection @submitted="handleSubmit">
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
                    <InputError :message="$page.props.errors.image_uri" class="mt-2"></InputError>
                </div>

                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                    <InputLabel for="race_id" value="Race" class="w-32 shrink-0" />
                    <select id="race_id" v-model.number="form.race_id" class="flex-1 border border-gray-300 rounded-md">
                        <option v-for="race in races" :key="race.id" :value="race.id">
                            {{ race.race_name }} 
                        </option>
                    </select>
                </div>
                <div v-if="selectedRace" class="text-md text-gray-500 mb-4 text-right italic">
                                <span class="text-green-700">
                                {{ selectedRace.description }} <br>
                                {{ selectedRace.bonus_hp ? `💊+${selectedRace.bonus_hp}` : '' }}
                                {{ selectedRace.bonus_at ? `💥+${selectedRace.bonus_at}` : '' }}
                                {{ selectedRace.bonus_def ? `🛡️+${selectedRace.bonus_def}` : '' }}
                                {{ selectedRace.bonus_ki ? `✨+${selectedRace.bonus_ki}` : '' }}
                                </span>
                </div>

                <div class="flex items-center gap-4 w-full pt-4 pb-2 col-span-6 sm:col-span-6">
                    <InputLabel for="classrole_id" value="Class" class="w-32 shrink-0" />
                    <select id="classrole_id" v-model.number="form.classrole_id" class="flex-1 border border-gray-300 rounded-md">
                        <option v-for="classrole in classroles" :key="classrole.id" :value="classrole.id">
                            {{ classrole.classrole_name }}
                        </option>
                    </select>
                    
                </div>
                    <div v-if="selectedClassRole" class="text-md text-gray-500 mb-4 text-right italic">
                                <span class="text-green-700">
                                {{ selectedClassRole.description }} <br>
                                {{ selectedClassRole.bonus_hp ? `💊+${selectedClassRole.bonus_hp}` : '' }}
                                {{ selectedClassRole.bonus_at ? `💥+${selectedClassRole.bonus_at}` : '' }}
                                {{ selectedClassRole.bonus_def ? `🛡️+${selectedClassRole.bonus_def}` : '' }}
                                {{ selectedClassRole.bonus_ki ? `✨+${selectedClassRole.bonus_ki}` : '' }}
                                </span>
                            </div>

                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                    <InputLabel for="faction_id" value="Faction" class="w-32 shrink-0" />
                    <select id="faction_id" v-model.number="form.faction_id" class="flex-1 border border-gray-300 rounded-md">
                        <option :value="null">No faction</option>
                        <option v-for="faction in factions" :key="faction.id" :value="faction.id">
                            {{ faction.name }} 
                        </option>
                    </select>
                </div>
                    <p v-if="selectedFaction" class="text-sm text-gray-500 mt-2 ">
                                {{ selectedFaction.description }} <br>
                    </p>
                    <p v-if="selectedFaction" class="text-lg text-gray-200 mt-2 text-right italic">
                        <span class="text-green-700">
                        {{ selectedFaction.bonus_hp ? `💊+${selectedFaction.bonus_hp}` : '' }}
                        {{ selectedFaction.bonus_at ? `💥+${selectedFaction.bonus_at}` : '' }}
                        {{ selectedFaction.bonus_def ? `🛡️+${selectedFaction.bonus_def}` : '' }}
                        {{ selectedFaction.bonus_ki ? `✨+${selectedFaction.bonus_ki}` : '' }}
                        </span>
                    </p>

                    <div class="items-end mt-6 p-4 bg-gray-300 rounded shadow text-gray-800 w-2/3 ml-auto">
    <p>
        <h3 class="font-bold text-xl">Statics:</h3>
        <div class="m-4 text-md italic text-right">
            <div class="flex justify-between items-center gap-4 ">
                <span>💊 HP: </span>
                <span class="italic text-green-700 text-lg">+ {{ totalBonuses.hp-100 }}</span>
                <span>{{ totalBonuses.hp }}</span>
            </div>
            <div class="flex justify-between items-center gap-4 ">
                <span>💥 Damage: </span>
                <span class="italic text-green-700 text-lg">+ {{ totalBonuses.at-20 }}</span>
                <span>{{ totalBonuses.at }}</span>
            </div>
            <div class="flex justify-between items-center gap-4 ">
                <span>🛡️ Defense: </span>
                <span class="italic text-green-700 text-lg">+ {{ totalBonuses.def-20 }}</span>
                <span>{{ totalBonuses.def }}</span>
            </div>
            <div class="flex justify-between items-center gap-4 ">
                <span>✨ Ki: </span>
                <span class="italic text-green-700 text-lg">+ {{ totalBonuses.ki-20 }}</span>
                <span>{{ totalBonuses.ki }}</span>
            </div>
        </div>
    </p>
</div>
            </div>
            

        </template>
        <template #actions>
            <PrimaryButton>
                {{ updating? 'Update' : 'Create' }}
            </PrimaryButton>
        </template>
    </FormSection>
</template>