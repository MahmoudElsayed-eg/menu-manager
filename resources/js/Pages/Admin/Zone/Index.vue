<template>
    <Head title="المناطق" />
    <CreateBtn route-str="admin.zone" title-str="منطقة" />

    <CustomTable
        :heads="['الترتيب', 'الاسم']"
        :tables="['position', 'name']"
        :data="zones"
        :route-string="'admin.zone'"
        :title-str="'مناطق'"
        :show="true"
        @delete="deleteBtn"
        @restore="restoreBtn"
    />
    <DeleteModal
        route-string="admin.zone"
        :show="show"
        @deleted="toggle"
        @close="toggle"
        :id-ref="idRef"
        title-str="المنطقة"
    />
    <RestoreModal
        :show="showRes"
        @close="toggleRes"
        route-string="admin.zone"
        :id-ref="idRef"
        title-str="المنطقة"
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
    zones: Object,
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
