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
                        <img
                            v-if="x == 'pic' && item[x] != null"
                            :src="'/storage/' + item[x]"
                            alt=""
                            class="h-32 !w-32 mx-auto"
                        />
                        <p v-else-if="x.search('id') != -1">
                            {{ item[x.replace("_id", "")].name }}
                        </p>
                        <p v-else-if="x == 'a_name'">
                            {{ data2.find((r)=>r.barcode.trim()==item.barcode).a_name }}
                        </p>
                        <button
                            v-else-if="x == 'photos'"
                            class="btn-yellow"
                            @click="$emit('photos', item.id)"
                        >
                            الصور
                        </button>
                        <p v-else>{{ item[x] ?? "لا يوجد" }}</p>
                    </td>

                    <td class="md:px-6 py-3">
                        <button
                            class="button-edit"
                            @click="$emit('edit', item.id, item.position)"
                        >
                            تعديل
                        </button>
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
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
defineEmits(["delete", "edit", "photos", "restore"]);
defineProps({
    titleStr: String,
    heads: Array,
    tables: Array,
    data: Object,
    data2: Array,
    routeString: String,
});
</script>
