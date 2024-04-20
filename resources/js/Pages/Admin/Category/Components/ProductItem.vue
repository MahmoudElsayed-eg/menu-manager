<template>
    <div
        dir="rtl"
        class="flex flex-row gap-2 border-2 border-gray-400 rounded-lg p-4 justify-evenly items-center w-full"
    >

        <p>
            {{ item.a_name }}
        </p>

        <p>
            {{ item.sell_price }} جنيه
        </p>
        <div class="flex flex-row items-center justify-center gap-1">
            <label for="position">الترتيب</label>
            <input id="position" type="number" class="w-14 rounded-md dark:bg-gray-600" v-model="position" min="0">
        </div>
        <button @click="$emit('add',position)" class="btn-primary">إضافة</button>
    </div>
</template>
<script setup>
import { ref } from 'vue';
const price = (item)=>{
    const date = new Date().toTimeString();
    console.log(date);
    if (item.date_from > date && item.date_to < date) {
        console.log(item);
    }
}
const position = ref(0);
defineProps({
    item: Object,
});
defineEmits(['add'])
</script>
