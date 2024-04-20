<template>
    <div class="flex flex-col min-h-screen">
        <div
            class="hidden md:block text-2xl text-black w-full z-50 sticky top-0 dark:text-[#696f79] bg-[#fafafa] dark:bg-[#1e1f24]"
            dir="rtl"
        >
            <nav
                class="px-6 py-2 mx-auto lg:flex lg:justify-between lg:items-center"
            >
                <div
                    class="flex flex-row items-center justify-between w-full lg:w-1/4 lg:pl-20"
                >
                    <div class="w-full flex items-center justify-between">
                        <Link
                            :href="route('home')"
                            @click="
                                showMenu = false;
                                showSearch = false;
                            "
                        >
                            <img
                                :src="$page.props.logo"
                                alt=""
                                style="height: 3rem"
                            />
                        </Link>
                        <Link
                            :href="route('cart.index')"
                            :class="
                                location == route('cart.index')
                                    ? 'text-2xl font-bold'
                                    : ''
                            "
                            id="cart"
                            @click="
                                showMenu = false;
                                showSearch = false;
                            "
                        >
                            <div class="flex flex-row gap-1 items-center">
                                <p>السلة</p>
                                <div class="relative">
                                    <p
                                        id="cartItems"
                                        v-show="cartItems != 0"
                                        class="absolute -top-1 -right-1 bg-red-400 dark:bg-red-700 text-gray-200 text-xs text-center rounded-full h-4 w-4"
                                    >
                                        {{ cartItems }}
                                    </p>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="w-8 h-8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
                                        />
                                    </svg>
                                </div>
                            </div>
                        </Link>
                        <div class="flex gap-2 lg:hidden lg:w-0">
                            <button
                                @click="toggleSearch"
                                type="button"
                                class="text-gray-950 hover:text-gray-800 focus:outline-none focus:text-gray-800"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                                    />
                                </svg>
                            </button>
                            <button
                                @click="toggleNav"
                                type="button"
                                class="text-gray-950 hover:text-gray-800 focus:outline-none focus:text-gray-800"
                            >
                                <svg
                                    viewBox="0 0 24 24"
                                    class="w-6 h-6 fill-current"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"
                                    ></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                </div>

                <!-- Mobile Menu open: "block", Menu closed: "hidden" -->
                <ul
                    :class="showMenu ? 'flex' : 'hidden'"
                    class="flex-col-reverse mt-4 lg:flex lg:flex-row lg:items-center lg:mt-0 lg:justify-between lg:w-full"
                >
                    <div
                        dir="rtl"
                        class="flex flex-col gap-2 lg:flex-row lg:items-center lg:gap-5 lg:mt-0 lg:justify-end w-full z-30"
                    >
                        <li>
                            <Link
                                :href="route('home')"
                                :class="
                                    location == route('home')
                                        ? 'text-2xl font-bold'
                                        : ''
                                "
                                @click="
                                    showMenu = false;
                                    showSearch = false;
                                "
                                >الرئيسية</Link
                            >
                        </li>
                        <li>
                            <Link
                                :href="route('promotion.index')"
                                :class="
                                    location == route('promotion.index')
                                        ? 'text-2xl font-bold'
                                        : ''
                                "
                                @click="
                                    showMenu = false;
                                    showSearch = false;
                                "
                                >العروض</Link
                            >
                        </li>
                        <!-- <li
                            v-for="category in $page.props.categories2"
                            :key="category.id"
                            class="text-start lg:text-center"
                        >
                            <Link
                                :href="route('category.show', category.id)"
                                :class="
                                    location ==
                                    route('category.show', category.id)
                                        ? 'text-2xl font-bold'
                                        : ''
                                "
                                @click="
                                    showMenu = false;
                                    showSearch = false;
                                "
                                >{{ category.cat_title }}</Link
                            >
                        </li> -->
                        <li class="flex items-center">
                            <input
                                id="dark-input"
                                type="checkbox"
                                v-model="darkMode"
                                @change="toggleDarkMode"
                            />
                            <label id="dark-label" for="dark-input">
                                <svg
                                    version="1.1"
                                    class="sun"
                                    id="Capa_1"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    x="0px"
                                    y="0px"
                                    viewBox="0 0 511 511"
                                    style="enable-background: new 0 0 511 511"
                                    xml:space="preserve"
                                >
                                    <g>
                                        <path
                                            d="M255.5,144C194.019,144,144,194.019,144,255.5S194.019,367,255.5,367S367,316.981,367,255.5S316.981,144,255.5,144z
                          M255.5,352c-53.21,0-96.5-43.29-96.5-96.5s43.29-96.5,96.5-96.5s96.5,43.29,96.5,96.5S308.71,352,255.5,352z"
                                        />
                                        <path
                                            d="M255.5,119c4.142,0,7.5-3.357,7.5-7.5V7.5c0-4.143-3.358-7.5-7.5-7.5S248,3.357,248,7.5v104
                          C248,115.643,251.358,119,255.5,119z"
                                        />
                                        <path
                                            d="M255.5,392c-4.142,0-7.5,3.357-7.5,7.5v104c0,4.143,3.358,7.5,7.5,7.5s7.5-3.357,7.5-7.5v-104
                          C263,395.357,259.642,392,255.5,392z"
                                        />
                                        <path
                                            d="M503.5,248h-104c-4.142,0-7.5,3.357-7.5,7.5s3.358,7.5,7.5,7.5h104c4.142,0,7.5-3.357,7.5-7.5S507.642,248,503.5,248z"
                                        />
                                        <path
                                            d="M119,255.5c0-4.143-3.358-7.5-7.5-7.5H7.5c-4.142,0-7.5,3.357-7.5,7.5s3.358,7.5,7.5,7.5h104
                          C115.642,263,119,259.643,119,255.5z"
                                        />
                                        <path
                                            d="M357.323,161.177c1.919,0,3.839-0.732,5.303-2.196l73.539-73.539c2.929-2.93,2.929-7.678,0-10.607
                          c-2.929-2.928-7.678-2.928-10.606,0l-73.539,73.539c-2.929,2.93-2.929,7.678,0,10.607
                          C353.484,160.444,355.404,161.177,357.323,161.177z"
                                        />
                                        <path
                                            d="M148.374,352.02l-73.539,73.539c-2.929,2.93-2.929,7.678,0,10.607c1.464,1.464,3.384,2.196,5.303,2.196
                          s3.839-0.732,5.303-2.196l73.539-73.539c2.929-2.93,2.929-7.678,0-10.607C156.051,349.092,151.302,349.092,148.374,352.02z"
                                        />
                                        <path
                                            d="M148.374,158.98c1.464,1.464,3.384,2.196,5.303,2.196s3.839-0.732,5.303-2.196c2.929-2.93,2.929-7.678,0-10.607
                          L85.441,74.834c-2.929-2.928-7.678-2.928-10.606,0c-2.929,2.93-2.929,7.678,0,10.607L148.374,158.98z"
                                        />
                                        <path
                                            d="M362.626,352.02c-2.929-2.928-7.678-2.928-10.606,0c-2.929,2.93-2.929,7.678,0,10.607l73.539,73.539
                          c1.464,1.464,3.384,2.196,5.303,2.196s3.839-0.732,5.303-2.196c2.929-2.93,2.929-7.678,0-10.607L362.626,352.02z"
                                        />
                                    </g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                </svg>
                                <svg
                                    version="1.1"
                                    class="moon"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    enable-background="new 0 0 512 512"
                                >
                                    <g>
                                        <g>
                                            <path
                                                d="m275.4,500.7c-135,0-244.7-109.8-244.7-244.7 1.06581e-14-134.9 109.8-244.7 244.7-244.7 8.2,0 16.4,0.4 24.6,1.2 7.2,0.7 13.5,5.2 16.5,11.7s2.4,14.2-1.6,20.2c-23,33.8-35.2,73.3-35.2,114.2 0,105 78.7,192.2 183.2,202.6 7.2,0.7 13.5,5.2 16.5,11.7 3.1,6.5 2.4,14.2-1.6,20.2-45.8,67.4-121.4,107.6-202.4,107.6zm-12.5-448c-106.5,6.5-191.2,95.2-191.2,203.3 1.42109e-14,112.3 91.4,203.7 203.7,203.7 56.4,0 109.6-23.4 147.8-63.7-46.2-11.7-88.1-36.8-120.8-72.6-41.1-45.2-63.8-103.6-63.8-164.6 0.1-37.1 8.4-73.2 24.3-106.1z"
                                            />
                                        </g>
                                    </g>
                                </svg>
                            </label>
                        </li>
                        <li :class="showMenu ? 'hidden' : ''">
                            <button
                                @click="toggleSearch"
                                type="button"
                                class="text-gray-950 hover:text-gray-800 focus:outline-none focus:text-gray-800"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="w-6 h-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                                    />
                                </svg>
                            </button>
                        </li>
                    </div>
                </ul>
                <Collapse :when="showSearch" class="v-collapse"
                    ><form
                        @submit.prevent="search"
                        class="p-2 flex flex-row justify-center gap-1"
                    >
                        <input
                            class="input search-box"
                            type="search"
                            name=""
                            id=""
                            placeholder="ابحث عن الوجبة"
                            v-model="form.search"
                        />
                        <input
                            class="btn-primary text-base"
                            type="submit"
                            value="بحث"
                        />
                    </form>
                </Collapse>
            </nav>
        </div>
        <div
            class="px-4 sticky top-4 z-50 h-0"
            :class="addToCart ? 'animate-flip-down' : 'hidden'"
        >
            <div
                class="flex items-center w-full justify-center border dark:border-gray-600 p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
                role="alert"
            >
                <div class="pl-4 text-sm font-normal text-center" dir="rtl">
                    تم اضافة الوجبة {{ mealRef }} الى السلة بنجاح
                </div>
            </div>
        </div>

        <div
            class="px-4 sticky top-4 z-50 h-0"
            :class="error ? 'animate-flip-down' : 'hidden'"
        >
            <div
                class="flex items-center w-full justify-center border dark:border-gray-600 p-4 text-gray-500 bg-red-50 dark:bg-red-900 rounded-lg shadow dark:text-red-400"
                role="alert"
            >
                <div class="pl-4 text-sm font-normal text-center" dir="rtl">
                    تم مسح الوجبة {{ mealRef }} بنجاح من السلة
                </div>
            </div>
        </div>
        <div
            dir="rtl"
            class="md:hidden fixed top-0 left-0 z-10 bg-[#f6f6f8] dark:bg-[#131418] w-full"
        >
            <Collapse :when="showSearch" class="v-collapse"
                ><form
                    @submit.prevent="search"
                    class="p-2 flex flex-row justify-center gap-1"
                >
                    <input
                        class="input search-box"
                        type="search"
                        name=""
                        id=""
                        placeholder="ابحث عن الوجبة"
                        v-model="form.search"
                    />
                    <input
                        class="btn-primary text-base"
                        type="submit"
                        value="بحث"
                    />
                </form>
            </Collapse>
        </div>

        <div
            @click="
                showMenu = false;
                showSearch = false;
            "
            class="flex flex-col flex-grow overflow-y-auto bg-[#f6f6f8] dark:bg-[#131418] dark:text-gray-300 pb-16 md:pb-0"
        >
            <slot />
        </div>
        <div
            dir="rtl"
            class="sm:block md:hidden fixed bottom-0 left-0 z-[99] w-full h-16 bg-[#fafafa] dark:bg-[#1e1f24] dark:text-gray-300"
        >
            <div class="grid grid-cols-5 h-full max-w-lg mx-auto font-medium">
                <button
                    data-te-ripple-init
                    data-te-ripple-color="light"
                    type="button"
                    @click="
                        darkMode = !darkMode;
                        toggleDarkMode();
                    "
                    class="flex flex-col items-center justify-center text-gray-950 dark:text-[#696f79]"
                >
                    <svg
                        v-if="darkMode"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-10 h-10"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"
                        />
                    </svg>
                    <svg
                        v-else
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-8 h-8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"
                        />
                    </svg>
                </button>
                <Link
                    data-te-ripple-init
                    data-te-ripple-color="light"
                    :href="route('cart.index')"
                    data-te-offcanvas-dismiss
                    data-te-target="#offcanvasExample"
                    as="button"
                    :class="
                        location == route('cart.index')
                            ? 'text-2xl font-bold'
                            : ''
                    "
                    class="flex justify-center items-center"
                    id="cart"
                    @click="
                        showMenu = false;
                        showSearch = false;
                    "
                >
                    <div class="flex flex-col-reverse items-center py-1">
                        <p
                            class="text-xs"
                            :class="
                                location == route('cart.index')
                                    ? 'dark:text-[#e5e6e7] text-[#5e33ff]'
                                    : 'dark:text-[#696f79]'
                            "
                        >
                            السلة
                        </p>
                        <div class="relative">
                            <p
                                id="cartItems"
                                v-show="cartItems != 0"
                                class="absolute -top-1 -right-1 bg-[#582efd] text-gray-200 text-xs text-center rounded-full h-4 w-4"
                            >
                                {{ cartItems }}
                            </p>
                            <svg
                                :class="
                                    location == route('cart.index')
                                        ? 'dark:text-[#e5e6e7] text-[#5e33ff]'
                                        : 'dark:text-[#696f79]'
                                "
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="w-8 h-8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
                                />
                            </svg>
                        </div>
                    </div>
                </Link>
                <Link
                    data-te-ripple-init
                    data-te-ripple-color="light"
                    as="button"
                    :href="route('home')"
                    data-te-offcanvas-dismiss
                    data-te-target="#offcanvasExample"
                    @click="
                        showMenu = false;
                        showSearch = false;
                    "
                    class="flex flex-col justify-center items-center"
                >
                    <svg
                        :class="
                            location == route('home')
                                ? 'dark:text-[#e5e6e7] text-[#5e33ff]'
                                : 'dark:text-[#696f79]'
                        "
                        class="w-5 h-5 mb-2"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                    >
                        <path
                            d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"
                        />
                    </svg>
                    <p
                        :class="
                            location == route('home')
                                ? 'dark:text-[#e5e6e7] text-[#5e33ff]'
                                : 'dark:text-[#696f79]'
                        "
                        class="text-xs"
                    >
                        الرئيسية
                    </p>
                </Link>
                <button
                    data-te-ripple-init
                    data-te-ripple-color="light"
                    data-te-offcanvas-dismiss
                    data-te-target="#offcanvasExample"
                    @click="toggleSearch"
                    type="button"
                    class="flex flex-col items-center justify-center text-gray-950 hover:text-gray-800 dark:text-gray-300 dark:focus:text-gray-400 focus:outline-none focus:text-gray-800"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-5 h-5 mb-2"
                        :class="
                            showSearch
                                ? 'dark:text-[#e5e6e7] text-[#5e33ff]'
                                : 'dark:text-[#696f79]'
                        "
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"
                        />
                    </svg>
                    <p
                        :class="
                            showSearch
                                ? 'dark:text-[#e5e6e7] text-[#5e33ff]'
                                : 'dark:text-[#696f79]'
                        "
                        class="text-xs"
                    >
                        بحث
                    </p>
                </button>
                <button
                    data-te-offcanvas-toggle
                    data-te-target="#offcanvasExample"
                    aria-controls="offcanvasExample"
                    data-te-ripple-init
                    data-te-ripple-color="light"
                    type="button"
                    class="flex flex-col items-center justify-center text-gray-950 dark:text-[#696f79]"
                >
                    <svg viewBox="0 0 24 24" class="w-6 h-6 fill-current">
                        <path
                            fill-rule="evenodd"
                            d="M4 5h16a1 1 0 0 1 0 2H4a1 1 0 1 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2zm0 6h16a1 1 0 0 1 0 2H4a1 1 0 0 1 0-2z"
                        ></path>
                    </svg>
                    <p class="text-xs dark:text-[#696f79]">المزيد</p>
                </button>
            </div>
        </div>

        <!-- offcanvas -->
        <div
            class="invisible fixed left-0 top-0 bottom-16 z-[1045] flex w-2/3 max-w-full -translate-x-full flex-col border-none bg-[#fafafa] dark:bg-[#1e1f24] bg-clip-padding text-neutral-700 shadow-sm outline-none transition duration-300 ease-in-out dark:text-neutral-200 [&[data-te-offcanvas-show]]:transform-none"
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
                    المزيد
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
                <ul class="flex flex-col dark:text-[#696f79] gap-1">
                    <li>
                        <Link
                            class="py-3 w-full"
                            :href="route('promotion.index')"
                            :class="
                                location == route('promotion.index')
                                    ? 'text-xl  text-[#5e33ff]  dark:text-[#e5e6e7] dark:bg-[#696f79]'
                                    : 'dark:border-[#696f79]'
                            "
                            as="button"
                            data-te-offcanvas-dismiss
                            >العروض</Link
                        >
                    </li>
                    <!-- <li
                        v-for="category in $page.props.categories2"
                        :key="category.id"
                        class="text-start lg:text-center"
                    >
                        <Link
                            class="py-3  w-full"
                            :href="route('category.show', category.id)"
                            :class="
                                location == route('category.show', category.id)
                                    ? 'text-xl text-[#5e33ff]  dark:text-[#e5e6e7] dark:bg-[#696f79]'
                                    : 'dark:border-[#696f79]'
                            "
                            @click="
                                showMenu = false;
                                showSearch = false;
                            "
                            as="button"
                            data-te-offcanvas-dismiss
                            >{{ category.cat_title }}</Link
                        >
                    </li> -->
                </ul>
            </div>
        </div>

        <!-- <footer
            dir="rtl"
            class="text-center text-black w-full"
            style="background: #ffa502"
        >
            <section class="mt-6">
                <div
                    class="container text-center mx-auto grid grid-cols-1 md:grid-cols-2 gap-8"
                >
                    <div class="mx-auto mb-2 px-2">
                        <h6 class="text-xl font-bold my-4">من نحن</h6>
                        <p class="text-lg leading-7">
                            فى سنة 1994 انشأ خالد فتح الله وحمدى فتح الله أول
                            سوبر ماركت للبيع للمستهلك مباشرةً بسعر الجملة. وهكذا
                            كانت البداية عن طريق أفتتاح أول فرع من فروع فتح الله
                            جملة ماركت في سان استيفانو. اول سوبر ماركت يبيع
                            للمستهلك بسعر الجملة أحدث ضجة في عالم البيع المباشر
                            للمستهلك من حيث تنوع المنتجات بأوفر الأسعار وأحترام
                            المستهلك
                        </p>
                    </div>
                    <div
                        dir="rtl"
                        class="mx-auto mb-2 flex flex-col items-center gap-4"
                    >
                        <h6 class="text-xl font-bold mt-4">تواصل معنا</h6>
                        <div class="flex items-center gap-2 justify-center">
                            <img
                                :src="$page.props.location_icon"
                                class="h-6 w-6"
                            />
                            <p class="text-lg leading-7 w-3/4 md:w-auto">
                                كيلو ٢٨ طريق اسكندرية - القاهرة الصحراوي امام
                                مرور مرغم
                            </p>
                        </div>

                        <p class="text-lg leading-7 flex items-center gap-2">
                            <img :src="$page.props.email" />
                            info-hq@gomlamarket.com
                        </p>
                        <p class="text-lg leading-7 flex items-center gap-2">
                            <img
                                :src="$page.props.phone"
                                style="transform: scaleX(-1)"
                            />
                            03-4702803 03-4702804
                        </p>
                    </div>
                </div>
            </section>
        
            <div class="text-center p-4">
                جميع الحقوق محفوظة © 2023 جملة ماركت
            </div>
        </footer> -->
    </div>
</template>
<script setup>
import { ref, provide, watch, onMounted } from "vue";
import { computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { Offcanvas, Ripple, Dropdown, initTE, Modal } from "tw-elements";
import { Link } from "@inertiajs/vue3";
import { Collapse } from "vue-collapsed";

const isRunnig = ref(false);
const addToCart = ref(false);
const error = ref(false);
const mealRef = ref("");
const timer = ref(null);
const cartItems = ref(0);
const form = useForm({
    search: "",
});
const search = () => {
    form.get(route("search.index"));
    toggleSearch();
};
watch(addToCart, (value) => {
    if (isRunnig.value) {
        clearTimeout(timer.value);
        addToCart.value = true;
        error.value = false;
    }
    if (value) {
        timer.value = setTimeout(() => {
            addToCart.value = !addToCart.value;
            isRunnig.value = !isRunnig.value;
        }, 2000);
        isRunnig.value = true;
    }
});
watch(error, (v) => {
    if (isRunnig.value) {
        clearTimeout(timer.value);
        error.value = true;
        addToCart.value = false;
    }
    if (v) {
        timer.value = setTimeout(() => {
            error.value = !error.value;
            isRunnig.value = !isRunnig.value;
        }, 2000);
        isRunnig.value = true;
    }
});
onMounted(() => {
    initTE({ Offcanvas, Ripple, Dropdown, Modal });
    let data = sessionStorage.getItem("cart");
    let myArray = JSON.parse(data);
    if (myArray == null) {
        myArray = [];
    }
    cartItems.value = myArray.length;
});
const showMenu = ref(false);
const page = usePage();
const location = computed(() => page.props.ziggy.location);
const toggleNav = () => (showMenu.value = !showMenu.value);
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
const showSearch = ref(false);
const toggleSearch = () => {
    showSearch.value = !showSearch.value;
    setTimeout(() => {
        const search = document.getElementsByClassName("search-box");
        Array.from(search).forEach((e) => {
            if (e.checkVisibility()) {
                e.focus();
            }
        });
    }, 100);
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
provide("darkMode", darkMode);
provide("mealRef", mealRef);
provide("addToCart", addToCart);
provide("error", error);
provide("cartItems", cartItems);
</script>
<style scoped>
.v-collapse {
    transition: height var(--vc-auto-duration) cubic-bezier(0.33, 1, 0.68, 1);
}
</style>
