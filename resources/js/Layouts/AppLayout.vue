<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import Nav from '@/Components/Nav.vue';
import Footer from '@/Components/Footer.vue';
import Search from '@/Components/Search.vue';
import { watch } from 'vue';

defineProps({
  title: String
});

watch(() => usePage().props.flash, () => {
  const flashMessage = Object.entries(usePage().props.flash).find(([key, value]) => value !== null);
  if (flashMessage) {
    return Toast.fire({
      icon: flashMessage[0],
      title: flashMessage[1]
    });
  }
});
</script>

<template>
  <div>
    <!-- <Search /> -->
    <Head :title="title" />

    <div class="min-h-screen bg-gray-100">
      <Nav />

      <!-- Page Heading -->
      <header class="bg-gray-700 shadow">
        <div class="max-w-7xl mx-auto py-6 px-2 sm:px-6 lg:px-8">
          <h2 class="text-white text-center leading-tight">
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
          </h2>
        </div>
      </header>

      <!-- Page Content -->
      <main style="min-height: 90vh;">
        <slot />
      </main>

      <Footer />
    </div>
  </div>
</template>
