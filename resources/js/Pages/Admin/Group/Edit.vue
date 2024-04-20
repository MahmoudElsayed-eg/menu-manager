<template>
    <div class="flex flex-col gap-10 items-center py-10">
        <div class="w-full px-6">
            <Link :href="route('admin.print_group.index')" class="btn-primary"
                >الرجوع الى المجموعات</Link
            >
        </div>
        <h1 class="text-xl font-bold">تعديل مجموعة</h1>
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
import { Link, useForm } from "@inertiajs/vue3";
const form = useForm({
    name: props.group.name ?? null,
});
const props = defineProps({
    group : Object
})
const submit = () => form.put(route("admin.print_group.update",props.group.id));

</script>
