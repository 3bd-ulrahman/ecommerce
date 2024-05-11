<script setup>
import { computed } from "vue";
import { Link } from '@inertiajs/vue3';

defineProps(['active', 'href', 'type']);

const classes = computed(() => {
  return 'inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded font-semibold text-white uppercase tracking-widest hover:bg-gray-500 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 transition'
});
</script>

<template>
  <Link v-if="type === 'href'" :href="href" :class="classes">
    <slot></slot>
  </Link>
  <button v-else :class="classes">
    <slot></slot>
  </button>
</template>
