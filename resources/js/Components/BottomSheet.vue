<script setup>
import { onMounted, onUnmounted, watch, ref, computed } from "vue";
const dragging = ref(false);
const y = ref(0);
const height = ref(0);
const max = ref("");
const def = ref(null);

// const sheetTransform = computed(() => {

//     if (!props.show) {
//         return "translateY(100%)";
//     } else if (document.getElementById("modal-sheet").style.height == "100%") {
//         return "";
//     } else {
//         // console.log(a);
//         // return `translateY(${max})`;
//     }
//     // } else {
//     //     const translateY =
//     //         (1 - a.offsetHeight / a.parentElement.offsetHeight) * 100;
//     //     return `translateY(${translateY}%)`;
//     // }
// });

const startDrag = (e) => {
    dragging.value = true;
    if (e.clientY == undefined) {
        y.value = e.touches[0].clientY;
    } else {
        y.value = e.clientY;
    }
    height.value = document.getElementById("modal-sheet").offsetHeight;
};
const stopDrag = () => {
    dragging.value = false;
    const a = document.getElementById("modal-sheet");
    if (a.offsetHeight < 0.4 * window.innerHeight) {
        close();
    } else if (a.offsetHeight > 0.75 * window.innerHeight) {
        a.style.height = "100%";
        // a.style.
    }
};
const handleDrag = (e) => {
    if (!dragging.value) {
        return;
    }
    let diff = 0;
    if (e.clientY == undefined) {
        diff = e.touches[0].clientY - y.value;
    } else {
        diff = e.clientY - y.value;
    }
    def.value = diff;
    const newHeight = height.value - diff;
    max.value = newHeight;
    // height.value = newHeight;
    // height.value = (newHeight / window.innerHeight) * 100;
    // Set new height of sheet
    // document.getElementById(
    //     "modal-sheet"
    // ).style.transform = `translate3d(0, ${diff}px, 0)`;
    document.getElementById("modal-sheet").style.height = `${newHeight}px`;
};
const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    closeable: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(["close"]);

watch(
    () => props.show,
    () => {
        if (props.show) {
            document.body.style.overflow = "hidden";
            document
                .getElementById("modal-sheet")
                .classList.add("animate-fade-up");
            document
                .getElementById("modal-sheet")
                .classList.add("animate-duration-1000");
            setTimeout(() => {
                document
                    .getElementById("modal-sheet")
                    .classList.remove("animate-fade-up");
                document
                    .getElementById("modal-sheet")
                    .classList.remove("animate-duration-1000");
            }, 1000);
            document.getElementById("modal-sheet").style.height = "80%";
            // document.getElementById("modal-sheet").style.translate =
            max.value = document.getElementById("modal-sheet").style.height;
        } else {
            document.body.style.overflow = null;
        }
    }
);

const close = () => {
    if (props.closeable) {
        emit("close");
    }
};

const closeOnEscape = (e) => {
    if (e.key === "Escape" && props.show) {
        close();
    }
};

onMounted(() => {
    document.addEventListener("keydown", closeOnEscape);
});

onUnmounted(() => {
    document.removeEventListener("keydown", closeOnEscape);
    document.body.style.overflow = null;
});
</script>

<template>
    <teleport to="body">
        <transition leave-active-class="duration-200">
            <div
                v-show="show"
                class="fixed inset-0 flex items-end overflow-y-auto sm:px-0 z-40 mb-16 md:mb-0 md:mt-16"
                scroll-region
                @mousemove="handleDrag"
                @touchmove="handleDrag"
            >
                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        v-show="show"
                        class="fixed inset-0 transform transition-all mb-16 md:mb-0 md:mt-16 h-full"
                        @click="close"
                    >
                        <div class="absolute inset-0 bg-gray-500 opacity-75" />
                    </div>
                </transition>

                <!-- <transition
                    enter-active-class="ease-out duration-500"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-full sm:scale-100"
                    leave-active-class="ease-in duration-500"
                    leave-from-class="opacity-100 translate-y-full sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                > -->
                    <div
                        id="modal-sheet"
                        v-show="show"
                        class="bg-[#f6f6f8] dark:bg-[#131418] overflow-hidden shadow-xl transform transition-height w-full sm:mx-auto h-4/5"
                    >
                        <header dir="rtl" class="relative w-full h-9">
                            <!-- The thing to drag if you want to resize the sheet -->
                            <div
                                id="thumb"
                                class="absolute top-0 left-0 right-0 w-1/2 mx-auto p-4 cursor-grab"
                                @mousedown="startDrag"
                                @touchstart="startDrag"
                                @mouseup="stopDrag"
                                @touchend="stopDrag"
                            >
                                <div
                                    class="w-full h-1 bg-gray-200 dark:bg-gray-700 rounded-sm"
                                ></div>
                            </div>
                            <!-- Button to close the sheet -->
                            <button
                                class="absolute right-0 top-0 border-none h-9 bg-[#f6f6f8] dark:bg-[#131418] text-3xl dark:text-gray-400"
                                type="button"
                                @click="close"
                            >
                                &times;
                            </button>
                        </header>
                        <main
                            class="h-full overflow-y-auto px-4 bg-[#f6f6f8] dark:bg-[#131418] dark:text-gray-300 pb-9"
                        >
                            <slot v-if="show" />
                        </main>
                    </div>
                <!-- </transition> -->
            </div>
        </transition>
    </teleport>
</template>
<style scoped>
.transition-height {
    transition-property: height;
    transition-duration: 0.1s; /* or 0.1s */
    transition-timing-function: ease-out;
}
.transition-y {
    transform: translateY(0%);
}
</style>
