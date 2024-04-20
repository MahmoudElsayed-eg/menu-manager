<template>
    <form
        @submit.prevent="submit"
        class="flex flex-col md:flex-row md:flex-wrap gap-1 items-center"
    >
        <div
            class="flex justify-between w-full md:w-fit md:gap-1 items-center px-3"
        >
            <Link :href="route('home')" class="btn-primary"> العودة </Link>
            <button
                type="button"
                class="button-edit"
                @click="$emit('chooseTable')"
            >
                اختار طاولة
            </button>
        </div>
        <input type="hidden" v-model="form.table_id" />

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
        <div class="flex gap-1">
            <div class="flex flex-col gap-1 justify-center items-center">
                <label for="to">السعر الى</label>
                <input
                    type="number"
                    step="0.1"
                    name=""
                    id="to"
                    v-model="form.to"
                    class="dark:bg-gray-600 dark:text-gray-300 dark:placeholder:text-gray-400 w-20 rounded-md"
                />
            </div>

            <div class="flex flex-col gap-1 justify-center items-center">
                <label for="from">السعر من</label>
                <input
                    type="number"
                    step="0.1"
                    name=""
                    id="from"
                    v-model="form.from"
                    class="dark:bg-gray-600 dark:text-gray-300 dark:placeholder:text-gray-400 w-20 rounded-md"
                />
            </div>
        </div>
        <div class="flex md:flex-col-reverse items-center justify-center gap-2">
            <label for="by">تصاعدي</label>
            <input type="checkbox" name="" id="by" v-model="form.by" />
        </div>
        <div class="flex gap-1 md:flex-row-reverse items-center px-3">
            <button type="reset" @click="reset" class="btn-danger">
                إعادة
            </button>
            <button type="submit" class="btn-green">بحث</button>
        </div>
    </form>
</template>
<script setup>
import { useForm, Link } from "@inertiajs/vue3";
import { watch } from "vue";
const form = useForm({
    table_id: null,
    date: null,
    from: null,
    to: null,
    by: false,
});
const submit = () => {
    form.get(route("orders.index"), {
        preserveScroll: true,
        preserveState: true,
    });
};
const reset = () => {
    form.table_id = null;
    form.date = null;
    form.from = null;
    form.to = null;
    form.by = false;
    submit();
};

const props = defineProps({
    table_id: Number,
});
watch(
    () => props.table_id,
    (val) => {
        if (val) {
            form.table_id = val;
            submit();
        }
    }
);

defineEmits(["chooseTable"]);
</script>
