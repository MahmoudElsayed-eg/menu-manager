<template>
    <div
        class="border-2 border-gray-300 dark:border-gray-600 p-2 items-center justify-evenly flex flex-row"
    >
        <button
            v-if="tableData.length != 0 && user && (user.is_cashier == '1' || user.is_admin == '1')"
            class="btn-green"
            @click="$emit('submitOrder')"
        >
            انهاء الطلب
        </button>
        <Link
            :href="route('table.select_item', table_id)"
            class="p-3 bg-yellow-300 hover:bg-yellow-400 dark:hover:bg-yellow-700 dark:bg-yellow-600 rounded-full w-[60px] flex items-center justify-center font-extrabold text-3xl"
            >+</Link
        >
        <button
            v-if="tableData.length != 0"
            class="btn-primary"
            @click="$emit('changeTable')"
        >
            نقل الطاولة
        </button>
    </div>
</template>
<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
const page = usePage();
const user = computed(() => page.props.user);
defineProps({
    tableData: Array,
    table_id: Number,
});
defineEmits(["submitOrder", "changeTable"]);
</script>
