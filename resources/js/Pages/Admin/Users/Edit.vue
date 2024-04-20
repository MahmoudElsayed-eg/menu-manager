<template>
    <div class="flex flex-col gap-10 items-center py-10">
        <div class="w-full px-6">
            <Link :href="route('admin.users.index')" class="btn-primary"
                >الرجوع الى المستخدمين</Link
            >
        </div>
        <h1 class="text-xl font-bold">تعديل مستخدم</h1>
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
            <label for="password">كلمة المرور</label>
            <input
                class="input"
                type="password"
                id="password"
                v-model="form.password"
            />
            <div v-if="form.errors.password" class="text-red-400">
                {{ form.errors.password }}
            </div>

            <div class="flex flex-row gap-2 items-center justify-center">
                <input type="checkbox" id="cashier" v-model="form.is_cashier" />
                <label for="cashier">كاشير</label>
            </div>

            <div class="flex flex-row gap-2 items-center justify-center">
                <input type="checkbox" id="manager" v-model="form.is_manager" />
                <label for="manager">مدير</label>
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
const props = defineProps({
    user: Object,
});
const form = useForm({
    name: props.user.name ?? null,
    password: null,
    is_cashier: props.user.is_cashier == '1' ?? false,
    is_manager: props.user.is_manager == '1' ?? false,
});
const submit = () => form.put(route("admin.users.update", props.user.id));
</script>
