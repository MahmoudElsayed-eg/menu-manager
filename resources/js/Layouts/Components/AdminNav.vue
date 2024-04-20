<template>
    <nav
        dir="rtl"
        id="sidenav-4"
        class="hidden group md:fixed left-0 top-0 z-[1035] h-screen w-60 -translate-x-full overflow-hidden bg-gray-200 dark:bg-zinc-800 shadow-[0_4px_12px_0_rgba(0,0,0,0.07),_0_2px_4px_rgba(0,0,0,0.05)] data-[te-sidenav-slim='true']:hidden data-[te-sidenav-slim-collapsed='true']:w-[77px] data-[te-sidenav-slim='true']:w-[77px] data-[te-sidenav-hidden='false']:translate-x-0 [&[data-te-sidenav-slim-collapsed='true'][data-te-sidenav-slim='false']]:hidden [&[data-te-sidenav-slim-collapsed='true'][data-te-sidenav-slim='true']]:[display:unset]"
        data-te-sidenav-init
        data-te-sidenav-hidden="true"
        data-te-sidenav-mode="side"
        data-te-sidenav-slim="true"
        data-te-sidenav-content="#slim-content"
        data-te-sidenav-slim-collapsed="true"
    >
        <ul class="relative m-0 list-none px-[0.2rem]" data-te-sidenav-menu-ref>
            <li class="relative">
                <a
                    class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                    data-te-sidenav-link-ref
                    aria-haspopup="true"
                    id="slim-toggler"
                >
                    <span
                        class="ml-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            stroke-width="3"
                            stroke="currentColor"
                            class="w-4 h-4"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                            />
                        </svg>
                    </span>
                    <span
                        class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                        data-te-sidenav-slim="false"
                        >لوحة التحكم</span
                    >
                </a>
            </li>
            <li v-for="(item, index) in links" :key="index" class="relative">
                <a
                    class="flex h-12 cursor-pointer items-center truncate rounded-[5px] px-6 py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                    data-te-sidenav-link-ref
                >
                    <span
                        class="ml-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300"
                    >
                        <component
                            :is="item.icon"
                            :class="item.iconClass"
                        ></component>
                    </span>
                    <span
                        class="group-[&[data-te-sidenav-slim-collapsed='true']]:data-[te-sidenav-slim='false']:hidden"
                        data-te-sidenav-slim="false"
                        >{{ item.name }}</span
                    >
                    <span
                        class="absolute left-0 transition-transform duration-300 ease-linear motion-reduce:transition-none [&>svg]:text-gray-600 dark:[&>svg]:text-gray-300"
                        data-te-sidenav-rotate-icon-ref
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </span>
                </a>
                <ul
                    class="show !visible relative m-0 hidden list-none p-0 data-[te-collapse-show]:block"
                    data-te-sidenav-collapse-ref
                >
                    <li
                        v-for="(x, index) in item.list"
                        :key="index"
                        class="relative"
                    >
                        <Link
                            :href="route(x.route)"
                            class="flex h-6 cursor-pointer items-center truncate rounded-[5px] py-4 pl-[3.4rem] pr-6 text-[0.78rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                            data-te-sidenav-link-ref
                            >{{ x.name }}</Link
                        >
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <div
        dir="rtl"
        class="invisible fixed bottom-0 left-0 top-0 z-[1045] flex w-1/2 max-w-full -translate-x-full flex-col border-none bg-white bg-clip-padding text-neutral-700 shadow-sm outline-none transition duration-300 ease-in-out dark:bg-neutral-800 dark:text-neutral-200 [&[data-te-offcanvas-show]]:transform-none"
        tabindex="-1"
        id="offcanvasExample"
        aria-labelledby="offcanvasExampleLabel"
        data-te-offcanvas-init
    >
        <div class="flex items-center justify-between p-4">
            <h5
                class="mb-0 font-semibold leading-normal"
                id="offcanvasExampleLabel"
            >
                لوحة التحكم
            </h5>
            <button
                type="button"
                class="box-content rounded-none border-none opacity-50 hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                data-te-offcanvas-dismiss
            >
                <span
                    class="w-[1em] focus:opacity-100 disabled:pointer-events-none disabled:select-none disabled:opacity-25 [&.disabled]:pointer-events-none [&.disabled]:select-none [&.disabled]:opacity-25"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="h-6 w-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </span>
            </button>
        </div>
        <div class="flex-grow overflow-y-auto p-4">
            <template v-for="(i, index) in links">
                <a
                    class="flex h-12 cursor-pointer items-center truncate rounded-[5px] py-4 text-[0.875rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                    data-te-collapse-init
                    data-te-ripple-init
                    data-te-ripple-color="light"
                    :href="'#sectionCollapse' + index"
                    role="button"
                    aria-expanded="false"
                    aria-controls="sectionCollapse"
                >
                    <span
                        class="ml-4 [&>svg]:h-4 [&>svg]:w-4 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300"
                    >
                        <component
                            :is="i.icon"
                            :class="i.iconClass"
                        ></component>
                    </span>
                    <span>{{ i.name }}</span>
                    <span
                        class="absolute left-0 transition-transform duration-300 dark:[&>svg]:text-gray-300 ease-linear motion-reduce:transition-none [&>svg]:text-gray-600"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                            class="h-5 w-5"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </span>
                </a>
                <div
                    class="!visible hidden"
                    :id="'sectionCollapse'+index"
                    data-te-collapse-item
                >
                    <div
                        class="block rounded-lg bg-white shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700 dark:text-neutral-50"
                    >
                        <ul class="relative m-0 list-none p-0">
                            <li  v-for="(x, ix) in i.list"
                        :key="ix" class="relative">
                                <Link
                                    :href="route(x.route)"
                                    as="button"
                                    data-te-offcanvas-dismiss
                                    class="flex h-6 cursor-pointer items-center truncate rounded-[5px] py-4 pl-[3.4rem] pr-6 text-[0.78rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
                                    >{{ x.name }}</Link
                                >
                            </li>
                        </ul>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    links: Array,
});
</script>
