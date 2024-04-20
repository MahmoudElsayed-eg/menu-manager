<template>
    <AdminModal :show="show" @close="$emit('close')">
        <div class="w-full" v-if="pics.length > 0">
            <Carousel :wrap-around="true">
                <Slide v-for="(item, index) in pics" :key="index">
                    <div
                        class="flex flex-col gap-2 items-center justify-center"
                    >
                        <img
                            :src="'/storage/' + item.pic"
                            alt=""
                            class="w-72 h-72"
                        />
                    </div>
                </Slide>

                <template #addons>
                    <Navigation />
                </template>
            </Carousel>
        </div>
        <div dir="rtl" class="flex flex-col gap-1 items-center">
            <p class="line-clamp-2 text-ellipsis text-center">
                {{ item?.a_name }}
            </p>
            <div class="flex flex-row gap-1 items-center justify-center">
                <label for="amount">الكمية : </label>

                <button
                    class="w-7 h-7 bg-green-500 dark:bg-green-700 rounded-md flex items-center justify-center"
                    @click="form.amount++"
                >
                    +
                </button>
                <input
                    type="number"
                    id="amount"
                    v-model="form.amount"
                    class="dark:bg-gray-600 dark:text-gray-300 dark:placeholder:text-gray-400 w-24 rounded-md"
                    min="1"
                />

                <button
                    class="w-7 h-7 bg-red-500 dark:bg-red-700 rounded-md flex items-center justify-center"
                    @click="minus"
                >
                    -
                </button>
            </div>
        </div>
        <template #footer>
            <div dir="rtl" class="flex flex-row justify-around">
                <button class="btn-green" @click="submit">إضافة</button>
                <button class="btn-primary" @click="$emit('close')">
                    الغاء
                </button>
            </div>
        </template>
    </AdminModal>
</template>
<script setup>
import AdminModal from "@/Components/AdminModal.vue";
import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { Carousel, Slide, Navigation } from "vue3-carousel";
import "vue3-carousel/dist/carousel.css";
const form = useForm({
    amount: 1,
    table_id: props.table_id,
    barcode: props.item?.barcode.trim(),
});
const submit = () => {
    form.post(route("tableData.store"));
};
const minus = () => {
    if (form.amount != 1) {
        form.amount--;
    }
};
watch(
    () => props.item,
    (val, pre) => {
        form.barcode = val.barcode.trim();
    }
);

const props = defineProps({
    show: Boolean,
    item: Object,
    pics: Array,
    table_id: Number,
});
defineEmits(["close", "add"]);
</script>
