<template>
    <Head title="الخدمات" />
    <CreateBtn route-str="admin.service" title-str="خدمة" />

    <CustomTable
        :heads="['الاسم', 'النسبة', 'باركود الأساسي',]"
        :tables="['name', 'percent', 'mainBarcode',]"
        :data="services"
        :route-string="'admin.service'"
        :title-str="'خدمات'"
        @delete="deleteBtn"
        @restore="restoreBtn"
    />
    <DeleteModal
        route-string="admin.service"
        :show="show"
        @close="toggle"
        :id-ref="idRef"
        title-str="الخدمة"
        @deleted="toggle"
    />
    <RestoreModal
        :show="showRes"
        @close="toggleRes"
        route-string="admin.service"
        :id-ref="idRef"
        title-str="الخدمة"
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
    services: Object,
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
