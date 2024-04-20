<template>
    <h1 class="text-center font-medium text-3xl">{{ meal.meal_name }}</h1>

    <CarouselGallery :images="meal.meal_picture" />

    <h3
        dir="rtl"
        v-if="meal.promotion?.status && meal.promotion.promo_type > 2"
        class="py-1 text-center text-red-400 font-medium text-base"
    >
        {{ meal.promotion.promo_name }}
    </h3>
    <h3
        dir="rtl"
        v-if="
            meal.sizes.length > 0 &&
            meal.sizes[sizesRef].promotion?.status &&
            meal.sizes[sizesRef].promotion.promo_type > 2
        "
        class="py-1 text-center text-red-400 font-medium text-base"
    >
        {{ meal.sizes[sizesRef].promotion.promo_name }}
    </h3>

    <div class="flex flex-col items-center justify-center gap-3">
        <p
            v-if="meal.sizes.length > 0"
            dir="rtl"
            class="text-center"
            v-html="
                meal.sizes[sizesRef].promotion?.status
                    ? promo(
                          meal.sizes[sizesRef].size_price,
                          meal.sizes[sizesRef].promotion
                      )
                    : meal.sizes[sizesRef].size_price + ' جنيه'
            "
        ></p>
        <p
            v-else
            dir="rtl"
            class="text-center"
            v-html="
                meal.promotion?.status
                    ? promo(meal.meal_price, meal.promotion)
                    : meal.meal_price + ' جنيه'
            "
        ></p>
        <div class="text-center">{{ meal.meal_description }}</div>

        <div class="flex flex-row gap-2 items-center">
            <img
                :src="darkMode ? minus_white : minus_black"
                alt=""
                @click="minus(meal.id)"
                class="h-8 w-8"
            />

            <input
                dir="rtl"
                type="number"
                name=""
                :id="meal.id"
                value="1"
                min="1"
                class="input"
            />
            <img
                :src="darkMode ? plus_white : plus_black"
                alt=""
                @click="add(meal.id)"
                class="h-8 w-8"
            />
        </div>
        <div
            v-if="meal.sizes.length > 0"
            class="flex flex-col items-center lg:flex-1"
        >
            <div class="flex flex-col items-end gap-1">
                <div
                    class="flex flex-row gap-1 items-center"
                    v-for="(size, index) in meal.sizes"
                >
                    <label :for="'M' + meal.id + 'S' + size.id">{{
                        size.size_name
                    }}</label>
                    <input
                        type="radio"
                        name=""
                        :class="'M' + meal.id"
                        :id="'M' + meal.id + 'S' + size.id"
                        :value="index"
                        v-model="sizesRef"
                    />
                </div>
            </div>
        </div>

        <button
            v-if="meal.sizes.length > 0"
            @click="addToCartSize(meal)"
            class="btn-green mb-2"
        >
            أضف الى السلة
        </button>
        <button v-else @click="addToCart(meal)" class="btn-green mb-2">
            أضف الى السلة
        </button>
    </div>
</template>
<script setup>
import { inject, ref,onMounted } from "vue";
import CarouselGallery from "./CarouselGallery.vue";
const darkMode = inject("darkMode");
const mealRef = inject("mealRef");
const addToCartRef = inject("addToCart");
const error = inject("error");
const cartItems = inject("cartItems");
const sizesRef = ref(0);
onMounted(()=>{
    sizesRef.value = props.index;
});
const minus = (id) => {
    if (document.getElementById(id).value != "1") {
        document.getElementById(id).value =
            parseInt(document.getElementById(id).value) - 1;
    }
};
const add = (id) => {
    document.getElementById(id).value =
        parseInt(document.getElementById(id).value) + 1;
};
const animate_running = ref(false);
const animateCart = () => {
    if (animate_running.value == false) {
        animate_running.value = true;
        document.getElementById("cart").classList.add("animate-shake");
        document.getElementById("cartItems").classList.add("animate-jump-in");
        setTimeout(() => {
            document.getElementById("cart").classList.remove("animate-shake");
            document
                .getElementById("cartItems")
                .classList.remove("animate-jump-in");

            animate_running.value = false;
        }, 1000);
    }
};

const addToCart = (meal) => {
    let data = sessionStorage.getItem("cart");
    mealRef.value = meal.meal_name;
    addToCartRef.value = !addToCartRef.value;

    if (data == null) {
        sessionStorage.setItem("cart", "[]");
    }
    data = sessionStorage.getItem("cart");
    const count = parseInt(document.getElementById(meal.id).value);
    const myArray = JSON.parse(data);
    const exist = myArray.findIndex((value) => value.id == meal.id);
    if (exist != -1) {
        myArray[exist].count = myArray[exist].count + count;
    } else {
        const obj = {
            id: meal.id,
            barcode: meal.meal_barcode,
            count: count,
            img: meal.meal_picture[0],
            price: meal.meal_price,
            name: meal.meal_name,
            promo: meal.promotion?.status ? meal.meal_promo : 0,
            promo_name:
                meal.promotion?.promo_type > 2 ? meal.promotion.promo_name : "",
            choice:
                meal.promotion?.promo_type > 2
                    ? meal.promotion?.promo_num_choice
                    : 0,
            discount: meal.promotion?.status
                ? meal.promotion.promo_discount
                : 0,
            promo_type: meal.promotion?.status ? meal.promotion?.promo_type : 0,
        };
        myArray.push(obj);
        cartItems.value = cartItems.value + 1;
    }

    sessionStorage.setItem("cart", JSON.stringify(myArray));
    data = sessionStorage.getItem("cart");
    animateCart();
};
const addToCartSize = (meal) => {
    if (meal.sizes[sizesRef.value]?.size_name) {
        let data = sessionStorage.getItem("cart");

        mealRef.value =
            meal.meal_name + " " + meal.sizes[sizesRef.value].size_name;
        addToCartRef.value = !addToCartRef.value;

        if (data == null) {
            sessionStorage.setItem("cart", "[]");
        }
        data = sessionStorage.getItem("cart");

        const count = parseInt(document.getElementById(meal.id).value);
        const myArray = JSON.parse(data);
        const exist = myArray.findIndex(
            (value) => value.barcode == meal.sizes[sizesRef.value].size_barcode
        );
        if (exist != -1) {
            myArray[exist].count = myArray[exist].count + count;
        } else {
            const obj = {
                id: meal.id,
                barcode: meal.sizes[sizesRef.value].size_barcode,
                count: count,
                img: meal.meal_picture[0],
                price: meal.sizes[sizesRef.value].size_price,
                name:
                    meal.meal_name + " " + meal.sizes[sizesRef.value].size_name,
                promo: meal.sizes[sizesRef.value].promotion?.status
                    ? meal.sizes[sizesRef.value].size_promo
                    : 0,
                promo_name:
                    meal.sizes[sizesRef.value].promotion?.status &&
                    meal.sizes[sizesRef.value].promotion?.promo_type > 2
                        ? meal.sizes[sizesRef.value].promotion?.promo_name
                        : "",
                choice:
                    meal.sizes[sizesRef.value].promotion?.status &&
                    meal.sizes[sizesRef.value].promotion?.promo_type > 2
                        ? meal.sizes[sizesRef.value].promotion?.promo_num_choice
                        : 0,
                discount: meal.sizes[sizesRef.value].promotion?.status
                    ? meal.sizes[sizesRef.value].promotion.promo_discount
                    : 0,
                promo_type: meal.sizes[sizesRef.value].promotion?.status
                    ? meal.sizes[sizesRef.value].promotion?.promo_type
                    : 0,
            };
            myArray.push(obj);
            cartItems.value = cartItems.value + 1;
        }

        sessionStorage.setItem("cart", JSON.stringify(myArray));
        data = sessionStorage.getItem("cart");
        animateCart();
    } else {
        error.value = !error.value;
    }
};
const promo = (original, promo) => {
    original = parseFloat(original);
    promo.promo_discount = parseFloat(promo.promo_discount);
    if (promo.promo_type == 1) {
        const after = original - promo.promo_discount;
        return `<del>${original.toFixed(2)}</del><br>${after.toFixed(2)} جنيه`;
    } else if (promo.promo_type == 2) {
        const after = original - original * 0.01 * promo.promo_discount;
        return `<del>${original.toFixed(2)}</del><br>${after.toFixed(2)} جنيه`;
    }
    return `${original} جنيه`;
};
const props = defineProps({
    meal: Object,
    plus_white: String,
    plus_black: String,
    minus_white: String,
    minus_black: String,
    index:Number,
});
</script>
