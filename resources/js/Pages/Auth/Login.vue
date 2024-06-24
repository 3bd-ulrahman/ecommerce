<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import Checkbox from '@/Components/Checkbox.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <AppLayout title="Log in">

    <div class="max-w-7xl mx-auto px-4 py-4 space-y-4 sm:px-6 md:flex md:space-y-0 md:space-x-4 lg:px-8">

      <div class="flex-1">
        <div class="flex flex-col bg-white shadow-md rounded px-8 py-6">
          <h1 class="text-lg font-semibold text-center underline italic">Login</h1>

          <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
          </div>

          <form @submit.prevent="submit()">
            <div class="mt-4">
              <InputLabel for="email" value="Email" />
              <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
              <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
              <InputLabel for="password" value="Password" />
              <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password"
                autocomplete="new-password" required
              />
              <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4">
              <label class="flex items-center">
                <Checkbox v-model:checked="form.remember" name="remember" />
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
              </label>
            </div>

            <div class="flex items-center justify-center mt-4">
              <Link v-if="canResetPassword" :href="route('password.request')"
                class="underline text-sm text-gray-600 hover:text-gray-900"
              >
                Forgot your password?
              </Link>

              <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Log in
              </PrimaryButton>
            </div>
          </form>
        </div>
      </div>

      <div class="flex-1">
        <div class=" flex flex-col shadow-md rounded">
          <div class="bg-gray-300 px-4 py-6">
            <div class="flex flex-col items-center bg-white px-4 py-2 space-y-4">
              <Link :href="route('register')" class="underline text-gray-600 hover:text-gray-900 transition">
              Need a new account?
              </Link>
              <Link :href="route('shop.index')" class="underline text-gray-600 hover:text-gray-900 transition">Continue
              Shopping.
              </Link>
            </div>
          </div>
        </div>

      </div>

    </div>

  </AppLayout>
</template>
