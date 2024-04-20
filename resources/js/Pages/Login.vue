<template>
    <div
        class="flex-1 overflow-auto flex flex-col gap-2 justify-center items-center"
    >
        <img src="\storage\images\logo.webp" class="h-1/2" alt="" />
        <form
            @submit.prevent="submit"
            action=""
            class="flex flex-col gap-2 items-center justify-center"
        >
            <label for="name">اسم المستخدم</label>
            <input type="text" id="name" class="input" v-model="form.name" />
            <div v-if="form.errors.name" class="text-red-500">
                {{ form.errors.name }}
            </div>
            <label for="password">كلمة المرور</label>
            <div class="relative">
                <input
                    type="password"
                    name=""
                    id="password"
                    v-model="form.password"
                    class="input"
                />
                <svg
                    v-if="!shown"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 absolute cursor-pointer"
                    style="top: 9px; right: 7px"
                    @click="showPass"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                    />
                </svg>
                <svg
                    v-else
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-6 h-6 absolute cursor-pointer"
                    style="top: 9px; right: 7px"
                    @click="showPass"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"
                    />
                </svg>
            </div>
            <div v-if="form.errors.password" class="text-red-500">
                {{ form.errors.password }}
            </div>
            <button class="btn-green mt-2">دخول</button>
        </form>
    </div>
</template>
<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
const shown = ref(false);
const form = useForm({
    name: null,
    password: null,
});
const showPass = () => {
    shown.value = !shown.value;
    if (shown.value) {
        document.getElementById("password").type = "text";
    } else {
        document.getElementById("password").type = "password";
    }
};
const submit = () => form.post(route("auth.store"));
</script>
