<template>
    <div class="flex flex-col gap-10 items-center py-10">
        <div class="w-full px-6">
            <Link :href="route('admin.category.index')" class="btn-primary"
                >الرجوع الى الأصناف</Link
            >
        </div>
        <h1 class="text-xl font-bold">إضافة صنف</h1>
        <form
            dir="rtl"
            @submit.prevent="submit"
            class="flex-col gap-4 flex items-center justify-center"
            enctype="multipart/form-data"
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
            <label for="group_id">المجموعة</label>
            <select class="input" name="" id="group_id" v-model="form.print_group_id">
                <option value="0" disabled>اختار المجموعة</option>
                <option
                    v-for="(item, index) in groups"
                    :key="index"
                    :value="item.id"
                >
                    {{ item.name }}
                </option>
            </select>
            <label for="position">الترتيب</label>
            <input
                class="input"
                type="number"
                id="position"
                v-model="form.position"
            />
            <div v-if="form.errors.position" class="text-red-400">
                {{ form.errors.position }}
            </div>
            <label for="pic">الصورة</label>
            <input type="file" name="" id="" @input="insertPic" class="input" />
            <div v-if="form.errors.pic" class="text-red-400">
                {{ form.errors.pic }}
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
const form = useForm({
    name: null,
    position: null,
    pic: null,
    print_group_id:0
});
defineProps({
    groups:Array
})
const insertPic = (event) => {
    form.pic = event.target.files[0];
};
const submit = () => form.post(route("admin.category.store"));
</script>
