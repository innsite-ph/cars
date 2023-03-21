<script>
import axios from 'axios';

import top from '../include/top.vue';

import foot from '../include/foot.vue';

export default {
    components: { top , foot},
  data() {
    return {
      user: {
        name: '',
        email: '',
        password: '',
      },
      confirmPassword: '',
    };
  },
  methods: {
    async registerUser() {
      if (this.user.password !== this.confirmPassword) {
        return alert('Passwords do not match');
      }

      try {
        const response = await axios.post('http://127.0.0.1:8000/api/register', this.user);
        console.log(response.data);
      } catch (error) {
        console.error(error);
      }
    },
  },
};
</script>


<template>
    <top/>
    <div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Register an account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Or
          <router-link to="/login" class="font-medium text-indigo-600 hover:text-indigo-500">
            sign in to your account
          </router-link>
        </p>
      </div>

      <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
   <form class="space-y-6" @submit.prevent="registerUser">
    <div>
      <label for="name" class="block text-sm font-medium text-gray-700">
        Name
      </label>
      <div class="mt-1">
        <input
          id="name"
          name="name"
          type="text"
          autocomplete="name"
          required
          class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          v-model="user.name"
        />
      </div>
    </div>

    <div>
      <label for="email" class="block text-sm font-medium text-gray-700">
        Email address
      </label>
      <div class="mt-1">
        <input
          id="email"
          name="email"
          type="email"
          autocomplete="email"
          required
          class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          v-model="user.email"
        />
      </div>
    </div>

    <div>
      <label for="password" class="block text-sm font-medium text-gray-700">
        Password
      </label>
      <div class="mt-1">
        <input
          id="password"
          name="password"
          type="password"
          autocomplete="new-password"
          required
          class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          v-model="user.password"
        />
      </div>
    </div>

    <div>
      <label for="confirm-password" class="block text-sm font-medium text-gray-700">
        Confirm Password
      </label>
      <div class="mt-1">
        <input
          id="confirm-password"
          name="confirm-password"
          type="password"
          autocomplete="new-password"
          required
          class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          v-model="confirmPassword"
        />
      </div>
    </div>

    <div>
      <button
        type="submit"
        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Register
      </button>
    </div>
  </form>
</div>
</div>
</div>
<foot/>
</template>
