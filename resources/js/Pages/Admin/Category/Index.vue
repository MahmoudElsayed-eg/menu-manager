<template>
    <Head title="الأصناف" />
    <CreateBtn route-str="admin.category" title-str="صنف" />

    <CustomTable
        :heads="['الترتيب','الاسم','الصورة']"
        :tables="['position' ,'name','pic' ]"
        :data="categories"
        :route-string="'admin.category'"
        :title-str="'أصناف'"
        :show="true"
        @delete="deleteBtn"
        @restore="restoreBtn"
    />
    <DeleteModal
        route-string="admin.category"
        :show="show"
        @close="toggle"
        :id-ref="idRef"
        title-str="الصنف"
        @deleted="toggle"
    />
    <RestoreModal
        :show="showRes"
        @close="toggleRes"
        route-string="admin.category"
        :id-ref="idRef"
        title-str="الصنف"
    />
</template>
<script setup>
import CreateBtn from "@/Components/CreateBtn.vue";
import CustomTable from "@/Components/CustomTable.vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import RestoreModal from "@/Components/RestoreModal.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
const idRef = ref(0);
const props = defineProps({
    categories: Object,
});
const show = ref(null);
const showRes = ref(null);
const toggle = () => {
    show.value = !show.value;
};
const toggleRes = () => {
    showRes.value = !showRes.value;
};

function deleteBtn(id) {
    idRef.value = id;
    show.value = !show.value;
}
function restoreBtn(id) {
    idRef.value = id;
    showRes.value = !showRes.value;
}
</script>
