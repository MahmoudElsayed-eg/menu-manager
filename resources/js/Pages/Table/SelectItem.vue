<template>
    <div dir="rtl" class="flex flex-col gap-2 h-full p-2 md:p-5">
        <div
            class="flex-1 flex overflow-auto border-2 border-gray-300 dark:border-gray-600"
        >
            <div
                class="flex flex-row gap-5 items-center justify-center p-2 md:p-5 flex-wrap w-full justify-self-center"
            >
                <Link
                    :href="
                        route('table.select_item.category', [table.id, item.id])
                    "
                    v-for="(item, index) in categories"
                    :key="index"
                    class="w-2/5 md:w-1/4 py-2 flex flex-col items-center justify-center rounded-2xl bg-gray-300 dark:bg-gray-600"
                >
                    <div class="p-2 md:p-5 w-full h-28 md:h-40 lg:h-64">
                        <img
                            :src="
                                item.pic
                                    ? '/storage/' + item.pic
                                    : '/storage/images/placeholder.jpg'
                            "
                            alt=""
                            class="w-full h-full border-4 rounded-lg border-gray-400 dark:border-gray-700"
                        />
                    </div>
                    <p class="line-clamp-2 text-ellipsis text-center px-4 h-12">
                        {{ item.name }}
                    </p>
                </Link>
              
            </div>
        </div>
        <Link
            class="btn-danger w-fit mx-auto"
            :href="route('table.show', table.id)"
        >
            إلغاء
        </Link>
    </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    categories: Array,
    table: Object,
});
</script>
