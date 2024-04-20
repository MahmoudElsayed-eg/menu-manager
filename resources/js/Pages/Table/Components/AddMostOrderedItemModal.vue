<template>
    <AdminModal :show="show" @close="$emit('close')">
        <div class="w-full" v-if="images.length > 0">
            <Carousel :wrap-around="true">
                <Slide v-for="(item, index) in images" :key="index">
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
        <div v-if="loading" class="flex flex-row gap-5 p-2 justify-center">
            <div
                v-for="item in 5"
                :key="item"
                class="inline-block h-8 w-8 animate-[spinner-grow_0.75s_linear_infinite] rounded-full bg-current align-[-0.125em] text-gray-300 opacity-0 motion-reduce:animate-[spinner-grow_1.5s_linear_infinite]"
                role="status"
            >
                <span
                    class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
                    >Loading...</span
                >
            </div>
        </div>
        <div dir="rtl" class="flex flex-col gap-1 items-center">
            <p class="line-clamp-2 text-ellipsis text-center">
                {{ item?.a_name }}
            </p>
            <div class="flex flex-row gap-1 items-center justify-center">
                <label for="amount">الكمية : </label>

                <button class="w-7 h-7 bg-green-500 dark:bg-green-700 rounded-md flex items-center justify-center" @click="amount++">+</button>
                <input
                    type="number"
                    id="amount"
                    v-model="amount"
                    class="dark:bg-gray-600 dark:text-gray-300 dark:placeholder:text-gray-400 w-24 rounded-md"
                    min="1"
                />

                <button class="w-7 h-7 bg-red-500 dark:bg-red-700 rounded-md flex items-center justify-center" @click="minus">-</button>
            </div>
        </div>
        <template #footer>
            <div dir="rtl" class="flex flex-row justify-around">
                <button
                    class="btn-green"
                    @click="
                        $emit('add', amount, images);
                        amount = 1;
                    "
                >
                    إضافة
                </button>
                <button class="btn-primary" @click="$emit('close')">
                    الغاء
                </button>
            </div>
        </template>
    </AdminModal>
</template>
<script setup>
import AdminModal from "@/Components/AdminModal.vue";
import { watch } from "vue";
import { ref } from "vue";
import { Carousel, Slide, Navigation } from "vue3-carousel";
import "vue3-carousel/dist/carousel.css";
const amount = ref(1);
const images = ref([]);
const loading = ref(false);
const minus = () => {
    if (amount.value != 1) {
        amount.value--;
    }
};
watch(
    () => props.item,
    (val, pre) => {
        if (val != pre) {
            images.value = [];
            loading.value = true;
            window.axios
                .post(route("item.images", props.item.barcode))
                .then((response) => {
                    loading.value = false;
                    images.value = response.data.images;
                })
                .catch((err) => {
                    loading.value = false;
                });
        }
    }
);


const props = defineProps({
    show: Boolean,
    item: Object,
});
defineEmits(["close", "add"]);
</script>
