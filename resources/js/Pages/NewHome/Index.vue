<template>
    <!-- {{ zones }} -->
    <div v-if="zones.length != 0" class="p-4 flex-1 flex flex-col">
        <div dir="rtl" class="flex items-center gap-1 md:gap-2 justify-end p-2">
            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
            <p>فارغ</p>
            <div class="w-2 h-2 bg-yellow-500 rounded-full"></div>
            <p>محجوز</p>
            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
            <p>مشغول</p>
        </div>
        <div class="flex flex-row gap-2 w-full">
            <div
                v-for="(zone, index) in zonesRef"
                :key="index"
                class="flex-1 text-2xl font-semibold line-clamp-1 text-ellipsis whitespace-nowrap text-center py-4 rounded-t-3xl cursor-pointer"
                :class="{ 'dark:bg-gray-600 bg-gray-300': index == current }"
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
                v-for="(item, index) in zonesRef[current].tables"
                class="p-1 border-4 absolute"
                :class="{
                    'rounded-full': item.round != '0',

                    'border-green-500': item.status == 'فارغ',
                    'border-yellow-500': item.status == 'محجوز',
                    'border-red-500': item.status == 'مشغول',
                }"
                :style="`top:${item.y}%; left:${item.x}%; width:calc(${parseInt(
                    item.width
                )}% + 16px); height:calc(${parseInt(item.height)}% + 16px);`"
            >
                <Link
                    :key="index"
                    :href="route('table.show', item.id)"
                    class="flex items-center justify-center text-center w-full h-full"
                    :style="`color:${item.textcolor};background-color:${item.tablecolor};`"
                    :class="{
                        'rounded-full': item.round != '0',
                    }"
                >
                    {{ item.name }}
                </Link>
            </div>
        </div>
    </div>
    <p v-else class="mx-auto my-auto text-5xl font-semibold">لا يوجد مناطق</p>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";
const zonesRef = ref(props.zones);
onMounted(() => {
    window.Echo.channel(`channel-name`).listen("TableStatusChanged", (e) => {
        zonesRef.value = e.zones;
    });
});
const current = ref(0);
const props = defineProps({
    zones: Array,
});
</script>
