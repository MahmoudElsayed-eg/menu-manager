<template>
    <div class="flex flex-col gap-10 items-center py-10">
        <div class="w-full px-6">
            <Link :href="route('admin.table.index')" class="btn-primary"
                >الرجوع الى الطاولات</Link
            >
        </div>
        <h1 class="text-xl font-bold">تعديل طاولة</h1>
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
            <label for="zone">المنطقة</label>
            <select v-model="form.zone_id" name="" id="zone" class="input">
                <option value="0">اختار المنطقة</option>
                <option
                    v-for="(item, index) in zones"
                    :key="index"
                    :value="item.id"
                >
                    {{ item.name }}
                </option>
            </select>

            <div v-if="form.errors.zone_id" class="text-red-400">
                {{ form.errors.zone_id }}
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
    table: Object,
    zones: Array,
});
const form = useForm({
    name: props.table.name ?? null,
    zone_id: props.table.zone_id ?? 0,
    numChairs: props.table.numChairs ?? null,
});
const submit = () => form.put(route("admin.table.update", props.table.id));
</script>
