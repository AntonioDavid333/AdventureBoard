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
    }
});
 
const { form, updating } = props;

const computedDifficult = computed(() => {
    if (form.reguard < 20) return 'easy';
    if (form.reguard < 200) return 'medium';
    return 'hard';
});

const emit = defineEmits(['submitted']);

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

function handleSubmit() {
    form.difficulty = computedDifficult.value;
    emit('submitted');
}

</script>

<template>
    <FormSection @submitted="handleSubmit">
        <template #title>
            {{ updating ? 'Update Quest' : 'Create Quest' }}
        </template>
        <template #description>
            {{ updating ? 'Updates the selected Quest.' : 'Creates new Quest' }}
        </template>
        <template #form>
           <div class="col-span-6 sm:col-span-6">
                <!-- Titulo -->
                <div class="flex justify-between items-center gap-4 w-full pt-4 pb-2">
                <InputLabel for="title" value="title" class="w-32 shrink-0" />
                <TextInput id="title" v-model="form.title" type="text" autocomplete="title" class="flex-1" />
                <InputError :message="$page.props.errors.title" class="mt-2"></InputError>
                </div>
                <!--Descripción-->
                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                <InputLabel for="description" value="description" class="w-32 shrink-0" />
                <textarea id="description" v-model="form.description" type="text" autocomplete="description" class="flex-1 border border-gray-300 rounded-md"></textarea>
                <InputError :message="$page.props.errors.description" class="mt-2"></InputError>
                </div>
                <!--La imágen de la quest-->
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
                <!--Fuerza requerida-->
                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                    <InputLabel for="strength_required" value="strength_required" class="w-32 shrink-0" />
                    <TextInput id="strength_required" v-model="form.strength_required" type="number" min="0" step="1" class="flex-1" />
                    <InputError :message="$page.props.errors.strength_required" class="mt-2"></InputError>
                </div>
                
                <!--Defensa requerida-->
                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                    <InputLabel for="defense_required" value="defense_required" class="w-32 shrink-0" />
                    <TextInput id="defense_required" v-model="form.defense_required" type="number" min="0" step="1" class="flex-1" />
                    <InputError :message="$page.props.errors.defense_required" class="mt-2"></InputError>
                </div>

                <!--Ki requerido-->
                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                    <InputLabel for="ki_required" value="ki_required" class="w-32 shrink-0" />
                    <TextInput id="ki_required" v-model="form.ki_required" type="number" min="0" step="1" class="flex-1" />
                    <InputError :message="$page.props.errors.ki_required" class="mt-2"></InputError>
                </div>

                <!--Recompensa-->
                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                    <InputLabel for="reguard" value="reguard" class="w-32 shrink-0" />
                    <TextInput id="reguard" v-model="form.reguard" type="number" min="0" step="1" class="flex-1" />
                    <InputError :message="$page.props.errors.reguard" class="mt-2"></InputError>
                </div>

                <!-- Mostrar dificultad -->
                <div class="flex items-center gap-4 pt-4 pb-2">
                    <InputLabel value="Difficulty" class="w-32" />
                    <div class="text-gray-800 font-semibold">{{ computedDifficult }}</div>
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