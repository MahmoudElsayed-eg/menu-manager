<template>
    <div class="flex flex-col gap-10 items-center py-10">
        <div class="w-full px-6">
            <Link :href="route('admin.service.index')" class="btn-primary"
                >الرجوع الى الخدمات</Link
            >
        </div>
        <h1 class="text-xl font-bold">إضافة خدمة</h1>
        <form
            dir="rtl"
            @submit.prevent="submit"
            class="flex-col gap-4 flex items-center justify-center"
        >
            <label for="name">الاسم</label>
            <input
                class="input"
                type="text"
                name=""
                id="name"
                v-model="form.name"
            />
            <div v-if="form.errors.name" class="text-red-400">
                {{ form.errors.name }}
            </div>

            <label for="percent">النسبة</label>
            <input
                class="input"
                type="number"
                min="0"
                max="100"
                id="percent"
                v-model="form.percent"
            />
            <div v-if="form.errors.percent" class="text-red-400">
                {{ form.errors.percent }}
            </div>

            <label for="mainBarcode">الباركود الأساسي</label>
            <div class="flex gap-4">
                <input
                    type="text"
                    class="input"
                    id="mainBarcode"
                    v-model="form.mainBarcode"
                />
                <button
                    type="button"
                    @click="searchBarcode"
                    class="btn-primary"
                >
                    بحث
                </button>
            </div>
            <div v-if="form.errors.mainBarcode" class="text-red-400">
                {{ form.errors.mainBarcode }}
            </div>

            <div
                v-if="searched && form.item"
                dir="rtl"
                class="flex flex-row gap-2 border-2 border-gray-400 rounded-lg p-4 justify-evenly items-center w-full"
            >
                <p>
                    {{ form.item?.a_name }}
                </p>

                <p>{{ form.item?.sell_price }} جنيه</p>
            </div>
            <div
                v-if="searched && !form.item"
                dir="rtl"
                class="flex flex-row gap-2 border-2 border-gray-400 rounded-lg p-4 justify-evenly items-center w-full"
            >
                الباركود غير موجود
            </div>



            <input
                class="btn-green cursor-pointer"
                type="submit"
                name=""
                id=""
                value="إضافة"
            />
        </form>
    </div>
</template>
<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
const searched = ref(false);
const form = useForm({
    name: null,
    percent: null,
    mainBarcode: null,
    mainBarcodeSellprice: null,
    item: null,
});
const searchBarcode = () => {
    if (form.mainBarcode) {
        searched.value = true;
        window.axios
            .post(route("admin.item.search", form.mainBarcode))
            .then((response) => {
                form.item = response.data.item;
                form.mainBarcodeSellprice = form.item.sell_price;
            })
            .catch((err) => console.log(err));
    }
};
const submit = () => form.post(route("admin.service.store"));
</script>
