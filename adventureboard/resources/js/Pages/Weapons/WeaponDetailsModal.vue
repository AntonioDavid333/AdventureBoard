<script setup>
defineProps({ weapon: Object })
</script>

<template>
  <div v-if="weapon" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 " @click.self="$emit('close')">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full relative ">
      <button @click="$emit('close')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
      <img :src="`/storage/${weapon.image_uri}`" alt="Weapon image" class="w-full  object-contain rounded mb-0 mx-auto block" />
        <div class="p-8">
            <h2 class="text-3xl font-bold mb-2 text-center">{{ weapon.name }}</h2>
            <p class="mb-2 text-xl p-2">{{ weapon.description }}</p>
            <div class="flex flex-col align-center justify-center bg-gray-200 p-2 pt-4 rounded-lg">
                <div class="mb-2 text-xl text-center">💥 <b>Damage:</b> {{ weapon.damage }}</div>
                <div class="mb-2 text-xl text-center">🛡️ <b>Defense:</b> {{ weapon.defense }}</div>
                <div class="mb-2 text-xl text-center text-indigo-600 font-semibold">🪙 {{ weapon.price }}</div>
            </div>
        </div>
    </div>
  </div>
</template>