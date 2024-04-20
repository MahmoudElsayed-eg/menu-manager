<template>
    <div class="h-screen flex flex-col">
        <div
            class="p-2 flex flex-row items-center justify-between gap-1 md:gap-5 bg-[#f6f6f8] dark:bg-[#131418] dark:text-gray-300"
        >
            <div class="flex flex-row items-center gap-1 md:gap-5" v-show="user">
                <div class="relative" data-te-dropdown-ref>
                    <button
                        class="flex items-center whitespace-nowrap rounded bg-indigo-500 dark:bg-indigo-700 p-3 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] motion-reduce:transition-none dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                        type="button"
                        id="dropdownMenuButton1"
                        data-te-dropdown-toggle-ref
                        aria-expanded="false"
                        data-te-ripple-init
                        data-te-ripple-color="light"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            data-slot="icon"
                            class="w-6 h-6"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                            />
                        </svg>
                    </button>
                    <ul
                        class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                        aria-labelledby="dropdownMenuButton1"
                        data-te-dropdown-menu-ref
                    >
                        <li>
                            <Link
                                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                :href="route('orders.index')"
                                data-te-dropdown-item-ref
                                >الأوردرات السابقة</Link
                            >
                        </li>
                        <li>
                            <Link
                                v-if="user && user.is_admin == '1'"
                                data-te-dropdown-item-ref
                                :href="route('admin.report.index')"
                                as="button"
                                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                                >لوحة التحكم</Link
                            >
                        </li>
                        <li>
                            <Link

                                data-te-dropdown-item-ref
                                :href="route('auth.index')"
                                as="button"
                                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                            >
                                تسجيل الخروج
                            </Link>
                        </li>
                    </ul>
                </div>

                <DarkLight
                    :dark-mode="darkMode"
                    @toggle="
                        darkMode = !darkMode;
                        toggleDarkMode();
                    "
                />
            </div>
            <DarkLight v-if="!user"
                    :dark-mode="darkMode"
                    @toggle="
                        darkMode = !darkMode;
                        toggleDarkMode();
                    "
                />
            <div v-if="user" dir="rtl" class="line-clamp-1 text-ellipsis">
                أهلا {{ user.name }}
            </div>
            <Link
                class="flex flex-row gap-1 md:gap-5 items-center"
                :href="route('home')"
            >
                <p
                    class="hidden md:block text-xl font-semibold whitespace-nowrap"
                >
                    إدارة الطـــــاولات
                </p>
                <img src="/storage/images/logo.webp" alt="" class="w-12 h-12" />
            </Link>
        </div>
        <div
            class="flex-1 flex flex-col overflow-auto bg-[#f6f6f8] dark:bg-[#131418] dark:text-gray-300"
        >
            <slot></slot>
        </div>
    </div>
    <GoToAdminModal :show="show" @close="toggle" />
</template>
<script setup>
import DarkLight from "@/Pages/NewHome/Components/DarkLight.vue";
import GoToAdminModal from "@/Pages/NewHome/Components/GoToAdminModal.vue";
import { ref, onMounted, computed } from "vue";
import { usePage, Link } from "@inertiajs/vue3";
import { Ripple, initTE, Dropdown } from "tw-elements";
const page = usePage();
const user = computed(() => page.props.user);
const show = ref(false);
const toggle = () => {
    show.value = !show.value;
};
const darkMode = ref(
    getCookieValue("dark-light") == "not"
        ? false
        : getCookieValue("dark-light") == "true"
);
function getCookieValue(cookieName) {
    const cookies = document.cookie.split(";");
    for (let i = 0; i < cookies.length; i++) {
        const cookie = cookies[i].trim();
        if (cookie.startsWith(`${cookieName}=`)) {
            return decodeURIComponent(cookie.substring(cookieName.length + 1));
        }
    }
    return "";
}
const toggleDarkMode = () => {
    if (darkMode.value) {
        document.cookie = "dark-light=true";
        var body = document.querySelector("body");
        body.classList.toggle("dark");
    } else {
        document.cookie = "dark-light=false";
        var body = document.querySelector("body");
        body.classList.toggle("dark");
    }
};
if (
    darkMode.value === true ||
    (getCookieValue("dark-light") == "not" &&
        window.matchMedia("(prefers-color-scheme: dark)").matches)
) {
    var body = document.querySelector("body");
    body.classList.add("dark");
    darkMode.value = true;
} else {
    var body = document.querySelector("body");
    body.classList.remove("dark");
}
onMounted(() => {
    initTE({ Ripple, Dropdown });
});
</script>
