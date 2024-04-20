<template>
    <Head title="الطاولات" />
    <CreateBtn route-str="admin.table" title-str="طاولة" />

    <CustomTable
        :heads="['الاسم','المنطقة','عدد الكراسي']"
        :tables="['name','zone_id','numChairs', ]"
        :data="tables"
        :route-string="'admin.table'"
        :title-str="'طاولات'"
        @delete="deleteBtn"
        @restore="restoreBtn"
    />
    <DeleteModal
        route-string="admin.table"
        :show="show"
        @close="toggle"
        @deleted="toggle"
        :id-ref="idRef"
        title-str="الطاولة"
    />
    <RestoreModal
        :show="showRes"
        @close="toggleRes"
        route-string="admin.table"
        :id-ref="idRef"
        title-str="الطاولة"
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
    tables: Object,
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
