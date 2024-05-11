<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import OrderTotals from '@/Components/Cart/OrderTotals.vue';
import YellowButton from '@/Components/Buttons/YellowButton.vue';
import { router, useForm, usePage } from '@inertiajs/vue3';
import states from '@/states.js';
import { loadStripe } from '@stripe/stripe-js';
import { nextTick, onBeforeMount, reactive, ref } from 'vue';

const props = defineProps({
  cartSubTotal: String,
  taxRate: Number,
  couponCode: String,
  discount: Number,
  cartTotal: String
});

const form = useForm({
  name: '',
  phone: '',
  address: '',
  city: '',
  state: '',
  zip_code: '',
  name_on_card: '',
  paymentMethod: ''
});

const loading = false;
const disabled = ref(true);
const isConfirmed = ref(false);

let cardElement;
let stripe;
let elements;

onBeforeMount(async () => {
  stripe = await loadStripe(import.meta.env.VITE_STRIPE_KEY);

  elements = stripe.elements({
    mode: 'payment',
    currency: 'usd',
    amount: parseInt(props.cartTotal)
  });

  cardElement = elements.create(
    'card',
    {
      style: {
        base: {
          fontFamily: 'Montserrat, sans-serif',
          fontSize: '16px',
          fontSmoothing: 'antialiased'
        },
        invalid: {
          fontFamily: 'Montserrat, sans-serif',
          iconColor: '#FF0000',
          color: '#FF0000',
        }
      },
      hidePostalCode: true
    }
  );

  // Wait for the next tick to ensure the element is in the DOM
  await nextTick();

  // Check if the element exists before mounting
  const cardElementContainer = document.querySelector('#card-element');
  if (cardElementContainer) {
    cardElement.mount(cardElementContainer);
  }

  cardElement.addEventListener('change', (event) => {
    if (event.error) {
      cardeError.value = event.error.message;
      disabled.value = true;
    } else {
      disabled.value = false;
    }
  });
});

const cardeError = ref('');
async function processPayment() {
  await stripe.createPaymentMethod({
    elements,
    params: {
      billing_details: {
        name: form.name,
        email: form.email,
        address: {
          line1: form.address,
          city: form.city,
          state: form.state,
          postal_code: form.zip_code
        }
      }
    }
  }).then((result) => {
    form.paymentMethod = result.paymentMethod;
    if (result.paymentMethod) {
      router.post(route('checkout.store'), form, {
        onBefore: (visit) => {
          disabled.value = true;
        }
      });
    }
  });
}
</script>

<template>
  <AppLayout title="Checkout">
    <div class="max-w-7xl mx-auto px-4 py-4 space-y-4 sm:px-6 md:flex md:space-y-0 md:space-x-4 lg:px-8">

      <div class="flex-1">
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">

          <form id="payment-form" @submit.prevent="processPayment">

            <div class="-mx-3 md:flex mb-6">
              <div class="px-3 mb-6 w-full md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                  Name
                </label>
                <input type="text" v-model="form.name" id="name" autofocus required
                  class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4">
                <span class="text-md text-red-600 mt-2" v-if="$page.props.errors.name">
                  {{ $page.props.errors.name }}
                </span>
              </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
              <div class="px-3 mb-6 w-full md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="address">
                  Address
                </label>
                <input type="text" v-model="form.address"
                  class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4"
                  id="address" required>
                <span class="text-md text-red-600 mt-2" v-if="$page.props.errors.address">
                  {{ $page.props.errors.address }}
                </span>
              </div>
            </div>

            <div class="-mx-3 md:flex mb-2">
              <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="city">
                  City
                </label>
                <input type="text" v-model="form.city"
                  class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4"
                  id="city" required>
                <span class="text-md text-red-600 mt-2" v-if="$page.props.errors.city">
                  {{ $page.props.errors.city }}
                </span>
              </div>
              <div class="md:w-1/2 px-3 mb-6">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="state">
                  State
                </label>
                <div class="relative">
                  <select :value="form.state" v-model="form.state" id="state" required
                    class="block appearance-none w-full bg-gray-100 text-gray-700 border border-gray-400 py-2 px-4 pr-8 rounded">
                    <option disabled value="">Please select one</option>
                    <option v-for="(state, index) in states" :key="index" :selected="state === form.state">
                      {{ state }}
                    </option>
                  </select>
                </div>
                <span class="text-md text-red-600 mt-2" v-if="$page.props.errors.state">
                  {{ $page.props.errors.state }}
                </span>
              </div>
              <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="zip_code">
                  Zip Code
                </label>
                <input type="text"
                  class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4"
                  id="zip_code" required v-model="form.zip_code">
                <span class="text-md text-red-600 mt-2" v-if="$page.props.errors.zip_code">
                  {{ $page.props.errors.zip_code }}
                </span>
              </div>
            </div>

            <div class="-mx-3 md:flex mb-6">
              <div class="px-3 mb-6 w-full md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                  Phone
                </label>
                <input type="tel" v-model="form.phone"
                  class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4"
                  id="phone"
                >
                <span v-if="$page.props.errors.phone" class="text-md text-red-600 mt-2">
                  {{ $page.props.errors.phone }}
                </span>
              </div>
            </div>

            <div class="-mx-3 mb-6">
              <div class="px-3 mb-6 w-full">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name_on_card">
                  Name on Card
                </label>
                <input type="text" v-model="form.name_on_card" required
                  class="appearance-none block w-full bg-gray-100 text-gray-700 border border-gray-400 rounded py-2 px-4"
                  id="name_on_card">
                <span class="text-md text-red-600 mt-2" v-if="$page.props.errors.name_on_card">
                  {{ $page.props.errors.name_on_card }}
                </span>
              </div>
              <div class="px-3 mb-6 w-full md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="card_element">
                  Credit Card
                </label>
                <div id="card-element"></div>
                <span v-if="$page.props.errors.message" class="text-md text-red-600 mt-2">
                  {{ $page.props.errors.message }}
                </span>
                <span class="text-md text-red-600 mt-2">
                  {{ cardeError }}
                </span>
              </div>
            </div>

            <div class="flex justify-center">
              <YellowButton type="submit" class="text-sm" :class="{ 'opacity-50 cursor-not-allowed': disabled }"
                :disabled="disabled">
                <Icon name="spinner" class="animate-spin h-5 w-5 fill-current" v-if="loading" />
                <span v-else>Pay now</span>
              </YellowButton>
            </div>

          </form>

        </div>
      </div>

      <div class="flex-1">
        <OrderTotals v-bind="props" />
      </div>

    </div>
  </AppLayout>
</template>

<style scoped>
#card-error {
  color: #ff0000;
  text-align: center;
  font-size: 16px;
  line-height: 17px;
  margin-top: 12px;
}

#card-element {
  border-radius: 0.25rem;
  padding: 12px;
  --tw-border-opacity: 1;
  border: 1px solid rgba(156, 163, 175, var(--tw-border-opacity));
  height: 44px;
  width: 100%;
  --tw-bg-opacity: 1;
  background-color: rgba(243, 244, 246, var(--tw-bg-opacity));
}
</style>
