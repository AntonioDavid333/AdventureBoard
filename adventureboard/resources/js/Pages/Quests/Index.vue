<script>

</script>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({
    quests: {
        type: Array,
        required: true
    }

})

/*onMounted(() => {
    console.log('quests prop:', quests);
});*/
</script>

<template>
    <AppLayout>
        <template #header>
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                Quests
            </h1>
        </template>
    
     <div class="py-12 ">
                <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">
                    <div class="flex gap-8">
                        <div class="w-1/4">
                            <!--<PurchasedWeapons :purchases="props.purchases" :equippedPurchaseIds="equippedPurchaseIds" @show-details="openWeaponDetails" />-->
                        </div>
                        <div class="flex-1">
                            <div class="bg-white py-8 sm:py-12">
                                <div class="mx-auto w-full px-6 lg:px-8">
                                    <div class="max-w-xl">
                                        <h2 class="text-3xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-4xl">Quests</h2>
                                    </div>
                                    <ul class="mt-8">
                                        <li v-for="quest in quests" :key="quest.id" class="flex justify-between p-4 rounded-xl border-gray-300 shadow-md">
                                           <div class="text-gray-800 text-xl font-semibold">{{ quest.title }}</div> 
                                           <div class="text-gray-600 text-md w-1/4 text-left">{{ quest.description }}</div> 
                                           <div class="text-gray-800 text-xl font-semibold">{{ quest.created_at }}</div> 
                                        </li>
                                    </ul>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
               
    </AppLayout>

</template>