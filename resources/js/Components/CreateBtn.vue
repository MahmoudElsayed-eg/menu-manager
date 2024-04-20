<template>
    <div class="flex md:flex-row flex-col gap-2 justify-between">
        <Link
            :href="route(routeStr + '.create')"
            class="btn-primary mx-3 my-3 text-center"
        >
            إضافة {{ titleStr }}
        </Link>
    </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    routeStr: String,
    titleStr: String,
});
</script>
