<template>
    <!-- main navbar  -->

    <AdminNav :links="links" />

    <!-- button for small screen  -->
    <button
        class="w-8 h-8 fixed top-0 left-0 bg-gray-200 dark:bg-zinc-800 dark:text-gray-300"
        data-te-offcanvas-toggle
        data-te-target="#offcanvasExample"
        aria-controls="offcanvasExample"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="currentColor"
            viewBox="0 0 24 24"
            stroke-width="3"
            stroke="currentColor"
            class="w-4 h-4 mx-auto"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
            />
        </svg>
    </button>
    <!-- small screen sidebar -->

    <div
        id="slim-content"
        class="h-screen overflow-auto pt-8 md:pt-0 bg-[#f6f6f8] dark:bg-[#131418] dark:text-gray-300"
    >
        <div
            v-if="success"
            class="mx-2 mt-2 flex rounded-md justify-center p-2 bg-green-300 dark:bg-green-800"
        >
            {{ success }}
        </div>
        <div
            v-if="error"
            class="mx-2 mt-2 flex rounded-md justify-center p-2 bg-red-300 dark:bg-red-800"
        >
            {{ error }}
        </div>

        <slot></slot>
    </div>
    <!-- Sidenav -->
</template>
<script setup>
import { Sidenav, initTE, Offcanvas, Collapse, Ripple } from "tw-elements";
import { onMounted, computed, ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { onUnmounted } from "vue";
import AdminNav from "@/Layouts/Components/AdminNav.vue";
import ZonesIcon from "@/Icons/ZonesIcon.vue";
import ImageIcon from "@/Icons/ImageIcon.vue";
import CategoryIcon from "@/Icons/CategoryIcon.vue";
import ProfileIconVue from "@/Icons/ProfileIcon.vue";
import ReportsIcon from "@/Icons/ReportsIcon.vue";
import MoneyIcon from "@/Icons/MoneyIcon.vue";
import UsersIconVue from "@/Icons/UsersIcon.vue";
const user = usePage().props.user;
const success = computed(() => usePage().props.flash.success);
const error = computed(() => usePage().props.flash.error);
let setMode2 = null;
const links = [
    {
        name: "التقارير",
        icon: ReportsIcon,
        iconClass: "w-4 h-4",
        list: [
            {
                route: "admin.report.index",
                name: "التقارير",
            },
        ],
    },
    {
        name: "المناطق",
        icon: ZonesIcon,
        iconClass: "w-4 h-4",
        list: [
            {
                route: "admin.zone.index",
                name: "المناطق",
            },
        ],
    },
    {
        name: "الصورة البديلة",
        icon: ImageIcon,
        iconClass: "w-6 h-6",
        list: [
            {
                route: "admin.placeholder_img.index",
                name: "الصورة البديلة",
            },
        ],
    },
    {
        name: "الأصناف",
        icon: CategoryIcon,
        iconClass: "w-4 h-4",
        list: [
            {
                route: "admin.print_group.index",
                name: "المجموعات",
            },
            {
                route: "admin.category.index",
                name: "الأصناف",
            },
        ],
    },
    {
        name: "الخدمات بالنسبة",
        icon: MoneyIcon,
        iconClass: "h-5 w-5",
        list: [
            {
                route: "admin.service.index",
                name: "الخدمة",
            },
        ],
    },
    {
        name: "المستخدمين",
        icon: UsersIconVue,
        iconClass: "h-5 w-5",
        list: [
            {
                route: "admin.users.index",
                name: "المستخدمين",
            },
        ],
    },
    {
        name: user.name,
        icon: ProfileIconVue,
        iconClass: "h-5 w-5",
        list: [
            {
                route: "home",
                name: "العودة",
            },
            {
                route: "auth.index",
                name: "تسجيل الخروج",
            },
        ],
    },
];

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
    initTE({ Sidenav, Offcanvas, Collapse, Ripple });
    const sidenav = document.getElementById("sidenav-4");

    const instance = new Sidenav(sidenav);
    document.getElementById("slim-toggler").addEventListener("click", () => {
        instance.toggleSlim();
    });

    let innerWidth2 = null;

    setMode2 = (e) => {
        // Check necessary for Android devices
        if (window.innerWidth === innerWidth2) {
            return;
        }

        innerWidth2 = window.innerWidth;

        if (instance && window.innerWidth > instance.getBreakpoint("sm")) {
            instance.show();
        } else {
            instance.hide();
        }
    };
    if (instance && window.innerWidth > instance.getBreakpoint("sm")) {
        setMode2();
    }
    // Event listeners
    window.addEventListener("resize", setMode2);

    // const instanceMode = Sidenav.getInstance(
    //     document.getElementById("sidenav-4")
    // );
    // const modes = ["push", "over", "side"];

    // modes.forEach((mode) => {
    //     const modeSwitch = document.getElementById(mode);
    //     modeSwitch.addEventListener("click", () => {
    //         const instance = Sidenav.getInstance(
    //             document.getElementById("sidenav-4")
    //         );
    //         instance.changeMode(mode);
    //         modes.forEach((el) => {
    //             if (el === mode) {
    //                 ["text-blue-600", "border-blue-600"].forEach((item) =>
    //                     modeSwitch.classList.remove(item)
    //                 );
    //                 modeSwitch.className +=
    //                     " bg-blue-600 text-white hover:bg-blue-700 active:bg-blue-800 focus:bg-blue-700 border-transparent";
    //             } else {
    //                 const node = document.getElementById(el);
    //                 node.className += " text-blue-600 border-blue-600";
    //                 [
    //                     "bg-blue-600",
    //                     "text-white",
    //                     "hover:bg-blue-700",
    //                     "active:bg-blue-800",
    //                     "focus:bg-blue-700",
    //                     "border-transparent",
    //                 ].forEach((item) => node.classList.remove(item));
    //             }
    //         });
    //     });
    // });
});
onUnmounted(() => {
    window.removeEventListener("resize", setMode2);
});
</script>
