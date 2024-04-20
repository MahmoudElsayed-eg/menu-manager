<template>
{{ date }}
{{ report }}
</template>
<script setup>
defineProps({
    date:String,
    report:Object,
})
</script>