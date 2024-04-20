<script setup>
import { onMounted, onUnmounted, watch } from "vue";

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
    <teleport to="body">
        <transition leave-active-class="duration-200">
            <div
                v-show="show"
                class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-40"
                scroll-region
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
                        class="fixed inset-0 transform transition-all"
                        @click="close"
                    >
                        <div
                            class="absolute inset-0 bg-gray-500 dark:bg-gray-800 opacity-75"
                        />
                    </div>
                </transition>

                <transition
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
                            class="mb-6 bg-white dark:bg-gray-600 rounded-lg overflow-hidden shadow-xl transform transition-all w-full mx-auto"
                        >
                            <div
                                dir="rtl"
                                class="p-3 bg-gray-300 dark:bg-gray-700 font-bold text-xl"
                            >
                                <div
                                    class="border border-gray-600 dark:text-gray-400 w-10 text-center rounded-lg p-2 hover:bg-white dark:hover:bg-gray-600 cursor-pointer"
                                    @click="close"
                                >
                                    x
                                </div>
                            </div>
                            <div class="p-3  dark:text-gray-400"><slot v-if="show" /></div>
                            <div class="p-3 bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
                                <slot v-if="show" name="footer" />
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </transition>
    </teleport>
</template>
