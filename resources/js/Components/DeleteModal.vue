<template>
    <AdminModal :show="show" @close="$emit('close')">
        <h1 class="text-center font-bold text-3xl py-2">
            انت على وشك مسح {{ titleStr }} هل انت متأكد ؟
        </h1>
        <template #footer>
            <div dir="rtl" class="flex flex-row justify-around">
                <Link
                    :href="route(routeString + '.destroy', idRef)"
                    method="delete"
                    as="button"
                    class="btn-danger"
                    @click="$emit('deleted')"
                    >تأكيد</Link
                >
                <button class="btn-primary" @click="$emit('close')">
                    الغاء
                </button>
            </div>
        </template>
    </AdminModal>
</template>
<script setup>
import AdminModal from "./AdminModal.vue";
import { Link } from "@inertiajs/vue3";
defineEmits(["close", "deleted"]);
defineProps({
    titleStr: String,
    idRef: Number,
    routeString: String,
    show: Boolean,
});
</script>
