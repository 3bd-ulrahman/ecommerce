<script setup>
import { Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  items: Object,
  title: String
});

const count = computed(() => {
  let count = 0;

  Object.values(props.items).forEach(item => {
    count += item.qty;
  });

  return count;
});

/**
 * Cart
 */
 const moveToCart = (rowId) => {
  router.post(route('cart.move-to-cart.store', rowId), null, {
    preserveScroll: true,
    onSuccess: page => {
      Toast.fire({
        icon: 'success',
        title: 'Items has been successfully added to cart'
      });
    }
  });
};

const updateCartQuantity = (rowId, quantity) => {
  router.patch(route('cart.update', rowId), {quantity: quantity}, {
    preserveScroll: true,
    onSuccess: page => {
      Toast.fire({
        icon: 'success',
        title: 'Item in cart have been successfully updated'
      });
    }
  });
}

const removeFromCart = (rowId) => {
  router.delete(route('cart.destroy', rowId), {
    preserveScroll: true,
    onSuccess: page => {
      Toast.fire({
        icon: 'success',
        title: 'Item has been successfully removed from your cart'
      });
    }
  });
};


/*
 * Save for later
*/
const saveForLater = (rowId) => {
  router.post(route('cart.save-for-later.store', rowId), null, {
    preserveScroll: true,
    onSuccess: page => {
      Toast.fire({
        icon: 'success',
        title: 'Item has been successfully saved for later'
      });
    }
  });
};

const updateSaveForLaterQuantity = (rowId, quantity) => {
  router.patch(route('cart.save-for-later.update', rowId), {quantity: quantity}, {
    preserveScroll: true,
    onSuccess: page => {
      Toast.fire({
        icon: 'success',
        title: 'Item in save for later has been successfully updated'
      });
    }
  });
}

const removeFromSaveForLater = (rowId) => {
  router.delete(route('cart.save-for-later.destroy', rowId), {
    preserveScroll: true,
    onSuccess: page => {
      Toast.fire({
        icon: 'success',
        title: 'Item in save for later have been successfully removed'
      });
    }
  });
};
</script>

<template>
  <div v-if="count > 0" class="flex justify-between border-t border-b border-black py-2">
    <div class="w-1/3">Item</div>
    <div class="flex justify-between w-1/2">
      <span class="flex-1 text-center">Quantity</span>
      <span class="flex-1 text-right">Price</span>
    </div>
  </div>


  <div v-for="(item, index) in items" :key="index" class="flex justify-between border-b border-black py-2">

    <div class="flex space-x-4 w-1/2">

      <Link :href="route('shop.show', item.options.slug)" class="flex flex-1">
        <img :src="item.options.image" class="object-cover" :alt="item.name">
      </Link>

      <div class="flex flex-1 flex-col justify-between">

        <Link :href="route('shop.show', item.options.slug)" class="flex flex-col">
        <span>{{ item.name }}</span>
        <span>{{ item.options.details.substring(0, 10) + '...' }}</span>
        </Link>

        <div v-if="title === 'cart'" class="flex flex-col mt-4">
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

        <div  v-if="title === 'saveForLater'" class="flex flex-col mt-4">
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
        <select v-if="title === 'cart'" @change="updateCartQuantity(item.rowId, $event.target.value)"
          class="border bg-white rounded outline-none py-0" tabindex="1">
          <option :value="qty" :selected="qty === item.qty" v-for="(qty, index) in item.options.total_quantity"
            :key="index">
            {{ qty }}
          </option>
        </select>
        <select v-if="title === 'saveForLater'" @change="updateSaveForLaterQuantity(item.rowId, $event.target.value)"
          class="border bg-white rounded outline-none py-0" tabindex="1">
          <option :value="qty" :selected="qty === item.qty" v-for="(qty, index) in item.options.total_quantity"
            :key="index">
            {{ qty }}
          </option>
        </select>
      </div>
      <span class="flex-1 text-right">
        {{ $filters.formatCurrency(item.price) }}
      </span>
    </div>

  </div>
</template>
