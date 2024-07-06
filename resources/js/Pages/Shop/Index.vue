<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import SecondaryHeader from '@/Components/SecondaryHeader.vue';
import NoItemsFound from '@/Components/NoItemsFound.vue';

const props = defineProps({
  products: Object,
  categories: Object
});

const category = props.categories.find(category => category.slug === route().params.category) ?? {name: 'All'};
</script>

<template>
  <AppLayout :title="`Shop ${ category.name }`">

    <SecondaryHeader>
      <template #breadcrumbs>
        <Icon name="angle-right" class="w-4 h-4 fill-current" />
        <span>Shop {{ category.name }}</span>
      </template>

      <template #search>
        search
      </template>
    </SecondaryHeader>

    <div class="flex">

      <div class="border-r w-1/5">
        <div>

          <div class="text-white text-center bg-gray-700 py-4">
            Shop By Category
          </div>

          <div class="flex flex-col divide-y">
            <Link :href="route('shop.index', { category: category.slug })" v-for="(category, index) in categories" :key="index"
              :class="route().current('shop.index', { category: category.slug }) ? 'bg-gray-700 text-white' : ''"
              class="text-left p-4 transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8"
            >
              {{ category.name }}
            </Link>
          </div>

        </div>
      </div>

      <div class="border-l w-4/5">

        <div class="flex justify-end space-x-2 pt-4 pr-4" v-if="category.slug">
          <span class="font-bold">Price:</span>
          <Link :href="route('shop.index', { ...route().params, sort: 'low_high' })" class="hover:text-yellow-500">
            Low to High
          </Link>
          <span>|</span>
          <Link :href="route('shop.index', { ...route().params, sort: 'high_low' })" class="hover:text-yellow-500">
            High to Low
          </Link>
        </div>

        <div class="container flex flex-wrap mx-auto">
          <template v-if="products.length === 0">
            <no-items-found></no-items-found>
          </template>
          <Link :href="route('shop.show', product.slug)" v-for="(product, index) in products" :key="index" v-else
            class="flex flex-col w-full p-4 rounded sm:w-1/2 md:w-1/3"
          >
            <img :src="product.image" :alt="product.name"
              class="h-72 object-cover md:w-72 lg:w-96"
              loading="lazy"
            >
            <div class="flex justify-around bg-gray-700 py-2">
              <span class="text-yellow-500">{{ $filters.formatCurrency(product.price) }}</span>
              <span class="text-white">{{ product.name }}</span>
            </div>
          </Link>
        </div>

      </div>

    </div>

  </AppLayout>
</template>
