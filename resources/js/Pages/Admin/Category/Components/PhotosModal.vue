<template>
    <AdminModal :show="show" @close="$emit('close')">
        <div class="w-full" v-if="images.length > 0">
            <Carousel :wrap-around="true">
                <Slide v-for="(item, index) in images" :key="index">
                    <div
                        class="flex flex-col gap-2 items-center justify-center"
                    >
                        <img
                            :src="'/storage/' + item.pic"
                            alt=""
                            class="w-36 h-36"
                        />
                        <Link
                            as="button"
                            method="delete"
                            :href="route('admin.item_images.destroy', item.id)"
                            class="btn-danger"
                            @click="$emit('close')"
                            >مسح</Link
                        >
                    </div>
                </Slide>

                <template #addons>
                    <Navigation />
                </template>
            </Carousel>
        </div>

        <form
            v-if="images.length != 5"
            class="flex-col flex gap-4 items-center justify-center"
            enctype="multipart/form-data"
        >
            <label for="photo">الصور</label>
            <input
                type="file"
                name=""
                id="photo"
                class="input"
                multiple
                @input="saveFiles"
            />
            <div v-if="form.errors.position" class="text-red-400">
                {{ form.errors.position }}
            </div>
        </form>
        <template #footer>
            <div dir="rtl" class="flex flex-row justify-around">
                <button
                    v-if="images.length != 5"
                    class="btn-green"
                    @click="submit"
                >
                    تأكيد
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
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";
import { Link, useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import "vue3-carousel/dist/carousel.css";

const saveFiles = (event) => {
    // console.log(event);
    form.images = [];
    // console.log(event.target.files);
    for (const file of event.target.files) {
        form.images.push(file);
    }
    // event.target.files.forEach(element => {
    //     form.images.push(element);
    // });
};
const submit = () => {
    form.post(route("admin.item_images.store"));
    emits("close");
};
const form = useForm({
    images: [],
    id: null,
    barcode: null,
});
watch(
    () => props.idRef,
    (val) => {
        form.id = val;
    }
);
watch(
    () => props.barcode,
    (val) => {
        form.barcode = val;
    }
);
const emits = defineEmits(["close"]);
const props = defineProps({
    idRef: Number,
    show: Boolean,
    images: Array,
    barcode: String,
});
</script>
