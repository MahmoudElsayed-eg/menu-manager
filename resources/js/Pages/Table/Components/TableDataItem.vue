<template>
    <div
        class="flex flex-row p-2 md:p-5 items-center justify-around border-b border-gray-300 dark:border-gray-600"
    >
        <div class="border border-gray-300 dark:border-gray-600 p-2 w-1/4">
            <img
                :src="
                    item.pic
                        ? '/storage/' + item.pic.pic
                        : '/storage/images/placeholder.jpg'
                "
                alt=""
                class="w-full"
            />
        </div>
        <div class="flex-1 flex flex-col items-center gap-2 justify-evenly">
            <p class="line-clamp-1 text-ellipsis text-center">
                {{ item?.name }}
            </p>
            <p class="line-clamp-1 text-ellipsis text-center text-xs">
               {{ item?.price.toFixed(2) }} ج.م
            </p>
            <div  class="flex flex-row items-center gap-1 justify-center">
                <button
                v-if="item?.printed != '1' || (user.is_admin == '1' || user.is_manager == '1')"
                    class="btn-increase-decrease w-5 h-5 bg-green-500 dark:bg-green-700 rounded-md flex items-center justify-center"
                    @click="$emit('increase')"
                >
                    +
                </button>
                <p>
                    {{ item?.amount }}
                </p>
                <button
                v-if="item?.printed != '1' || (user.is_admin =='1' || user.is_manager=='1')"
                    class="btn-increase-decrease w-5 h-5 bg-red-500 dark:bg-red-700 rounded-md flex items-center justify-center"
                    @click="$emit('decrease')"
                >
                    -
                </button>
            </div>
        </div>
        <PrinterIcon class="w-6 h-6 text-green-500" v-if="item?.printed == '1'" />
        <PrinterIcon class="w-6 h-6 text-red-500" v-if="item?.printed != '1' &&(user.is_admin == '1' || user.is_manager=='1')" />
        <TrashIcon class="w-6 h-6 cursor-pointer" v-if="item?.printed != '1' || (user.is_admin =='1' || user.is_manager=='1')" @click="$emit('delete')" />
    </div>
</template>
<script setup>
import PrinterIcon from "@/Icons/PrinterIcon.vue";
import TrashIcon from "@/Icons/TrashIcon.vue";
import { usePage } from '@inertiajs/vue3';
import { computed } from "vue";
const page = usePage();
const user = computed(()=>page.props.user);
defineProps({
    item: Object,
});
defineEmits(["increase", "decrease", "delete"]);
</script>
