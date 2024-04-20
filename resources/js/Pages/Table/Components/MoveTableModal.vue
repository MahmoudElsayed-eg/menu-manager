<template>
    <FullScreenModal :show="show" @close="$emit('close')">
        <div class="flex flex-col w-full h-full">
            <div class="flex flex-row gap-1 py-2">
                <div
                    dir="rtl"
                    class="flex items-center gap-1 md:gap-2 justify-end p-2"
                >
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <p>فارغ</p>
                    <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
                    <p>محجوز</p>
                    <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                    <p>مشغول</p>
                    <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                    <p>من</p>
                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <p>الى</p>
                </div>
            </div>

            <div class="flex flex-row gap-2 w-full">
                <div
                    v-for="(zone, index) in zones"
                    :key="index"
                    class="flex-1 text-2xl font-semibold line-clamp-1 text-ellipsis whitespace-nowrap text-center py-4 rounded-t-3xl cursor-pointer"
                    :class="{
                        'dark:bg-gray-600 bg-gray-300': index == current,
                    }"
                    @click="current = index"
                >
                    {{ zone.name }}
                </div>
            </div>

            <div
                ref="container"
                class="flex-1 border-2 border-gray-300 dark:border-gray-600 relative"
            >
                <!-- <div
                        class="border border-gray-950 w-fit p-2 bg-gray-300 absolute top-32"
                        :style="`top:${percent}% ;`"
                    >
                        test
                    </div> -->

                <div
                    v-for="(item, index) in zones[current].tables.filter(
                        (e) => e.id != table_id
                    )"
                    class="p-1 border-4 absolute cursor-pointer"
                    :class="{
                        'rounded-full': item.round != '0',
                        'border-blue-500': selected == item.id,
                        'border-green-500':
                            item.status == 'فارغ' && selected != item.id,
                        'border-yellow-500':
                            item.status == 'محجوز' && selected != item.id,
                        'border-red-500':
                            item.status == 'مشغول' && selected != item.id,
                    }"
                    :style="`top:${item.y}%; left:${
                        item.x
                    }%; width:calc(${parseInt(
                        item.width
                    )}% + 16px); height:calc(${parseInt(
                        item.height
                    )}% + 16px);`"
                >
                    <div
                        :key="index"
                        class="flex items-center justify-center text-center w-full h-full"
                        :style="`color:${item.textcolor};background-color:${item.tablecolor};`"
                        :class="{
                            'rounded-full': item.round != '0',
                        }"
                        @click="chooseTable(item)"
                    >
                        {{ item.name }}
                    </div>
                </div>
                <div
                    v-for="(item, index) in zones[current].tables.filter(
                        (e) => e.id == table_id
                    )"
                    class="p-1 border-purple-500 border-4 absolute"
                    :class="{
                        'rounded-full': item.round != '0',
                    }"
                    :style="`top:${item.y}%; left:${
                        item.x
                    }%; width:calc(${parseInt(
                        item.width
                    )}% + 16px); height:calc(${parseInt(
                        item.height
                    )}% + 16px);`"
                >
                    <div
                        :key="index"
                        class="flex items-center justify-center text-center w-full h-full"
                        :style="`color:${item.textcolor};background-color:${item.tablecolor};`"
                        :class="{
                            'rounded-full': item.round != '0',
                        }"
                    >
                        {{ item.name }}
                    </div>
                </div>
            </div>
        </div>
        <template #footer>
            <div dir="rtl" class="flex flex-row justify-around">
                <button
                    v-if="selected"
                    class="btn-green"
                    @click="$emit('move', selected)"
                >
                    تأكيد
                </button>
                <button class="btn-primary" @click="$emit('close')">
                    الغاء
                </button>
            </div>
        </template>
    </FullScreenModal>
</template>
<script setup>
import FullScreenModal from "@/Components/FullScreenModal.vue";
import { ref } from "vue";
const selected = ref(null);
const current = ref(0);
const chooseTable = (table) => {
    selected.value = table.id;
};
const props = defineProps({
    show: Boolean,
    zones: Object,
    table_id: Number,
});
defineEmits(["close", "move"]);
</script>
