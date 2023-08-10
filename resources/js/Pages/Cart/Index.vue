<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import OrderTotals from '@/Components/Cart/OrderTotals.vue';
import CartItems from '@/Components/Cart/CartItems.vue';
import { computed, reactive } from 'vue';

const props = defineProps({
  cartItems: Object,
  saveForLaterItems: Object,
  taxRate: Number,
  cartSubTotal: String,
  cartTotal: String,
});

// const form  = reactive({
//   cartItems: props.cartItems,
//   quantity: 0
// });


/**
 * Cart
 */
const moveToCart = (rowId) => {
  router.post(route('cart.move-to-cart.store', rowId), null, {
    preserveScroll: true
  });
};

const updateCartQuantity = (rowId, quantity) => {
  router.patch(route('cart.update', rowId), {quantity: quantity}, {
    preserveScroll: true
  });
}

const removeFromCart = (rowId) => {
  router.delete(route('cart.destroy', rowId), {
    preserveScroll: true
  });
};


/*
 * Save for later
*/
const saveForLaterItemsCount = computed(() => {
  let count = 0;

  Object.values(props.saveForLaterItems).forEach(item => {
    count += item.qty;
  });

  return count;
});

const saveForLater = (rowId) => {
  router.post(route('cart.save-for-later.store', rowId), null, {
    preserveScroll: true
  });
};

const updateSaveForLaterQuantity = (rowId, quantity) => {
  router.patch(route('cart.save-for-later.update', rowId), {quantity: quantity}, {
    preserveScroll: true
  });
}

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

        <CartItems :items="cartItems" title="cart"/>

        <div class="text-center text-red-600 text-2xl font-semibold mt-4 mb-2 md:text-left">
          <p v-if="saveForLaterItemsCount <= 0">You have saved no items for later!</p>
          <p v-else>{{ saveForLaterItemsCount }} item(s) saved for later</p>
        </div>

        <CartItems :items="saveForLaterItems" title="saveForLater"/>

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
