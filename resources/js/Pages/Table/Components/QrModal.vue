<template>
    <AdminModal :show="show" @close="$emit('close')">
        <div class="w-full" v-if="arr.length > 0">
            <Carousel>
                <Slide v-for="(item, index) in arr" :key="index">
                    <div class="p-2 bg-white mx-auto w-fit">
                        <qrcode-vue
                            :value="item"
                            :size="250"
                            level="H"
                        />
                    </div>
                </Slide>

                <template #addons>
                    <Navigation v-if="arr.length > 1" />
                    <Pagination v-if="arr.length > 1" />
                </template>
            </Carousel>
        </div>

        <div
            class="py-2 flex flex-col items-center gap-2 max-h-80 overflow-y-auto"
        >
            <select
                class="input"
                v-for="(item, index) in services"
                :key="index"
                name=""
                id=""
                v-model="item.value"
                @change="$emit('service', services)"
            >
                <option value="0">بدون خدمة</option>
                <option v-for="(i, j) in servicesArr" :key="j" :value="i.id">
                    {{ i.name }}
                </option>
            </select>
            <div class="flex justify-center gap-2">
                <button class="btn-danger" @click="removeService">-</button>
                <button class="btn-green" @click="addService">+</button>
            </div>
        </div>

        <template #footer>
            <div dir="rtl" class="flex flex-row justify-around">
                <button class="btn-green" @click="$emit('finishOrder')">
                    تأكيد
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
import QrcodeVue from "qrcode.vue";
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";
import { watch } from "vue";
import { ref } from "vue";
import "vue3-carousel/dist/carousel.css";
const services = ref([ref(0)]);
const addService = () => {
    services.value.push(ref(0));
};
const removeService = () => {
    if (services.value.length > 1) {
        services.value.pop();
        emits("service", services.value);
    }
};
const props = defineProps({
    show: Boolean,
    qr: String,
    servicesArr: Array,
});
const arr = ref([]);
watch(
    () => props.qr,
    (v) => {
        arr.value = [];
        const splitArr = v.split("\r\n");
        const b = Math.ceil(splitArr.length / 20);
        for (let index = 0; index < b; index++) {
            let a = index * 20;
            arr.value.push(splitArr.slice(a, 20 + a).join("\r\n"));
        }
    }
);
const emits = defineEmits(["close", "finishOrder", "service"]);
</script>

