<template>
    <Filters @choose-table="toggle" :table_id="table_id" />
    <div class="overflow-auto">
        <table dir="rtl" class="mt-2 w-[200%] md:w-full text-center">
            <thead>
                <tr
                    class="border-b-4 border-gray-300 bg-gray-200 dark:bg-gray-700 dark:border-gray-600"
                >
                    <th class="md:px-6 py-3">#</th>
                    <th class="md:px-6 py-3">التاريخ</th>
                    <th class="md:px-6 py-3">الطلب</th>
                    <th class="md:px-6 py-3">السعر الكلي</th>
                    <th class="md:px-6 py-3">الطاولة</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-if="orders.data.length == 0"
                    class="border-b-2 border-gray-300 bg-transparent dark:border-gray-600"
                >
                    <td
                        class="md:px-6 py-3 text-3xl font-bold text-center"
                        colspan="5"
                    >
                        لا يوجد طلبات
                    </td>
                </tr>
                <tr
                    v-for="(item, index) in orders.data"
                    :key="index"
                    class="border-b-2 border-gray-300 dark:border-gray-600"
                >
                    <td class="md:px-6 py-3">{{ item.id }}</td>
                    <td class="md:px-6 py-3">{{ item.created_at }}</td>
                    <td class="flex flex-col gap-1 md:px-6 py-3">
                        <div
                            v-for="(x, index) in JSON.parse(item.order)"
                            :key="index"
                            class="flex gap-1 justify-between"
                        >
                            <p class="line-clamp-1 text-ellipsis">
                                {{ x.amount }} x
                            </p>
                            <p class="line-clamp-1 text-ellipsis">
                                {{ x.name }}
                            </p>
                            <p class="line-clamp-1 text-ellipsis">
                                {{ x.price }} ج.م
                            </p>
                        </div>
                    </td>
                    <td class="md:px-6 py-3">{{ item.total_price }} ج.م</td>
                    <td class="md:px-6 py-3">{{ item.table.name }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <PagingLinks v-if="orders.links.length > 3" :links="orders.links" />
    <ChooseTableModal
        :zones="zones"
        :show="show"
        @close="toggle"
        @chosen="chooseTable"
    />
</template>
<script setup>
import Filters from "@/Pages/Orders/Components/Filters.vue";
import ChooseTableModal from "@/Pages/Orders/Components/ChooseTableModal.vue";
import { ref } from "vue";
import PagingLinks from "@/Components/PagingLinks.vue";
const table_id = ref(null);
const show = ref(false);
const toggle = () => {
    show.value = !show.value;
};
const chooseTable = (id) => {
    table_id.value = id;
    toggle();
};
defineProps({
    orders: Object,
    zones: Array,
});
</script>
