<template>
    <Head title="التقارير" />
    <form
        @submit.prevent="submit"
        class="flex flex-col md:flex-row md:flex-wrap gap-1 items-center"
    >
        <div class="flex flex-col gap-1 justify-center items-center">
            <label for="date">التاريخ</label>
            <input
                type="date"
                name=""
                id="date"
                v-model="form.date"
                class="input"
            />
        </div>

        <div class="flex flex-col gap-1 justify-center items-center">
            <label for="username">المستخدم</label>
            <input
                type="text"
                name=""
                id="username"
                v-model="form.username"
                class="input"
            />
        </div>

        <div class="flex gap-1 md:flex-row-reverse items-center px-3">
            <button type="reset" @click="reset" class="btn-danger">
                إعادة
            </button>
            <button type="submit" class="btn-green">بحث</button>
        </div>
    </form>

    <div class="overflow-auto">
        <table dir="rtl" class="mt-2 w-[200%] md:w-full text-center">
            <thead>
                <tr
                    class="border-b-4 border-gray-300 bg-gray-200 dark:bg-gray-700 dark:border-gray-600"
                >
                    <th class="md:px-6 py-3">#</th>
                    <th class="md:px-6 py-3">التاريخ</th>
                    <th class="md:px-6 py-3">المستخدم</th>
                    <th class="md:px-6 py-3">التقرير</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-if="reports.data.length == 0"
                    class="border-b-2 border-gray-300 bg-transparent dark:border-gray-600"
                >
                    <td
                        class="md:px-6 py-3 text-3xl font-bold text-center"
                        colspan="4"
                    >
                        لا يوجد تقارير
                    </td>
                </tr>
                <tr
                    v-for="(item, index) in reports.data"
                    :key="index"
                    class="border-b-2 border-gray-300 dark:border-gray-600"
                >
                    <td class="md:px-6 py-3">{{ item.id }}</td>
                    <td class="md:px-6 py-3">{{ item.created_at }}</td>
                    <td class="md:px-6 py-3">{{ item.username }}</td>
                    <td class="md:px-6 py-3">{{ item.report }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <PagingLinks v-if="reports.links.length > 3" :links="reports.links" />
</template>
<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import PagingLinks from "@/Components/PagingLinks.vue";

defineProps({
    reports: Object,
});

const form = useForm({
    username: null,
    date: null,
});

const submit = () =>
    form.get(route("admin.report.index"), {
        preserveScroll: true,
        preserveState: true,
    });

const reset = () => {
    form.username = null;
    form.date = null;
    submit();
};
</script>
