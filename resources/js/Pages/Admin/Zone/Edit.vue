<template>
    <div class="flex flex-col gap-10 items-center py-10">
        <div class="w-full px-6">
            <Link :href="route('admin.zone.index')" class="btn-primary"
                >الرجوع الى المناطق</Link
            >
        </div>
        <h1 class="text-xl font-bold">تعديل منطقة</h1>
        <form
            @submit.prevent="submit"
            dir="rtl"
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
                value="تعديل"
            />
        </form>
    </div>
</template>
<script setup>
import { useForm, Link } from "@inertiajs/vue3";
const props = defineProps({
    zone: Object,
});
const form = useForm({
    name: props.zone.name ?? null,
    position: props.zone.position ?? null,
});
const submit = () => form.put(route("admin.zone.update", props.zone.id));
</script>
