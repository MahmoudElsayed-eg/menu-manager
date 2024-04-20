<template>
    <div class="pt-3 px-3 w-full md:w-2/3 md:mx-auto">
        <Carousel
            id="gallery"
            :items-to-show="1"
            :wrap-around="true"
            v-model="currentSlide"
            :autoplay="duration"
            :pause-autoplay-on-hover="true"
        >
            <Slide v-for="(image, index) in images" :key="index">
                <div class="carousel__item">
                    <div v-if="image?.meal">
                        <img
                            class="caro-img h-48"
                            :src="image?.pic ?? image"
                            alt=""
                            @click="$emit('giveMeal', image.meal)"
                        />
                    </div>
                    <div v-else-if="image?.category">
                        <Link :href="route('category.show', image.category.id)">
                            <img
                                class="caro-img h-48"
                                :src="image?.pic ?? image"
                                alt=""
                            />
                        </Link>
                    </div>
                    <div v-else-if="image?.promotion">
                        <a
                            href="#"
                            @click.prevent="
                                $emit('scroll', 'promo' + image.promotion.id)
                            "
                        >
                            <img
                                class="caro-img h-48"
                                :src="image?.pic ?? image"
                                alt=""
                            />
                        </a>
                    </div>
                    <div v-else>
                        <img
                            class="caro-img h-48"
                            :src="image?.pic ?? image"
                            alt=""
                        />
                    </div>
                </div>
            </Slide>

            <template #addons>
                <Navigation />
                <Pagination />
            </template>
        </Carousel>
    </div>
    <div v-if="gallery" class="p-3 w-full md:w-2/3 md:mx-auto">
        <Carousel
            id="thumbnails"
            :items-to-show="3"
            :wrap-around="true"
            v-model="currentSlide"
            ref="carousel"
        >
            <Slide v-for="(image, index) in images" :key="index">
                <div class="carousel__item" @click="slideTo(index)">
                    <img :src="image?.pic ?? image" alt="" class="h-14" />
                </div>
            </Slide>
        </Carousel>
    </div>
</template>

<script>
import { onMounted } from "vue";
import { defineComponent, ref, watch } from "vue";
import { Carousel, Slide, Pagination, Navigation } from "vue3-carousel";
import { Link } from "@inertiajs/vue3";

import "vue3-carousel/dist/carousel.css";

export default defineComponent({
    name: "Gallery",
    emits: ["giveMeal", "scroll"],
    components: {
        Carousel,
        Slide,
        Link,
        Pagination,
        Navigation,
    },
    props: {
        images: Array,
        gallery: {
            type: Boolean,
            default: true,
        },
    },
    setup(props, ctx) {
        const currentSlide = ref(0);
        const duration = ref(2000);
        onMounted(() => {
            if (props.images.length > 0 && props.images[0]?.duration) {
                duration.value = props.images[0].duration * 1000;
            }
        });
        watch(currentSlide, (currentIndex) => {
            // Update the ref value
            if (props.images.length > 0 && props.images[0]?.duration) {
                duration.value = props.images[currentIndex].duration * 1000;
            }
        });

        const slideTo = (index) => {
            currentSlide.value = index;
        };

        const givemeal = (meal) => {
            ctx.emit("give_meal", meal);
        };

        return {
            currentSlide,
            slideTo,
            duration,
            givemeal,
        };
    },
});
</script>

