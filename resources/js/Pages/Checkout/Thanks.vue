<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import YellowButton from '@/Components/Buttons/YellowButton.vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
  order: Object,
  discount: Number
});

function print() {
  window.print();
}

console.log(props.order.products);
</script>

<template>
  <AppLayout title="Thanks - Coder\'s Shop">

    <div id="print-container" class="flex flex-col items-center space-y-4 w-full p-12">
      <h2 class="text-lg font-semibold italic">Thanks for placing your order.</h2>
      <div class="flex justify-between items-center w-full">
        <!-- <div>
          <span class="font-semibold">Your confirmation # is: </span>
          <span>{{ order.confirmation_number }}</span>
        </div> -->
        <div>
          <YellowButton type="button" id="print" class="text-sm" @click="print">
            Print
          </YellowButton>
        </div>
      </div>

      <div class="w-full">
        <div class="flex justify-between text-center border-t border-b border-black py-2">
          <span class="flex-1">Item</span>
          <span class="flex-1">Name</span>
          <span class="flex-1">Quantity</span>
          <span class="flex-1">Price</span>
        </div>

        <div v-for="(item, index) in order.products" :key="index"
          class="flex justify-between text-center border-b border-black py-2"
        >
            <div class="flex w-1/2">
              <Link :href="route('shop.show', item.slug)" class="flex flex-1">
                <img :src="item.image" :alt="item.name" class="object-cover">
              </Link>
              <div class="flex flex-1 flex-col justify-between">
                <Link href="#" class="flex flex-col">
                  <span>{{ item.name }}</span>
                </Link>
              </div>
            </div>

            <div class="flex justify-between w-1/2">
              <div class="flex-1 text-center">
                {{ item.pivot.quantity }}
              </div>
              <span class="flex-1">{{ $filters.formatCurrency(item.price) }} ea.</span>
            </div>
        </div>

        <div class="flex justify-end border-t border-b border-black py-2">
          <div class="flex flex-col">
            <div class="flex justify-end space-x-2">
              <span>Subtotal:</span>
              <span>{{ $filters.formatCurrency(order.subtotal) }}</span>
            </div>
            <div class="flex justify-end space-x-2" v-if="discount">
              <span>-{{ $filters.formatCurrency(discount) }}</span>
            </div>
            <div class="flex justify-end space-x-2">
              <span>Tax:</span>
              <span>{{ $filters.formatCurrency(order.tax) }}</span>
            </div>
            <div class="flex justify-end space-x-2">
              <span>Total:</span>
              <span>{{ $filters.formatCurrency(order.total) }}</span>
            </div>
          </div>
        </div>
      </div>

    </div>
  </AppLayout>
</template>

<style scoped>
@media print {
  body *:not(#print-container, #print-container *) {
    visibility: hidden;
    position: fixed;
    top: 0;
  }

  #print-container, #print-container * {
    visibility: visible;
  }

  #print-container {
    width: 100vw;
    position: fixed;
    top: 5%;
  }

  button#print {
    display: none;
  }
}

@page {
  size: auto;
  margin: 0mm;
}
</style>
