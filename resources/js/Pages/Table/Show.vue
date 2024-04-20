<template>
    <div
        v-if="printing"
        class="h-full w-full flex flex-col items-center justify-center"
    >
        <p>جاري الطباعة</p>
        <div class="flex flex-row gap-5 p-2 justify-center">
            <div
                v-for="item in 5"
                :key="item"
                class="inline-block h-8 w-8 animate-[spinner-grow_0.75s_linear_infinite] rounded-full bg-current align-[-0.125em] text-gray-300 opacity-0 motion-reduce:animate-[spinner-grow_1.5s_linear_infinite]"
                role="status"
            >
                <span
                    class="!absolute !-m-px !h-px !w-px !overflow-hidden !whitespace-nowrap !border-0 !p-0 ![clip:rect(0,0,0,0)]"
                    >Loading...</span
                >
            </div>
        </div>
    </div>
    <div v-else dir="rtl" class="flex flex-col h-full p-2 md:p-5">
        <TableInfo
            :table="table"
            :status="status"
            :zone_name="zones.find((e) => e.id == table.zone_id).name"
            @busy="makeBusy"
            @print="printTableData"
        />
        <TableItems
            :table-data="tableData"
            :most-ordered="mostOrdered"
            @openMostOrdered="showMostOrderedModal"
            @openDelete="showDeleteModal"
            @increase="increaseItem"
            @decrease="decreaseItem"
            :total-price="totalPrice"
        />
        <TableSubmit
            :table-data="tableData"
            :table_id="table.id"
            @submit-order="toggleQr"
            @changeTable="toggleMoveTable"
        />
    </div>
    <AddMostOrderedItemModal
        :show="show"
        @close="toggle"
        @add="addItem"
        :item="item"
    />
    <DeleteTableDataModal
        :show="showDel"
        :item="item"
        @close="toggleDel"
        @deleted="deleteItem"
    />
    <QrModal
        :show="showQr"
        :qr="qr"
        :services-arr="services"
        @close="toggleQr"
        @finishOrder="finishOrder"
        @service="calculateService"
    />
    <MoveTableModal
        :show="showMoveTable"
        :zones="zoneRef"
        :table_id="props.table.id"
        @close="toggleMoveTable"
        @move="moveTable"
    />
    <!-- 
    <FullScreenModal
    :show="true"
    /> -->
</template>
<script setup>
import TableInfo from "@/Pages/Table/Components/TableInfo.vue";
import TableItems from "@/Pages/Table/Components/TableItems.vue";
import TableSubmit from "@/Pages/Table/Components/TableSubmit.vue";
import AddMostOrderedItemModal from "@/Pages/Table/Components/AddMostOrderedItemModal.vue";
import { ref } from "vue";
import { onMounted } from "vue";
import DeleteTableDataModal from "@/Pages/Table/Components/DeleteTableDataModal.vue";
import QrModal from "@/Pages/Table/Components/QrModal.vue";
import MoveTableModal from "@/Pages/Table/Components/MoveTableModal.vue";
import { computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";
const showQr = ref(false);
const toggleQr = () => {
    showQr.value = !showQr.value;
};

const printing = ref(false);
const barcode = ref([]);
const amount = ref([]);
// const servicePrice = ref(0);
const calculateService = (services) => {
    // servicePrice.value = 0;
    barcode.value = [];
    amount.value = [];
    services.forEach((element) => {
        const id = element.value;
        if (id != 0) {
            const service = props.services.find((e) => e.id == id);
            const amount2 =
                (totalPrice.value * parseInt(service.percent)) /
                100 /
                service.mainBarcodeSellprice;
            amount.value.push(
                (totalPrice.value * parseInt(service.percent)) / 100
            );
            barcode.value.push(
                service.mainBarcode.replace(
                    "00000",
                    (amount2.toString().split(".")[0].length == 1
                        ? amount2.toString().split(".")[0] + "0"
                        : amount2.toString().split(".")[0]) +
                        amount2.toFixed(3).split(".")[1]
                )
            );
        }
    });
};
const showMoveTable = ref(false);
const toggleMoveTable = () => {
    showMoveTable.value = !showMoveTable.value;
};
const show = ref(false);
const item = ref(null);
const tableData = ref([]);
const totalPrice = computed(
    () =>
        tableData.value.reduce(
            (i, e) => i + e.amount * (e.price - e.discount),
            0
        ) + amount.value.reduce((i, e) => i + e, 0)
);
const qr = computed(
    () =>
        tableData.value.reduce((string, e) => {
            let total = "";
            for (let i = 0; i < e.amount; i++) {
                total += e.barcode.trim() + "\r\n";
            }
            return string + total;
        }, "") +
        barcode.value.reduce((string, e) => {
            return string + e + "\r\n";
        }, "")
);

const zoneRef = ref(props.zones);

const deleteItem = (data) => {
    // console.log(data);

    const index = tableData.value.findIndex((e) => e.id == data.id);
    deleteTableDataItem(tableData.value[index], index);
    // //delete table data

    toggleDel();
};
const increaseItem = (data) => {
    const index = tableData.value.findIndex((e) => e.id == data.id);
    //update table data
    Array.from(
        document.getElementsByClassName("btn-increase-decrease")
    ).forEach((element) => {
        element.disabled = true;
        // console.log(element);
    });

    updateTableData(tableData.value[index], index, 1);
};
const decreaseItem = (data) => {
    const index = tableData.value.findIndex((e) => e.id == data.id);
    if (tableData.value[index].amount != 1) {
        Array.from(
            document.getElementsByClassName("btn-increase-decrease")
        ).forEach((element) => {
            element.disabled = true;
            // console.log(element);
        });
        //update table data
        updateTableData(tableData.value[index], index, -1);
    }
};
const addItem = (amount, images) => {
    // make table full
    if (status.value != "مشغول") {
        makeTableFull(props.table.id);
    }

    const index = tableData.value.findIndex(
        (e) => e.barcode == item.value.barcode.trim() && e.printed != "1"
    );
    if (index != -1) {
        //update table data
        updateTableData(tableData.value[index], index, amount);
    } else {
        //insert table data
        insertIntoTableData(item.value, amount, images);
    }

    toggle();
};
const showMostOrderedModal = (data) => {
    item.value = data;
    toggle();
};
const deleteTableDataItem = (data, index) => {
    window.axios
        .delete(route("tableData.destroy", [data.id]))
        .then((response) => {
            // console.log(response);
            // tableData.value.splice(index, 1);
            // if (tableData.value.length == 0) {
            //     makeBusy(props.table.id, false);
            // }
        })
        .catch((err) => {});
};
const insertIntoTableData = (data, amount, images) => {
    window.axios
        .post(route("tableData.store"), {
            barcode: data.barcode.trim(),
            amount: amount,
            table_id: props.table.id,
        })
        .then((response) => {
            // tableData.value.push({
            //     id: response.data.tableData.id,
            //     pic: images[0],
            //     name: data.a_name,
            //     barcode: data.barcode.trim(),
            //     amount: amount,
            //     price: parseFloat(data.sell_price),
            //     discount: discount(data),
            // });
        })
        .catch((err) => {
            console.error(err);
        });
};

const discount = (item) => {
    if (item.date_to && item.date_from && item.usage == 1) {
        const datetime = new Date();
        const dateEnd = new Date(item.date_to);
        const dateBegin = new Date(item.date_from);
        if (datetime > dateBegin && datetime <= dateEnd) {
            switch (item.discounttype) {
                case 3:
                case 102:
                    return parseFloat(item.discountvalue);
                case 101:
                    return (
                        (parseFloat(item.discountvalue) *
                            parseFloat(item.sell_price)) /
                        100
                    );
                default:
                    break;
            }
        }
    }
    return 0;
};
const toggle = () => {
    show.value = !show.value;
};
const props = defineProps({
    table: Object,
    tableData: Array,
    mostOrdered: Array,
    retail_data: Array,
    zones: Array,
    services: Array,
});
const status = ref(props.table.status);
const showDel = ref(false);
const toggleDel = () => {
    showDel.value = !showDel.value;
};
const showDeleteModal = (data) => {
    item.value = data;
    toggleDel();
};
onMounted(() => {
    props.tableData.forEach((element) => {
        const real_data = props.retail_data.find(
            (x) => x.barcode.trim() == element.barcode
        );
        tableData.value.push({
            id: element.id,
            pic: element.pics[0],
            name: real_data.a_name,
            barcode: element.barcode,
            amount: parseInt(element.amount),
            price: parseFloat(real_data.sell_price),
            discount: discount(real_data),
            printed: element.printed,
        });
    });
});
const makeTableFull = (id) => {
    window.axios
        .put(route("table.status", [id]), { status: "مشغول" })
        .then((response) => {})
        .catch((err) => {
            console.log(err);
        });
};
const finishOrder = () => {
    
    window.axios
        .post(route("table.finish", [props.table.id]), {
            data: tableData.value,
        },{withCredentials:true})
        .then((response) => {
            makeBusy(props.table.id, false);
            // tableData.value = [];
            toggleQr();

            //redirect to home
            router.visit(route("home"));
            // console.log(response.data);
        })
        .catch((err) => {});
};
const makeBusy = (id, busy) => {
    window.axios
        .put(route("table.status", [id]), {
            status: busy ? "محجوز" : "فارغ",
        })
        .then((response) => {
            // if (id == props.table.id) {
            //     status.value = response.data.table.status;
            // }
        })
        .catch((err) => {
            console.log(err);
        });
};
const updateTableData = (data, index, amount) => {
    window.axios
        .put(route("tableData.update", data.id), {
            amount: data.amount + amount,
        })
        .then((response) => {
            Array.from(
                document.getElementsByClassName("btn-increase-decrease")
            ).forEach((element) => {
                element.disabled = false;
                // console.log(element);
            });
            // tableData.value[index].amount += amount;
        })
        .catch((err) => {});
};

const moveTable = (id) => {
    window.axios
        .put(route("table.move", [props.table.id]), { to: id })
        .then((response) => {
            status.value = response.data.table.status;
            makeTableFull(id);
            // tableData.value = [];
            toggleMoveTable();
            //redirect to home
            router.visit(route("table.show", id));
        })
        .catch((err) => {
            console.log(err);
        });
};

const printTableData = () => {
    printing.value = true;
    window.axios
        .post(route("table.print", [props.table.id]), { data: tableData.value })
        .then((response) => {
            printing.value = false;
            // console.log(response.data.arr);
        })
        .catch((err) => {
            printing.value = false;
            console.log(err);
        });
};

onMounted(() => {
    window.Echo.channel(`table-data-changed`).listen(
        "tableDataChanged",
        (e) => {
            if (e.table.id == props.table.id) {
                status.value = e.table.status;
                tableData.value = [];
                e.table.data.forEach((element) => {
                    const real_data = e.retail_data.find(
                        (x) => x.barcode.trim() == element.barcode
                    );
                    tableData.value.push({
                        id: element.id,
                        pic: element.pics[0],
                        name: real_data.a_name,
                        barcode: element.barcode,
                        amount: parseInt(element.amount),
                        price: parseFloat(real_data.sell_price),
                        discount: discount(real_data),
                        printed: element.printed,
                    });
                });
            }
        }
    );
    window.Echo.channel(`channel-name`).listen("TableStatusChanged", (e) => {
        zoneRef.value = e.zones;
    });
});
</script>
