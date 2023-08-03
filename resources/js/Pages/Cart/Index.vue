<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import OrderTotals from '@/Components/OrderTotals.vue';
import { computed, reactive } from 'vue';

const props = defineProps({
  cartItems: Object,
  taxRate: Number,
  cartSubTotal: String,
  cartTotal: String,
  saveForLaterItems: Object
});

const form  = reactive({
  cartItems: props.cartItems,
  quantity: 0
});


// cart
const moveToCart = (rowId) => {
  router.post(route('cart.move-to-cart.store', rowId), null, {
    preserveScroll: true
  });
};

const removeFromCart = (rowId) => {
  router.delete(route('cart.destroy', rowId), {
    preserveScroll: true
  });
};


// saveForLater
const saveForLaterItemsCount = computed(() => {
  return Object.keys(props.saveForLaterItems).length;
});

const saveForLater = (rowId) => {
  router.post(route('cart.save-for-later.store', rowId), null, {
    preserveScroll: true
  });
};

const removeFromSaveForLater = (rowId) => {
  router.delete(route('cart.save-for-later.destroy', rowId), {
    preserveScroll: true
  });
};
</script>

<template>
  <app-layout title="Cart">

    <div class="max-w-7xl mx-auto p-4 space-y-4 sm:px-6 md:flex md:space-y-0 md:space-x-4 lg:px-8">

      <div class="flex-1">

        <div class="flex flex-col items-center mb-2 md:flex-row md:justify-between">
          <p v-if="$page.props.cartCount < 0" class="text-red-600 text-2xl font-semibold">
            Your cart is empty!
          </p>
          <p v-else class="text-red-600 text-2xl font-semibold">
            {{ $page.props.cartCount }} item(s) in cart
          </p>
          <Link :href="route('shop.index')" class="underline hover:text-red-700 transition">
            Continue Shopping
          </Link>
        </div>

        <div v-if="$page.props.cartCount > 0" class="flex justify-between border-t border-b border-black py-2">
          <div class="w-1/3">Item</div>
          <div class="flex justify-between w-1/2">
            <span class="flex-1 text-center">Quantity</span>
            <span class="flex-1 text-right">Price</span>
          </div>
        </div>

        <div>
          <div v-for="(item, index) in cartItems" :key="index" class="flex justify-between border-b border-black py-2">

            <div class="flex space-x-4 w-1/2">

              <Link :href="route('shop.show', item.options.slug)" class="flex flex-1">
                <img :src="item.options.image" class="object-cover" :alt="item.name">
              </Link>

              <div class="flex flex-1 flex-col justify-between">

                <Link :href="route('shop.show', item.options.slug)" class="flex flex-col">
                  <span>{{ item.name }}</span>
                  <span>{{ item.options.details.substring(0, 10) + '...' }}</span>
                </Link>

                <div class="flex flex-col mt-4">

                  <form @submit.prevent="removeFromCart(item.rowId)">
                    <button type="submit" class="hover:text-yellow-500">
                      Remove
                    </button>
                  </form>

                  <form @submit.prevent="saveForLater(item.rowId)">
                    <button type="submit" class="hover:text-yellow-500">
                      Save for later
                    </button>
                  </form>

                </div>

              </div>

            </div>

            <div class="flex justify-between w-1/2">
              <div class="flex-1 text-center">
                <select class="border bg-white rounded outline-none py-0" tabindex="1">
                  <option value="1">1</option>
                </select>
              </div>
              <span class="flex-1 text-right">
                ${{ item.price }}
              </span>
            </div>

          </div>
        </div>

        <div class="text-center text-red-600 text-2xl font-semibold mt-4 mb-2 md:text-left">
          <p v-if="saveForLaterItemsCount <= 0">You have saved no items for later!</p>
          <p v-else>{{ saveForLaterItemsCount }} item(s) saved for later</p>
        </div>

        <div v-if="saveForLaterItemsCount > 0" class="flex justify-between border-y border-black py-2">
          <div class="w-1/3">Item</div>
          <div class="flex justify-between w-1/2">
            <span class="flex-1 text-center">Quantity</span>
            <span class="flex-1 text-right">Price</span>
          </div>
        </div>

        <div>
          <div v-for="(item, index) in saveForLaterItems" :key="index" class="flex justify-between border-y border-black py-2">

            <div class="flex space-x-4 w-1/2">
              <div class="w-1/3">
                <Link :href="route('shop.show', item.options.slug)">
                  <img :src="item.options.image" class="object-cover" :alt="item.name">
                </Link>
              </div>

              <div class="flex flex-1 flex-col justify-between">

                <Link :href="route('shop.show', item.options.slug)" class="flex flex-col">
                  <span>{{ item.name }}</span>
                </Link>

                <div class="flex flex-col mt-4">

                  <form @submit.prevent="removeFromSaveForLater(item.rowId)">
                    <button type="submit" class="hover:text-yellow-500">
                      Remove
                    </button>
                  </form>

                  <form @submit.prevent="moveToCart(item.rowId)">
                    <button type="submit" class="hover:text-yellow-500">
                      Move to cart
                    </button>
                  </form>
                </div>

              </div>
            </div>

            <div class="flex justify-between w-1/2">
              <div class="flex-1 text-center">
                <select class="border bg-white rounded outline-none py-0" tabindex="1">
                  <option value="1">1</option>
                </select>
              </div>
              <span class="flex-1 text-right">
                {{ $filters.formatCurrency(item.price) }}
              </span>
            </div>

          </div>
        </div>

      </div>

      <div class="flex-1">
        <OrderTotals
          :cartItems="cartItems"
          :taxRate="taxRate"
          :cartSubTotal="cartSubTotal"
          :cartTotal="cartTotal"
        />
      </div>

    </div>

  </app-layout>
</template>
