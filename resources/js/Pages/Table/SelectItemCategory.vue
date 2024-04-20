<template>
    <div dir="rtl" class="flex flex-col gap-2 h-full p-2 md:p-5">
        <div
            class="flex-1 flex overflow-auto border-2 border-gray-300 dark:border-gray-600"
        >
            <div
                class="flex flex-row gap-5 items-center justify-center p-2 md:p-5 flex-wrap w-full justify-self-center"
            >
                <button
                    @click="
                        table_data = retail_data.find(
                            (e) => e.barcode.trim() == item.barcode
                        );
                        pics = item.pics;
                        toggle();
                    "
                    :href="
                        route('table.select_item.category', [table.id, item.id])
                    "
                    v-for="(item, index) in data"
                    :key="index"
                    class="w-2/5 md:w-1/4 py-2 flex flex-col items-center justify-center rounded-2xl bg-gray-300 dark:bg-gray-600"
                >
                    <div class="p-2 md:p-5 w-full h-28 md:h-40 lg:h-64">
                        <img
                            :src="
                                item.pics.length > 0
                                    ? '/storage/' + item.pics[0].pic
                                    : '/storage/images/placeholder.jpg'
                            "
                            alt=""
                            class="w-full h-full border-4 rounded-lg border-gray-400 dark:border-gray-700"
                        />
                    </div>
                    <p class="line-clamp-2 text-ellipsis text-center px-4">
                        {{
                            retail_data.find(
                                (e) => e.barcode.trim() == item.barcode
                            ).a_name
                        }}
                    </p>
                    <p
                        class="line-clamp-1 text-ellipsis w-full text-end px-4 text-[#538E8C] font-bold text-lg"
                    >
                        {{
                            parseFloat(
                                retail_data.find(
                                    (e) => e.barcode.trim() == item.barcode
                                ).sell_price
                            ).toFixed(2)
                        }}
                        ج.م
                    </p>
                </button>
            </div>
        </div>

        <div class="relative flex flex-row justify-center">
            <Link class="btn-danger" :href="route('table.show', table.id)">
                إلغاء
            </Link>
            <Link
                class="btn-green absolute left-0"
                :href="route('table.select_item', table.id)"
            >
                &larr;
            </Link>
        </div>
    </div>

    <AddTableItemModal
        :item="table_data"
        :show="show"
        :pics="pics"
        :table_id="table.id"
        @close="toggle"
    />
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import AddTableItemModal from "@/Pages/Table/Components/AddTableItemModal.vue";
const table_data = ref(null);
const pics = ref(null);
const show = ref(false);
const toggle = () => {
    show.value = !show.value;
};
defineProps({
    data: Array,
    retail_data: Array,
    table: Object,
});
</script>
