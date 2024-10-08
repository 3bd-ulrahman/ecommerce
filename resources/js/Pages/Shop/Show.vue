<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import SecondaryHeader from '@/Components/SecondaryHeader.vue';
import GrayButton from '@/Components/Buttons/GrayButton.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  product: Object,
  similarProducts: Object
});

const form = useForm({
  id: props.product.id,
  name: props.product.name,
  price: props.product.price,
  product_code: props.product.product_code,
  details: props.product.details,
  image: props.product.image,
  slug: props.product.slug,
  totalQuantity: props.product.quantity,
  quantity: 1,
});

const submit = function () {
  form.post(route('cart.store'), {
    onSuccess: page => {
      Toast.fire({
        icon: 'success',
        title: `${form.name} has been added successfully to your cart`
      })
    }
  });
};
</script>

<template>
  <app-layout :title="product.name">

    <SecondaryHeader>

      <template #breadcrumbs>
        <Icon name="angle-right" class="w-4 h-4 fill-current" />
        <Link :href="route('shop.index')" class="text-gray-700 transition hover:text-yellow-500">
          Shop
        </Link>
        <Icon name="angle-right" class="w-4 h-4 fill-current" />
        <span>{{ product.name }}</span>
      </template>

      <template #search>
        search
      </template>

    </SecondaryHeader>

    <div class="max-w-7xl mx-auto px-4 py-4 sm:flex sm:space-x-4 sm:px-6 lg:px-8">
      <div class="flex-1 sm:border-r">
        <div class="border-2 p-2">
          <img :src="product.image" :alt="product.name" class="w-full object-cover">
        </div>
      </div>
      <div class="flex-1 space-y-6 my-4 sm:mt-0 sm:border-l sm:pl-4">
        <form @submit.prevent="submit()">
          <div class="flex justify-between items-center">
            <h2 class="text-2xl font-semibold capitalize italic">{{ product.name }}</h2>
            <div class="text-xl capitalize italic">
              <span>
                Price:
              </span>
              <span>
                {{ $filters.formatCurrency(product.price) }}
              </span>
            </div>
          </div>

          <div class="flex space-x-4 mt-4">
            <p class="text-xl capitalize">
              {{ product.details }}
            </p>
          </div>
          <div class="flex space-x-4 mt-4">
            <span class="text-xl capitalize">
              Sku:
            </span>
            <p class="text-xl capitalize">
              {{ product.product_code }}
            </p>
          </div>

          <div class="mt-4">
            <template v-if="product.quantity <= 0">
              <div class="mt-4">
                <span class="text-2xl text-red-600 font-semibold italic uppercase">
                  Sold Out
                </span>
              </div>
            </template>

            <template v-else-if="product.quantity <= 5">
              <div class="mt-4">
                <span class="text-2xl text-yellow-600 font-semibold italic uppercase">
                  Only a few left
                </span>
              </div>
            </template>

            <div class="flex items-center" v-if="product.quantity != 0">
              <label for="quantity" class="flex-1 text-xl capitalize">Qty:</label>
              <select v-model="form.quantity" tabindex="1"
                class="flex-1 w-full border bg-white rounded px-3 py-1 outline-none"
              >
                <option v-for="(qty, index) in product.quantity" :key="index" :value="qty" :selected="qty === product.quantity">
                  {{ qty }}
                </option>
              </select>
            </div>
          </div>

          <div class="text-center mt-4" v-if="product.quantity > 0">
            <GrayButton type="submit" :disabled="form.processing" class="text-sm">
              <span>Add to Cart</span>
            </GrayButton>
          </div>
        </form>
        <div class="flex flex-col divide-y">
          <div>
            <button type="button"
              class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8">
              <span>Product Description</span>
            </button>
          </div>
          <div>
            <button type="button"
              class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8">
              <span>Product Features</span>
            </button>
          </div>
          <div>
            <button type="button"
              class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8">
              <span>Return Policy</span>
            </button>
          </div>
          <div>
            <button type="button"
              class="flex justify-between items-center bg-gray-300 rounded-t px-4 py-4 w-full transition hover:text-white hover:bg-gray-700 sm:px-6 lg:px-8">
              <span>Reviews</span>
            </button>
          </div>
        </div>
        <div class="text-center">
          <p>Suggested based on your search</p>
        </div>
        <div class="flex space-x-4">
          <Link v-for="product in similarProducts" :href="route('shop.show', product.slug)" class="flex border border-black w-1/4 h-24">
            <img :src="product.image" :alt="product.name" class="w-full object-cover">
          </Link>
        </div>
      </div>
    </div>

  </app-layout>
</template>
