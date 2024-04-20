<template>
    <div class="flex flex-col gap-10 items-center py-10">
        <div class="w-full px-6">
            <Link :href="route('admin.zone.index')" class="btn-primary">الرجوع الى المناطق</Link>
        </div>
        <h1 class="text-xl font-bold">إضافة منطقة</h1>
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
});
const submit = () => form.post(route("admin.zone.store"));
</script>
