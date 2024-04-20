<template>
    <div class="flex flex-col items-center justify-center p-5 md:p-10 gap-4">
        <img :src="img" alt="" class="w-36 h-36" />
        <form enctype="multipart/form-data" @submit.prevent="submit" class="flex flex-col gap-4 items-center justify-center">
            <label for="img">الصورة الجديدة</label>
            <input type="file" name="" id="img" @input="addPic" />
            <div v-if="form.errors.pic" class="text-red-300">
                {{ form.errors.pic }}
            </div>
            <button type="submit" class="btn-primary">تحديث</button>
        </form>
    </div>
</template>
<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { watch } from "vue";
import { ref } from "vue";
const page = usePage();
const time = computed(() => page.props.flash.time);
const form = useForm({
    pic: null,
});
const img = ref("/storage/images/placeholder.jpg?q=");
watch(time, (val) => {
    img.value += "1";
});
const addPic = (event) => {
    form.pic = event.target.files[0];
};
const submit = () => {
    form.post(route("admin.placeholder_img.store"));
};
</script>
