<script setup>
import YellowButton from '@/Components/Buttons/YellowButton.vue';

const props = defineProps([
  'cartItems',
  'taxRate',
  'cartSubTotal',
  'cartTotal'
]);

const estimatedTax = (props.cartSubTotal / 100) * (props.taxRate / 100);
</script>

<template>
  <div class="shadow-md rounded sm:my-2">

    <div class="flex flex-col items-center space-y-4 py-6 bg-gray-700">

      <div class="flex space-x-4">
        <span class="text-white">
          Order Total(before tax & discount(s))
        </span>
        <span class="text-yellow-500">{{ $filters.formatCurrency(cartSubTotal) }}</span>
      </div>

      <div>
        <YellowButton href="#" type="href" class="text-sm">
          Secure Checkout
        </YellowButton>
      </div>

    </div>

    <div class="bg-gray-300 px-4 py-6">
      <div>
        <span class="px-4">Order Summary</span>

        <div class="flex justify-between bg-white px-4 py-2 mt-4">
          <span>Items subtotal({{ $page.props.cartCount }})</span>
          <span>{{ $filters.formatCurrency(cartSubTotal) }}</span>
        </div>

        <div class="flex justify-between px-4 mt-4">
          <span>Shipping</span>
          <span>Free</span>
        </div>

        <div class="flex justify-between px-4 mt-4">
          <span>Discount Code (ABC123)</span>
          <form>
            <span>-$2.00</span>
            <button type="submit" class="text-red-600 ml-2">
              X
            </button>
          </form>
        </div>

        <div class="flex justify-between px-4 mt-4">
          <span>Estimated Tax</span>
          <span>${{ estimatedTax }}</span>
        </div>

        <div class=" bg-white px-4 py-2 mt-4">
          <div class="flex justify-between">
            <span>Order Total</span>
            <span>${{ cartTotal }}</span>
          </div>
          <div class="flex flex-col">
            <span>({{ taxRate }}% tax rate)</span>
            <span>Lorem ipsum dolor sit amet.</span>
          </div>
        </div>

        <div class="text-center mt-4">
          <YellowButton href="#" type="href" class="text-sm">
            Secure Checkout
          </YellowButton>
        </div>

        <div class="text-center mt-4">
          <Link :href="route('shop.index')" class="underline hover:text-red-700 transition">
          Continue Shopping
          </Link>
        </div>
      </div>
    </div>

  </div>
</template>
