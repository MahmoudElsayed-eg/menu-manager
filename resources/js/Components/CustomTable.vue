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
                    <th v-if="show" class="md:px-6 py-3">عرض</th>
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
                        :colspan="show ? heads.length + 3 : heads.length + 2"
                    >
                        لا يوجد {{ titleStr }}
                    </td>
                </tr>
                <tr
                    v-for="(item, index) in data.data"
                    :key="index"
                    :class="
                        item.deleted_at
                            ? 'bg-red-300 dark:bg-red-900'
                            : 'bg-transparent'
                    "
                    class="border-b-2 border-gray-300 dark:border-gray-600"
                >
                    <td class="md:px-6 py-3" v-for="(x, i) in tables" :key="i">
                        <img
                            v-if="x == 'pic' && item[x] != null"
                            :src="'/storage/' + item[x]"
                            alt=""
                            class="h-32 !w-32 mx-auto"
                        />
                        <p v-else-if="x.search('id') != -1">
                            {{ item[x.replace("_id", "")].name }}
                        </p>
                        <p
                            class="text-xl"
                            v-else-if="x == 'admin'"
                            v-html="item[x] == 1 ? '&#9745' : '&#9746'"
                        ></p>
                        <p v-else-if="x.startsWith('is_')" :class="item[x] == '1' ? 'text-green-500':'text-red-500'">
                            {{ item[x] == '1' ? '&#10003;' : '&#10008;'}}
                        </p>
                        <p v-else>{{ item[x] ?? 'لا يوجد' }}</p>
                    </td>
                    <td v-if="show" class="md:px-6 py-3">
                        <Link
                        v-if="!item.deleted_at"
                            class="btn-primary"
                            :href="route(routeString + '.show', item.id)"
                            >عرض</Link
                        >
                        <p v-else>--</p>
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
import PagingLinks from "./PagingLinks.vue";
defineEmits(["delete", "restore"]);
defineProps({
    titleStr: String,
    heads: Array,
    tables: Array,
    data: Object,
    routeString: String,
    show: {
        type: Boolean,
        default: false,
    },
});
</script>
