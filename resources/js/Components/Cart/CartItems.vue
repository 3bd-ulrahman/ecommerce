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
const moveToCart = (id, quantity) => {
  router.patch(route('cart.update', id), {quantity}, {
    preserveScroll: true,
    onSuccess: page => {
      Toast.fire({
        icon: 'success',
        title: 'Items has been successfully added to cart'
      });
    }
  });
};

const updateCartQuantity = (id, quantity) => {
  router.patch(route('cart.update', id), {quantity: quantity}, {
    preserveScroll: true,
    onSuccess: page => {
      Toast.fire({
        icon: 'success',
        title: 'Item in cart have been successfully updated'
      });
    }
  });
}

const removeFromCart = (id) => {
  router.delete(route('cart.destroy', id), {
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
const saveForLater = (id, quantity) => {
  router.patch(route('cart.wishlist.update', id), {quantity}, {
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
  router.patch(route('cart.wishlist.update', rowId), {quantity: quantity}, {
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
  router.delete(route('cart.wishlist.destroy', rowId), {
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
      <Link :href="route('shop.show', item.slug)" class="flex flex-1">
        <img :src="item.image" class="object-cover" :alt="item.name">
      </Link>

      <div class="flex flex-1 flex-col justify-between">

        <Link :href="route('shop.show', item.slug)" class="flex flex-col">
          <span>{{ item.name }}</span>
          <span>{{ item.details.substring(0, 10) + '...' }}</span>
        </Link>

        <div v-if="title === 'shopping'" class="flex flex-col mt-4">
          <form @submit.prevent="removeFromCart(item.id)">
            <button type="submit" class="hover:text-yellow-500">
              Remove
            </button>
          </form>

          <form @submit.prevent="saveForLater(item.id, item.pivot.quantity)">
            <button type="submit" class="hover:text-yellow-500">
              Save for later
            </button>
          </form>
        </div>

        <div  v-if="title === 'wishlist'" class="flex flex-col mt-4">
          <form @submit.prevent="removeFromSaveForLater(item.id)">
            <button type="submit" class="hover:text-yellow-500">
              Remove
            </button>
          </form>

          <form @submit.prevent="moveToCart(item.id, item.pivot.quantity)">
            <button type="submit" class="hover:text-yellow-500">
              Move to cart
            </button>
          </form>
        </div>

      </div>
    </div>

    <div class="flex justify-between w-1/2">
      <div class="flex-1 text-center">
        <select v-if="title === 'shopping'" @change="updateCartQuantity(item.id, $event.target.value)"
          class="border bg-white rounded outline-none py-0" tabindex="1">
          <option :value="qty" :selected="qty === item.pivot.quantity" v-for="(qty, index) in item.quantity"
            :key="index">
            {{ qty }}
          </option>
        </select>

        <select v-if="title === 'wishlist'" @change="updateSaveForLaterQuantity(item.id, $event.target.value)"
          class="border bg-white rounded outline-none py-0" tabindex="1">
          <option :value="qty" :selected="qty === item.pivot.quantity" v-for="(qty, index) in item.quantity"
            :key="index"
          >
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
