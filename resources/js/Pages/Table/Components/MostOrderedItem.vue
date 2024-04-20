<template>
    <div @click="$emit('clicked')" class="cursor-pointer border-b flex flex-row w-full items-center gap-1 shadow-md h-14 p-1  border-gray-300 dark:border-gray-600">
        <p class="line-clamp-2 text-ellipsis flex-1">{{ item.a_name }}</p>
        <p class="w-14 text-center">{{ sell_price.toFixed(2) }}</p>
    </div>
</template>
<script setup>
const sell_price = parseFloat(props.item.sell_price)
const props =defineProps({
    item:Object,
})
defineEmits(['clicked']);
</script>