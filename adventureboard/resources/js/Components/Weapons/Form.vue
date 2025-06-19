<script>
export default {
    name: 'WeaponForm'
}
</script>

<script setup>
import FormSection from '../FormSection.vue';
import InputError from '../InputError.vue';
import InputLabel from '../InputLabel.vue';
import PrimaryButton from '../PrimaryButton.vue';
import TextInput from '../TextInput.vue';

defineProps({
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
           <div class="flex flex-col flex-1 gap-4 w-full justify-between">
                <!-- Repetible para cada campo -->
                <div class="flex justify-between items-center gap-4 w-full">
                <InputLabel for="name" value="Name" class="w-32 shrink-0" />
                <TextInput id="name" v-model="form.name" type="text" autocomplete="name" class="flex-1" />
                </div>

                <div class="flex items-center gap-4 w-full">
                <InputLabel for="description" value="Description" class="w-32 shrink-0" />
                <TextInput id="description" v-model="form.description" type="text" autocomplete="description" class="flex-1" />
                </div>

                <div class="flex items-center gap-4 w-full">
                <InputLabel for="price" value="Price" class="w-32 shrink-0" />
                <TextInput id="price" v-model="form.price" type="text" autocomplete="price" class="flex-1" />
                </div>

                <div class="flex items-center gap-4 w-full">
                <InputLabel for="damage" value="Damage" class="w-32 shrink-0" />
                <TextInput id="damage" v-model="form.damage" type="text" autocomplete="damage" class="flex-1" />
                </div>

                <div class="flex items-center gap-4 w-full">
                <InputLabel for="defense" value="Defense" class="w-32 shrink-0" />
                <TextInput id="defense" v-model="form.defense" type="text" autocomplete="defense" class="flex-1" />
                </div>
            </div> 

        </template>
    </FormSection>
</template>