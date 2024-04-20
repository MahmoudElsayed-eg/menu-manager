<template>
    <div class="flex items-center justify-between">
        <div class="w-full p-5 flex flex-row justify-evenly">
            <h2
                class="text-xl font-semibold line-clamp-1 whitespace-nowrap text-ellipsis"
            >
                المنطقة : {{ zone_name }}
            </h2>
            <h1
                class="text-xl font-semibold line-clamp-1 whitespace-nowrap text-ellipsis"
            >
                الطاولة : {{ table.name }}
            </h1>
        </div>
        <Link :href="route('home')" class="btn-primary w-fit">الرجوع</Link>
    </div>

    <div
        class="flex flex-row justify-between gap-2 p-2 border-2 border-gray-300 dark:border-gray-600"
    >
        <div class="flex flex-col items-center justify-around">
            <p>عدد الكراسي : {{ table.numChairs }}</p>
            <div dir="rtl" class="flex gap-1 items-center justify-center">
                <p>الحالة :</p>
                <div
                    class="w-3 h-3 rounded-full"
                    :class="{
                        'bg-green-500': status == 'فارغ',
                        'bg-yellow-500': status == 'محجوز',
                        'bg-red-500': status == 'مشغول',
                    }"
                ></div>
                <p>
                    {{ status }}
                </p>
            </div>
        </div>
        <div
            class="flex flex-col md:flex-row gap-1 items-center justify-center"
        >
            <p>عدد الأفراد :</p>
            <input
                type="number"
                @input="submitPersons"
                class="w-16 lg:w-32 rounded-md dark:bg-gray-700"
                v-model="numPersons"
            />
        </div>
        <div
            v-if="status != 'مشغول'"
            class="flex flex-row gap-1 items-center justify-center"
        >
            <input
                id="busy"
                type="checkbox"
                v-model="busy"
                @change="$emit('busy', props.table.id, busy)"
            />
            <label for="busy">محجوز</label>
        </div>
        <button
            v-if="status == 'مشغول'"
            class="btn-green"
            @click="$emit('print')"
        >
            <PrinterIcon class="h-6 w-6" />
        </button>
    </div>
</template>
<script setup>
import PrinterIcon from "@/Icons/PrinterIcon.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";

const busy = ref(props.status == "محجوز");
const numPersons = ref(props.table.numPersons);
const submitPersons = () => {
    if (numPersons.value && numPersons.value >= 0) {
        window.axios
            .put(route("table.persons", [props.table.id]), {
                numPersons: numPersons.value,
            })
            .then((response) => {
                // console.log(response);
            })
            .catch((err) => {
                console.error(err);
            });
    }
};
const props = defineProps({
    table: Object,
    zone_name: String,
    status: String,
});

defineEmits(["busy", "print"]);
</script>
