<script setup>
import { Head, usePage } from '@inertiajs/vue3';
import Nav from '@/Components/Nav.vue';
import Footer from '@/Components/Footer.vue';

defineProps({
  title: String
});

if (usePage().props.flash.success) {
  Toast.fire({
    icon: 'success',
    title: usePage().props.flash.success
  });
} else if (usePage().props.flash.warning) {
  Toast.fire({
    icon: 'warning',
    title: usePage().props.flash.warning
  });
}  else if (usePage().props.flash.error) {
  Toast.fire({
    icon: 'error',
    title: usePage().props.flash.error
  });
}
</script>

<template>
  <div>
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
