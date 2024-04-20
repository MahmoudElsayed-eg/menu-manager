<template>
    <div class="flex p-4 gap-2">
        <Link :href="route('admin.category.index')" class="btn-primary"
        >العودة</Link
        >
        <button @click="toggle" class="btn-green">إضافة منتج</button>
    </div>
    <CustomCategoryTable
        :heads="['الترتيب', 'الباركود', 'الاسم', 'الصور']"
        :data="data"
        :data2="items"
        :tables="['position', 'barcode', 'a_name', 'photos']"
        :title-str="'منتجات'"
        :route-string="'admin.categoryData'"
        @delete="showDelete"
        @edit="showEdit"
        @photos="showPhotos"
        @restore="showRestore"
    />
    <ProductModal :show="show" :id-ref="category.id" @close="toggle" />
    <DeleteModal
        route-string="admin.categoryData"
        :show="showDel"
        @close="toggleDel"
        @deleted="toggleDel"
        :id-ref="idRef"
        title-str="المنتج"
    />
    <EditModal
        route-string="admin.categoryData"
        :show="showEd"
        @close="toggleEd"
        :id-ref="idRef"
        :position="position"
    />
    <PhotosModal
        route-string="admin.categoryData"
        :show="showPho"
        @close="togglePho"
        :id-ref="idRef"
        :barcode="barcode"
        :images="pics"
    />

    <RestoreModal
        route-string="admin.categoryData"
        :show="showRes"
        @close="toggleRes"
        :id-ref="idRef"
        title-str="المنتج"
    />
</template>
<script setup>
import ProductModal from "@/Pages/Admin/Category/Components/ProductModal.vue";
import CustomCategoryTable from "./Components/CustomCategoryTable.vue";
import { ref } from "vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import EditModal from "./Components/EditModal.vue";
import PhotosModal from "./Components/PhotosModal.vue";
import RestoreModal from "@/Components/RestoreModal.vue";
import { Link } from "@inertiajs/vue3";
const idRef = ref(null);
const barcode = ref(null);
const position = ref(null);
const pics = ref(null);
const showDelete = (id) => {
    idRef.value = id;
    toggleDel();
};
const showRestore = (id) => {
    idRef.value = id;
    toggleRes();
};
const showPhotos = (id) => {
    idRef.value = id;
    const obj = props.data.data.find((element) => element.id == id);
    pics.value = obj.pics;
    barcode.value = obj.barcode;
    togglePho();
};
const showEdit = (id, pos) => {
    idRef.value = id;
    position.value = parseInt(pos);
    toggleEd();
};
const show = ref(false);
const toggle = () => {
    show.value = !show.value;
};
const showDel = ref(false);
const toggleDel = () => {
    showDel.value = !showDel.value;
};
const showRes = ref(false);
const toggleRes = () => {
    showRes.value = !showRes.value;
};
const showEd = ref(false);
const toggleEd = () => {
    showEd.value = !showEd.value;
};
const showPho = ref(false);
const togglePho = () => {
    showPho.value = !showPho.value;
};
const props = defineProps({
    category: Object,
    items: Array,
    data: Object,
});
</script>
