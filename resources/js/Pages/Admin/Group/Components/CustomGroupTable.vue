<template>
    <div class="overflow-auto">
        <table dir="rtl" class="w-[200%] md:w-full text-center">
            <thead>
                <tr
                    class="border-b-4 border-gray-300 bg-gray-200 dark:bg-gray-700 dark:border-gray-600"
                >
                    <th
                        class="md:px-6 py-3"
                        v-for="(item, index) in heads"
                        :key="index"
                    >
                        {{ item }}
                    </th>
                    <th class="md:px-6 py-3">تعديل</th>
                    <th class="md:px-6 py-3">مسح/استعادة</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-if="data.data.length == 0"
                    class="border-b-2 border-gray-300 bg-transparent dark:border-gray-600"
                >
                    <td
                        class="md:px-6 py-3 text-3xl font-bold text-center"
                        :colspan="heads.length + 2"
                    >
                        لا يوجد {{ titleStr }}
                    </td>
                </tr>
                <tr
                    v-for="(item, index) in data.data"
                    :key="index"
                    class="border-b-2 border-gray-300 dark:border-gray-600"
                    :class="
                        item.deleted_at
                            ? 'bg-red-300 dark:bg-red-900'
                            : 'bg-transparent'
                    "
                >
                    <td class="md:px-6 py-3" v-for="(x, i) in tables" :key="i">
                        <div v-if="x == 'categories'" class="flex flex-col gap-1">
                            <p v-if="item[x].length == 0">لا يوجد أصناف</p>
                            <p v-for="(q, j) in item[x]" :key="j">
                            {{ q.name }}
                            </p>
                        </div>
                        <p v-else>{{ item[x] }}</p>
                    </td>

                    <td class="md:px-6 py-3">
                        <Link
                            class="button-edit"
                            :href="route(routeString + '.edit', item.id)"
                            >تعديل</Link
                        >
                    </td>
                    <td class="md:px-6 py-3">
                        <button
                            :class="
                                !item.deleted_at ? 'btn-danger' : 'btn-green'
                            "
                            @click="
                                !item.deleted_at
                                    ? $emit('delete', item.id)
                                    : $emit('restore', item.id)
                            "
                            v-html="item.deleted_at ? 'استعادة' : 'مسح'"
                        ></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <PagingLinks v-if="data.links.length > 3" :links="data.links" />

</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import PagingLinks from "@/Components/PagingLinks.vue";

defineEmits(["delete", "restore"]);
defineProps({
    titleStr: String,
    heads: Array,
    tables: Array,
    data: Object,
    data2: Array,
    routeString: String,
});
</script>
