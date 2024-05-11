<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import YellowButton from '@/Components/Buttons/YellowButton.vue';
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
  order: Object
});
</script>

<template>
  <UserLayout title="My Order">

    <h1 class="text-xl font-semibold px-6">Order # {{ order.reference_code }}</h1>
    <div class="flex flex-col space-y-2 px-6 py-2">
      <div>

        <div class="flex justify-between items-center bg-gray-700 text-sm text-white rounded-t px-6 py-2 w-full">
          <form method="post" :action="route('invoices.show', order.reference_code)" target="_blank">
            <input type="hidden" name="_token" :value="usePage().props.csrf_token">
            <YellowButton type="submit" class="py-1">
              <span>Print Invoice</span>
            </YellowButton>
          </form>

          <div class="flex flex-col text-right">
            <span>Order Placed:</span>
            <span>{{ order.created_at }}</span>
          </div>
        </div>

        <div class="border rounded-b divide-y space-y-4 px-6 py-2">
          <div v-for="(product, index) in order.products" :key="index">
            <Link :href="route('shop.show', product.slug)" class="flex justify-between space-x-4 divide-x py-6">
            <div class="flex-1">
              <img :src="product.image" :alt="product.name" class="object-cover">
            </div>
            <div class="flex-1 pl-4">
              <span>{{ product.name }}</span>
              <p>{{ product.details }}</p>
              <p>{{ product.description }}</p>
            </div>
            </Link>
          </div>
        </div>

        <div class="flex justify-end border-t border-b border-black py-2">
          <div class="flex flex-col">

            <div class="flex justify-end space-x-2">
              <span>Subtotal:</span>
              <span>{{ $filters.formatCurrency(order.sub_total) }}</span>
            </div>

            <div class="flex justify-end space-x-2" v-if="order.billing_discount_code">
              <span>Discount: ({{ order.discount_code }})</span>
              <span>-{{ $filters.formatCurrency(order.discount) }}</span>
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

  </UserLayout>
</template>
