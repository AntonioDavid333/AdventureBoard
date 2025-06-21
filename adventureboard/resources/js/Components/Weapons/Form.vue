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
                <InputLabel for="image_uri" value="image_uri" class="w-32 shrink-0" />
                <TextInput id="image_uri" v-model="form.image_uri" type="text" autocomplete="image_uri" class="flex-1" />
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