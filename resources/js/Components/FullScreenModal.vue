<script setup>
import {  onMounted, onUnmounted, watch } from "vue";

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

onMounted(() => document.addEventListener("keydown", closeOnEscape));

onUnmounted(() => {
    document.removeEventListener("keydown", closeOnEscape);
    document.body.style.overflow = null;
});


</script>

<template>
    <Teleport to="body">
        <Transition leave-active-class="duration-200">
            <div
                v-show="show"
                class="fixed inset-0 overflow-y-auto z-[2000]"
                scroll-region
            >
                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0"
                    enter-to-class="opacity-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100"
                    leave-to-class="opacity-0"
                >
                    <div
                        v-show="show"
                        class="fixed inset-0 transform transition-all"
                        @click="close"
                    >
                        <div class="absolute inset-0 bg-gray-500 opacity-75" />
                    </div>
                </Transition>

                <Transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div class="flex justify-center items-center h-full">
                        <div
                            v-show="show"
                            class=" bg-white flex flex-col overflow-hidden shadow-xl transform transition-all w-full h-full"
                        >
                            <div
                                dir="rtl"
                                class="p-3 bg-gray-300 font-bold text-xl dark:bg-gray-700"
                            >
                                <div
                                    class="border border-gray-600 dark:border-gray-500 dark:text-gray-300 w-7 text-center rounded-lg px-2 pb-[2px] hover:bg-red-200 dark:hover:bg-red-600 cursor-pointer"
                                    @click="close"
                                >
                                    x
                                </div>
                            </div>
                            <div class="p-3 flex-1 overflow-auto bg-gray-100 dark:bg-gray-500 dark:text-gray-300">
                                <slot v-if="show" />
                            </div>
                            <div class="p-3 bg-gray-300 dark:bg-gray-700">
                                <slot v-if="show" name="footer" />
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
