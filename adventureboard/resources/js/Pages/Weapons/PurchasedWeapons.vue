<script setup>
import { computed } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
//import Link from '@inertiajs/vue3'
//import route from 'ziggy-js'

const page = usePage()
const coins = computed(() => page.props.auth.user.coins ?? 0)
const purchasedWeapons = computed(() => page.props.purchasedWeapons ?? [])

const deletePurchasedWeapon = (weapon) => {
    if (confirm('Are you sure you want to delete this weapon?')) {
        router.delete(route('purchases.destroy', weapon.id))
    }
}
</script>

<template>
    <div class="flex flex-col gap-1">
        <div class="bg-white p-4 rounded shadow max-w-100">
        <h2 class="text-xl font-bold mb-4">Inventory</h2>
        </div>
        <div class="bg-gray-50 p-1 rounded shadow max-w-100">
        <ul class=" rounded-lg p-2">
        <li v-for="weapon in purchasedWeapons" :key="weapon.id" class="mb-2">
            <div class="flex items-center gap-2 rounded-xl p-4 bg-white shadow hover:bg-gray-100 transition space-between cursor-pointer"
            @click="$emit('show-details', weapon)">
                <img :src="weapon.image_uri" alt="Weapon Image" class="w-12 h-12 rounded" />
                <div class="flex-1 flex-col">
                    <div class="font-semibold text-xl">{{ weapon.name }}</div>
                    <div class="text-m text-gray-500">💥 {{ weapon.damage }} | 🛡️ {{ weapon.defense }}</div>
                    
                </div>
                <button class=" text-gray-400 hover:text-gray-600 text-3xl" @click.stop="deletePurchasedWeapon(weapon)">&times;</button>
            </div>
        </li>
        <li v-if="!purchasedWeapons.length" class="text-gray-400">No weapons purchased</li>
        </ul>
        </div>
    </div>
</template>

