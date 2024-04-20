<template>
    <div class="flex flex-col-reverse md:flex-row flex-1 overflow-auto">
        <div
            class="border-2 border-gray-300 dark:border-gray-600 flex flex-col w-full md:w-2/3 h-2/3 md:h-full overflow-auto"
        >
            <h2
                class="text-center p-2 font-semibold text-xl border-b-2 border-gray-300 dark:border-gray-600"
            >
                الـطـلـب
            </h2>
            <div class="flex-1 overflow-auto">
                <TableDataItem
                    v-for="(item, index) in tableData"
                    :key="index"
                    :item="item"
                    @delete="$emit('openDelete', item)"
                    @increase="$emit('increase', item)"
                    @decrease="$emit('decrease', item)"
                />
            </div>
            <div
                class="flex items-center justify-center gap-1 p-2 border-t-2 border-gray-300 dark:border-gray-600"
            >
                <p>السعر الكـلـي :</p>
                <p>
                    {{ totalPrice.toFixed(2) }}
                </p>
                <p>ج.م</p>
            </div>
        </div>
        <div
            class="border-2 border-gray-300 dark:border-gray-600 flex flex-col w-full md:w-1/3 flex-1 overflow-auto"
        >
            <h2
                class="text-center p-2 font-semibold text-xl border-b-2 border-gray-300 dark:border-gray-600"
            >
                الأكـثر طلـبا
            </h2>
            <div class="overflow-auto">
                <MostOrderedItem
                    v-for="(item, index) in mostOrdered"
                    :key="index"
                    :item="item"
                    @clicked="$emit('openMostOrdered', item)"
                />
            </div>
        </div>
    </div>
</template>
<script setup>
import MostOrderedItem from "@/Pages/Table/Components/MostOrderedItem.vue";
import TableDataItem from "@/Pages/Table/Components/TableDataItem.vue";
defineProps({
    mostOrdered: Array,
    tableData: Array,
    totalPrice: Number,
});
defineEmits(["openMostOrdered", "openDelete", "increase", "decrease"]);
</script>
