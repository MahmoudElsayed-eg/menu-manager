<template>
    <AdminModal :show="show" @close="$emit('close')">
        <div v-if="loading" class="flex flex-row gap-5 justify-center">
            <div
                v-for="(item, index) in 5"
                :key="index"
                class="inline-block h-8 w-8 animate-[spinner-grow_0.75s_linear_infinite] rounded-full bg-current align-[-0.125em] text-gray-500 opacity-0 motion-reduce:animate-[spinner-grow_1.5s_linear_infinite]"
                role="status"
            >
                <span
                    class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
                    >Loading...</span
                >
            </div>
        </div>

        <form
            v-else
            @submit.prevent="submit"
            class="flex flex-col justify-center items-center gap-3 p-6"
        >
            <label for="barcode">الباركود</label>
            <input
                type="text"
                name=""
                id="barcode"
                class="input"
                v-model="form.barcode"
            />
            <button type="submit" class="btn-green">بحث</button>
        </form>
        <ProductItem v-if="item" :item="item" @add="addToCategory" />
        <div v-if="error" class="text-red-500 text-center">
            {{ error }}
        </div>
        <template #footer>
            <div dir="rtl" class="flex flex-row justify-around">
                <button class="btn-primary" @click="$emit('close')">
                    الغاء
                </button>
            </div>
        </template>
    </AdminModal>
</template>
<script setup>
import AdminModal from "@/Components/AdminModal.vue";
import { Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import ProductItem from "./ProductItem.vue";
const item = ref(null);
const form = useForm({
    id:props.idRef,
    barcode: null,
    position:0,
});
const loading = ref(false);
const error = ref(null);
const addToCategory = (position) => {
    form.position = position;
    form.post(route('admin.categoryData.store'))
    emits('close');
}
const submit = () => {
    if (form.barcode) {
        item.value = null;
        loading.value = true;
        error.value = null;
        window.axios
            .post(route("admin.item.search", form.barcode),{},{withCredentials:true})
            .then((response) => {
                loading.value = false;
                item.value = response.data.item;
                if (!item.value) {
                    error.value = "الباركود خاطئ";
                }
            })
            .catch((er) => {
                loading.value = false;
                error.value = "خطأ بالاتصال بالانترنت حاول مرة أخرى";
            });
    } else {
        error.value = "الباركود مطلوب";
    }

    // form.post(route('admin.item.search'),{onSuccess:(response)=>{
    //     console.log(response);
    // }});
};
const emits =defineEmits(["close"]);
const props =defineProps({
    titleStr: String,
    idRef: Number,
    routeString: String,
    show: Boolean,
});
</script>
