<script setup>
import { Head } from '@inertiajs/vue3';
import Nav from '@/Components/Nav.vue';
import Footer from '@/Components/Footer.vue';

defineProps({
  title: String
});
</script>

<template>
  <div>
    <Head :title="title" />

    <div class="min-h-screen bg-gray-100">
      <Nav />
      <h1>{{ CartItems }}</h1>
      <!-- Page Heading -->
      <header class="bg-gray-700 shadow">
        <div class="max-w-7xl mx-auto py-6 px-2 sm:px-6 lg:px-8">
          <h2 class="text-white text-center leading-tight">
            Lorem ipsum dolor sit amet consectetur adipisicing elit.
          </h2>
        </div>
      </header>

      <!-- Page Content -->
      <main>
        <slot />
      </main>

      <Footer />
    </div>
  </div>
</template>
