<template>
<AdminModal :show="show" @close="$emit('close')">
    <h1 class="text-center font-bold text-3xl py-2">
            انت على وشك مسح المنتج هل انت متأكد ؟
        </h1>
        <template #footer>
            <div dir="rtl" class="flex flex-row justify-around">
                <button
                    class="btn-danger"
                    @click="$emit('deleted',item)"
                    >تأكيد</button
                >
                <button class="btn-primary" @click="$emit('close')">
                    الغاء
                </button>
            </div>
        </template>
</AdminModal>
</template>
<script setup>
import AdminModal from '@/Components/AdminModal.vue';
defineProps({
    show:Boolean,
    item:Object,
})
defineEmits(['close','deleted'])
</script>