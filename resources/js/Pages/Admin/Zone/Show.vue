<template>
    <div class="flex flex-col gap-4 w-full h-full p-3">
        <h1 class="text-center font-bold text-3xl">{{ zone.name }}</h1>
        <!-- {{ form.height[current] }} -->
        <div dir="rtl" class="flex flex-row gap-2 justify-evenly">
            <button @click="toggleAddTable" class="btn-primary">
                إضافة طاولة
            </button>
            <div v-if="zone.tables.length > 0" class="flex flex-row gap-2">
                <button @click="toggleEditTable" class="button-edit">
                    تعديل
                </button>
                <button @click="toggleDeleteTable" class="btn-danger">
                    مسح
                </button>
            </div>
        </div>

        <div
            v-if="zone.tables.length > 0"
            class="flex flex-row flex-wrap gap-2 w-full items-center justify-evenly"
        >
            <div class="flex flex-col gap-1 justify-center items-center">
                <label for="width" class="font-medium"
                    >عرض الطاولة {{ zone.tables[current].name }}</label
                >
                <input
                    type="number"
                    name=""
                    min="0"
                    id="width"
                    v-model="form.width[current].width"
                    class="w-28 dark:bg-gray-600 rounded-md"
                />
            </div>
            <div class="flex flex-col gap-1 items-center justify-center">
                <label for="height" class="font-medium"
                    >طول الطاولة {{ zone.tables[current].name }}</label
                >
                <input
                    type="number"
                    name=""
                    min="0"
                    id="height"
                    v-model="form.height[current].height"
                    class="w-28 dark:bg-gray-600 rounded-md"
                />
            </div>
            <div class="flex flex-col gap-2 items-center justify-center">
                <div class="flex flex-row gap-1 items-center justify-center">
                    <label for="round" class="font-medium text-center"
                        >الطاولة {{ zone.tables[current].name }} مدورة</label
                    >
                    <input
                        type="checkbox"
                        name=""
                        id="round"
                        v-model="form.round[current].round"
                    />
                </div>
                <p>عدد الكراسي : {{ zone.tables[current].numChairs }}</p>
            </div>
            <div class="flex flex-col gap-1 items-center justify-center">
                <label for="tablecolor" class="font-medium"
                    >لون الطاولة {{ zone.tables[current].name }}</label
                >
                <input
                    type="color"
                    name=""
                    id="tablecolor"
                    v-model="form.tablecolor[current].tablecolor"
                    class="dark:bg-gray-600 rounded-md"
                />
            </div>
            <div class="flex flex-col gap-1 items-center justify-center">
                <label for="textcolor" class="font-medium"
                    >لون خط الطاولة {{ zone.tables[current].name }}</label
                >
                <input
                    type="color"
                    name=""
                    min="0"
                    id="textcolor"
                    v-model="form.textcolor[current].textcolor"
                    class="dark:bg-gray-600 rounded-md"
                />
            </div>
        </div>
        <div ref="container" class="flex-1 border-2 border-gray-500 relative">
            <!-- <div
                class="border border-gray-950 w-fit p-2 bg-gray-300 absolute top-32"
                :style="`top:${percent}% ;`"
            >
                test
            </div> -->
            <div
                v-for="(item, index) in zone.tables"
                :key="index"
                :id="index"
                @mousedown="startDrag"
                @mouseup="stopDrag"
                @touchstart="startDrag"
                @touchend="stopDrag"
                class="border border-gray-950 p-2 text-[#fff] bg-white cursor-pointer absolute flex items-center justify-center text-center"
                :style="`color:${form.textcolor[index].textcolor};background-color:${form.tablecolor[index].tablecolor}; top:${form.positions[index].top}%; left:${form.positions[index].left}%; width:${form.width[index].width}%; height:${form.height[index].height}%`"
                :class="form.round[index].round != '0' ? 'rounded-full' : ''"
            >
                {{ item.name }}
            </div>
        </div>
        <button class="btn-green w-fit mx-auto" @click="submit">
            حفظ التخطيط
        </button>
    </div>
    <AddTableModal
        :show="showAddTable"
        @close="toggleAddTable"
        :zone_id="props.zone.id"
    />
    <EditTableModal
        :show="showEditTable"
        @close="toggleEditTable"
        :table="table"
    />
    <DeleteModal
        :show="showDeleteTable"
        @close="toggleDeleteTable"
        :route-string="'admin.table'"
        :title-str="'الطاولة'"
        :id-ref="table?.id"
        @deleted="
            current = 0;
            toggleDeleteTable();
        "
    />
</template>
<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import AddTableModal from "./Components/AddTableModal.vue";
import EditTableModal from "./Components/EditTableModal.vue";
import DeleteModal from "@/Components/DeleteModal.vue";
const form = useForm({
    width: [],
    height: [],
    round: [],
    positions: [],
    textcolor: [],
    tablecolor: [],
});
props.zone.tables.forEach((element) => {
    form.positions.push({
        top: ref(element.y),
        left: ref(element.x),
    });
    form.height.push({
        height: ref(parseInt(element.height)),
    });
    form.width.push({ width: ref(parseInt(element.width)) });
    form.round.push({ round: ref(element.round == "1") });
    form.textcolor.push({ textcolor: ref(element.textcolor) });
    form.tablecolor.push({ tablecolor: ref(element.tablecolor) });
    // positions.value.push({
    //     top: ref(element.y),
    //     left: ref(element.x),
    // });
});
const container = ref(null);
const element = ref(null);
const current = ref(0);
const table = ref(props.zone.tables[current.value] ?? null);
const showAddTable = ref(false);
const toggleAddTable = () => {
    showAddTable.value = !showAddTable.value;
};
const showEditTable = ref(false);
const toggleEditTable = () => {
    showEditTable.value = !showEditTable.value;
};
const showDeleteTable = ref(false);
const toggleDeleteTable = () => {
    showDeleteTable.value = !showDeleteTable.value;
};
const submit = () => form.post(route("admin.zone.save", props.zone.id));
// const percent = ref(0);
const onMouseMove = (event) => {
    // console.log(event);
    // let shiftX = event.clientX - element.value.getBoundingClientRect().left;
    // console.log(event.pageX - container.value.getBoundingClientRect().left -element.value.offsetWidth / 2);
    // console.log(event.pageX);
    // console.log(
    //     container.value.getBoundingClientRect().right +
    //         element.value.offsetWidth / 2
    // );
    // let elementOver = 0;
    // form.positions.forEach(element => {

    //     if () {

    //     }
    // });
    // console.log(elementOver);
    let pageX = event.pageX ?? event.touches[0].pageX;
    let pageY = event.pageY ?? event.touches[0].pageY;
    if (
        pageX -
            container.value.getBoundingClientRect().left -
            element.value.offsetWidth / 2 >
            0 &&
        pageX <
            container.value.getBoundingClientRect().right -
                element.value.offsetWidth / 2
    ) {
        // element.value.style.left =
        //     event.pageX -
        //     container.value.getBoundingClientRect().left -
        //     element.value.offsetWidth / 2 +
        //     "px";
        form.positions[parseInt(element.value.id)].left =
            ((pageX -
                container.value.getBoundingClientRect().left -
                element.value.offsetWidth / 2) /
                container.value.offsetWidth) *
            100;
        // percent.value =
        //     ((event.pageX -
        //         container.value.getBoundingClientRect().left -
        //         element.value.offsetWidth / 2) /
        //         container.value.offsetWidth) *
        //     100;
    }

    if (
        pageY -
            container.value.getBoundingClientRect().top -
            element.value.offsetHeight / 2 >
            0 &&
        pageY <
            container.value.getBoundingClientRect().bottom -
                element.value.offsetHeight / 2
    ) {
        // element.value.style.top =
        //     event.pageY -
        //     container.value.getBoundingClientRect().top -
        //     element.value.offsetHeight / 2 +
        //     "px";
        form.positions[parseInt(element.value.id)].top =
            ((pageY -
                container.value.getBoundingClientRect().top -
                element.value.offsetHeight / 2) /
                container.value.offsetHeight) *
            100;
    }
    // console.log(element.value);
};
const startDrag = (event) => {
    element.value = event.srcElement;
    current.value = parseInt(element.value.id);
    table.value = props.zone.tables[current.value];
    // console.log(element.value);
    document.addEventListener("mousemove", onMouseMove);
    document.addEventListener("touchmove", onMouseMove);
};
const stopDrag = (event) => {
    // element.value.classList.remove("absolute");
    element.value = null;
    document.removeEventListener("mousemove", onMouseMove);
    document.removeEventListener("touchmove", onMouseMove);
};

const props = defineProps({
    zone: Object,
});
watch(
    () => props.zone.tables,
    (val) => {
        form.positions = [];
        form.height = [];
        form.width = [];
        form.round = [];
        form.textcolor = [];
        form.tablecolor = [];
        val.forEach((element) => {
            form.positions.push({
                top: ref(element.y),
                left: ref(element.x),
            });
            form.height.push({
                height: ref(parseInt(element.height)),
            });
            form.width.push({
                width: ref(parseInt(element.width)),
            });
            form.round.push({ round: ref(element.round == "1") });
            form.textcolor.push({
                textcolor: ref(element.textcolor),
            });
            form.tablecolor.push({
                tablecolor: ref(element.tablecolor),
            });
        });
        // console.log(pre);
        // console.log(val);
        // if (val.length > pre.length) {
        //     form.positions.push({
        //         top: ref(val[val.length -1 ].y),
        //         left: ref(val[val.length -1 ].x),
        //     });
        //     form.height.push({
        //         height: ref(parseInt(val[val.length -1 ].height)),
        //     });
        //     form.width.push({ width: ref(parseInt(val[val.length -1 ].width)) });
        //     form.round.push({ round: ref(val[val.length -1 ].round == "1") });
        //     form.textcolor.push({ textcolor: ref(val[val.length -1 ].textcolor) });
        //     form.tablecolor.push({ tablecolor: ref(val[val.length -1 ].tablecolor) });
        // }
    }
);
const positions = ref([]);
</script>
