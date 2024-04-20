<template>
    <AdminModal :show="show" @close="$emit('close')">
        <form class="flex-col flex gap-4 items-center justify-center">
            <label for="position">الترتيب</label>
            <input
                type="number"
                name=""
                id="position"
                v-model="form.position"
                min="0"
                class="input"
            />
            <div v-if="form.errors.position" class="text-red-400">
                {{ form.errors.position }}
            </div>
        </form>
        <template #footer>
            <div dir="rtl" class="flex flex-row justify-around">
                <button class="btn-green" @click="submit">تأكيد</button>
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
import { watch } from "vue";
const submit = () => {
    form.put(route("admin.categoryData.update", props.idRef));
    emits("close");
};
const form = useForm({
    position: null,
});
watch(()=>props.position,(val)=>{
    form.position = val
})
const emits = defineEmits(["close"]);
const props = defineProps({
    idRef: Number,
    position: Number,
    show: Boolean,
});
</script>
