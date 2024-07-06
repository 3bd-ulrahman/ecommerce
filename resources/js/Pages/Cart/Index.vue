<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import OrderTotals from '@/Components/Cart/OrderTotals.vue';
import CartItems from '@/Components/Cart/CartItems.vue';
import { computed } from 'vue';

const props = defineProps({
  cart: Object,
  taxRate: Number,
  couponCode: String,
  discount: Number
});

const cartSubTotal = computed(() => {
  return parseFloat(props.cart.shopping_items.reduce(
    (total, item) => total + item.price, 0
  ).toFixed(2));
});

/*
 * Save for later
*/
const wishlistItemsCount = computed(() => {
  let count = 0;

  Object.values(props.cart.wishlist_items).forEach(item => {
    count++;
  });

  return count;
});
</script>

<template>
  <AppLayout title="Cart">
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

        <CartItems :items="cart.shopping_items" title="shopping"/>

        <div class="text-center text-red-600 text-2xl font-semibold mt-4 mb-2 md:text-left">
          <p v-if="wishlistItemsCount <= 0">You have saved no items for later!</p>
          <p v-else>{{ wishlistItemsCount }} item(s) saved for later</p>
        </div>

        <CartItems :items="cart.wishlist_items" title="wishlist"/>
      </div>

      <div class="flex-1">
        <OrderTotals
          v-bind="{
            taxRate,
            cartSubTotal,
            couponCode,
            discount
          }"
        />
      </div>

    </div>
  </AppLayout>
</template>
