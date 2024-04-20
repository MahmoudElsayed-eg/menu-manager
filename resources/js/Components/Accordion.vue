<template>
  <div>
    <div v-for="(item, index) in items" :key="item.id">
      <div class="flex items-center justify-between py-2" @click="toggleItem(index)">
        <h3 class="text-lg font-medium">{{ item.title }}</h3>
        <span :class="{ 'transform rotate-180': item.expanded }" class="transition-transform duration-300 ease-in-out">
          <svg class="fill-current w-4 h-4" viewBox="0 0 20 20">
            <path v-if="!item.expanded" d="M5 8.75L10 13.75L15 8.75V6.25L10 11.25L5 6.25V8.75Z"></path>
            <path v-else d="M5 11.25L10 6.25L15 11.25V13.75L10 8.75L5 13.75V11.25Z"></path>
          </svg>
        </span>
      </div>
      <transition name="accordion" mode="out-in">
        <div v-if="item.expanded" :key="item.id + '-content'" class="py-2">
          <p>{{ item.content }}</p>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      items: [
        { id: 1, title: 'Item 1', content: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', expanded: false },
        { id: 2, title: 'Item 2', content: 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', expanded: false },
        { id: 3, title: 'Item 3', content: 'Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', expanded: false },
      ]
    }
  },
  methods: {
    toggleItem(index) {
      this.items[index].expanded = !this.items[index].expanded;
    }
  }
}
</script>

<style>
.accordion-enter-active, .accordion-leave-active {
  transition: max-height 0.3s ease-out;
}
.accordion-enter, .accordion-leave-to {
  max-height: 0;
}
</style>