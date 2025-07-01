<script>
export default {
    name: 'WeaponForm'
}
</script>

<script setup>
import { ref } from 'vue';
import FormSection from '../FormSection.vue';
import InputError from '../InputError.vue';
import InputLabel from '../InputLabel.vue';
import PrimaryButton from '../PrimaryButton.vue';
import TextInput from '../TextInput.vue';
import SecondaryButton from '../SecondaryButton.vue';

const props = defineProps({
    form: {
        type: Object,
        required: true
    },
    updating:{
        type: Boolean,
        required: false,
        default: false
    }
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
        props.form.image_uri = file;
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
    props.form.image_uri = '';
    imagePreview.value = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
}
</script>

<template>
    <FormSection @submitted="$emit('submit')">
        <template #title>
            {{ updating ? 'Update Weapon' : 'Create Weapon' }}
        </template>
        <template #description>
            {{ updating ? 'Updates the selected weapon.' : 'Creates new weapon for purchasing' }}
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
                <InputLabel for="description" value="Description" class="w-32 shrink-0" />
                <textarea id="description" v-model="form.description" type="text" autocomplete="description" class="flex-1 border border-gray-300 rounded-md"></textarea>
                <InputError :message="$page.props.errors.description" class="mt-2"></InputError>
                </div>

                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                <InputLabel for="image_uri" value="Image" class="w-32 shrink-0" />
                <!-- Input file oculto -->
                <input
                    ref="fileInput"
                    id="image_uri"
                    type="file"
                    accept="image/*"
                    class="hidden"
                    @change="onFileChange"
                />
                <SecondaryButton type="button" class="mt-2 mr-2" @click="triggerFileInput">
                    Upload Image
                </SecondaryButton>
                <span v-if="form.image_uri && form.image_uri.name" class="ml-2 text-sm text-gray-500 flex items-center">
                    {{ form.image_uri.name }}
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
                <InputLabel for="damage" value="Damage" class="w-32 shrink-0" />
                <TextInput id="damage" v-model="form.damage" type="number" autocomplete="damage" class="flex-1" />
                <InputError :message="$page.props.errors.damage" class="mt-2"></InputError>
                </div>

                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                <InputLabel for="defense" value="Defense" class="w-32 shrink-0" />
                <TextInput id="defense" v-model="form.defense" type="number" autocomplete="defense" class="flex-1" />
                <InputError :message="$page.props.errors.defense" class="mt-2"></InputError>
                </div>

                <div class="flex items-center gap-4 w-full pt-4 pb-2">
                <InputLabel for="price" value="Price" class="w-32 shrink-0" />
                <TextInput id="price" v-model="form.price" type="number" autocomplete="price" class="flex-1" />
                <InputError :message="$page.props.errors.price" class="mt-2"></InputError>
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