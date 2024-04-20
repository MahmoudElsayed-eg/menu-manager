<template>
    <AdminModal :show="show" @close="$emit('close')">
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
            <label for="numChairs">عدد الكراسي</label>
            <input
                class="input"
                type="number"
                id="numChairs"
                v-model="form.numChairs"
            />
            <div v-if="form.errors.numChairs" class="text-red-400">
                {{ form.errors.numChairs }}
            </div>
        </form>
        <template #footer>
            <div dir="rtl" class="flex flex-row justify-around">
                <button
                    type="submit"
                    class="btn-green"
                    @click="
                        submit();
                        $emit('close');
                    "
                >
                    إضافة
                </button>

                <button class="btn-primary" @click="$emit('close')">
                    الغاء
                </button>
            </div>
        </template>
    </AdminModal>
</template>
<script setup>
import AdminModal from "@/Components/AdminModal.vue";
import { useForm } from "@inertiajs/vue3";
const form = useForm({
    name: null,
    zone_id: props.zone_id,
    numChairs: null,
});
const submit = () => form.post(route("admin.table.store"));
const props = defineProps({
    zone_id: Number,
    show: Boolean,
});
defineEmits(["close"]);
</script>
