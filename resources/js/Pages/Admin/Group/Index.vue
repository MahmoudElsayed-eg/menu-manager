<template>
    <Head title="المجموعات" />
    <CreateBtn route-str="admin.print_group" title-str="مجموعة" />

    <CustomGroupTable
        :heads="['الاسم','الأصناف']"
        :tables="['name','categories']"
        :data="groups"
        :route-string="'admin.print_group'"
        :title-str="'مجموعات'"
        :show="false"
        @delete="deleteBtn"
        @restore="restoreBtn"
    />
    <DeleteModal
        route-string="admin.print_group"
        :show="show"
        @close="toggle"
        :id-ref="idRef"
        title-str="المجموعة"
        @deleted="toggle"
    />
    <RestoreModal
        :show="showRes"
        @close="toggleRes"
        route-string="admin.print_group"
        :id-ref="idRef"
        title-str="المجموعة"
    />
</template>
<script setup>
import CreateBtn from "@/Components/CreateBtn.vue";
import CustomGroupTable from "./Components/CustomGroupTable.vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import RestoreModal from "@/Components/RestoreModal.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
const idRef = ref(0);
const props = defineProps({
    groups: Object,
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
