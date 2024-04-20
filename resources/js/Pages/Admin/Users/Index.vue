<template>
    <Head title="المستخدمين" />
    <CreateBtn route-str="admin.users" title-str="مستخدم" />

    <CustomTable
        :heads="['مدير','كاشير','الاسم']"
        :tables="['is_manager','is_cashier','name']"
        :data="users"
        :route-string="'admin.users'"
        :title-str="'مستخدمين'"
        @delete="deleteBtn"
        @restore="restoreBtn"
    />
    <DeleteModal
        route-string="admin.users"
        :show="show"
        @close="toggle"
        @deleted="toggle"
        :id-ref="idRef"
        title-str="المستخدم"
    />
    <RestoreModal
        :show="showRes"
        @close="toggleRes"
        route-string="admin.users"
        :id-ref="idRef"
        title-str="المستخدم"
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
    users: Object,
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
