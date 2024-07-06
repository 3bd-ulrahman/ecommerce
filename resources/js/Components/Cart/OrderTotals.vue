<script setup>
import { Link } from '@inertiajs/vue3';
import YellowButton from '@/Components/Buttons/YellowButton.vue';
import GrayButton from '../Buttons/GrayButton.vue';
import { router, useForm } from '@inertiajs/vue3';
import { computed, defineModel } from 'vue';

const props = defineProps({
  taxRate: Number,
  cartSubTotal: Number,
  couponCode: String,
  discount: Number
});

const coupon_code = defineModel('coupon_code');

const estimatedTax = computed(function () {
  let value = (props.cartSubTotal - props.discount) * props.taxRate;

  if (value < 0) {
    value = 0;
  }

  return value.toFixed(2);
});

const total = computed(() => {
  let value = (props.cartSubTotal + (props.cartSubTotal * props.taxRate) ) - props.discount;
  return value.toFixed(2);
});

const form = useForm({
  coupon_code: props.couponCode
});

const applyCoupon = () => {
  form.post(route('coupons.store'), {
    preserveScroll: true,
    onSuccess: page => {
      Toast.fire({
        icon: 'success',
        title: 'Coupon has been applied'
      });
    }
  });
};

const removeCoupon = () => {
  router.delete(route('coupons.destroy'), {
    preserveScroll: true,
    onSuccess: page => {
      Toast.fire({
        icon: 'success',
        title: 'Coupon has been removed'
      });
    }
  });
}
</script>

<template>
  <div class="shadow-md rounded sm:my-2">

    <div class="flex flex-col items-center space-y-4 py-6 bg-gray-700">

      <div class="flex space-x-4">
        <span class="text-white">
          Order Total(before tax & discount(s))
        </span>
        <span class="text-yellow-500">
          {{ $filters.formatCurrency(cartSubTotal) }}
        </span>
      </div>

      <div>
        <YellowButton :href="route('checkout.index')" type="href" class="text-sm">
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

        <div v-if="props.couponCode" class="flex justify-between px-4 mt-4">
          <span>Discount Code ({{ props.couponCode }})</span>
          <form @submit.prevent="removeCoupon()">
            <span>-{{ $filters.formatCurrency(discount) }}</span>
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
            <span>${{ total }}</span>
          </div>
          <div class="flex flex-col">
            <span>({{ taxRate }}% tax rate)</span>
            <span>Lorem ipsum dolor sit amet.</span>
          </div>
        </div>

        <div class="text-center mt-4">
          <YellowButton :href="route('checkout.index')" type="href" class="text-sm">
            Secure Checkout
          </YellowButton>
        </div>
      </div>
      <div class="text-center mt-4">
        <Link :href="route('shop.index')" class="underline hover:text-red-700 transition">
          Continue Shopping
        </Link>
      </div>
    </div>

  </div>

  <div v-if="! props.couponCode" class="flex flex-col items-center bg-gray-300 shadow-md rounded mt-4 py-6">
    <span class="text-2xl font-semibold">Promo</span>
    <form @submit.prevent="applyCoupon()" class="w-full">
      <div class="bg-gray-300 px-4">
        <div>

          <div class="bg-white p-4 mt-4">
            <input type="text" class="w-full" placeholder="Enter Promo Code Here" v-model="coupon_code" @input="form.coupon_code = $event.target.value">
            <span v-if="$page.props.errors.message" class="text-md text-red-600 mt-2">
              {{ $page.props.errors.message }}
            </span>
          </div>

          <div class="text-center mt-4">
            <GrayButton type="button" class="text-sm" :disabled="form.processing">
              Apply
            </GrayButton>
          </div>

        </div>
      </div>
    </form>
  </div>
</template>
