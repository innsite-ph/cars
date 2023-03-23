<script>
import axios from 'axios';
import Swal from 'sweetalert2';

import top from '../include/top.vue';
import foot from '../include/foot.vue';

const API_URL = 'http://127.0.0.1:8000/api/login';

export default {
  components: { top, foot },

  data() {
    return {
      email: '',
      password: '',
      error: '',
    }
  },
  created() {
  const token = localStorage.getItem('token');
  const user = localStorage.getItem('user');
  if (token && user) {
    this.isLoggedIn = true;
    this.user = JSON.parse(user).name;
  }
},
mounted() {
  const token = localStorage.getItem('token');
  const user = localStorage.getItem('user');
  if (token && user) {
    this.isLoggedIn = true;
    this.user = JSON.parse(user).name;
  }
},
methods: {
  login() {
    axios.post(API_URL, {
      email: this.email,
      password: this.password,
    })
    .then(response => {
      const token = response.data;
      localStorage.setItem('token', token['data']['token']);
      localStorage.setItem('user', JSON.stringify(token['data']['user']));
      this.isLoggedIn = true;
      this.user = token['data']['user']['name'];

      // Show success message
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });

      Toast.fire({
        icon: 'success',
        title: `Welcome Back! ${this.user}.  Signed in successfully`
      });

      this.$router.push('/');
    })
    .catch(error => {
      this.error = error.response.data.message;
      console.log(this.error);
    });
  },
},
}


</script>

<template>
    <top/>
    <div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Sign in to your account
        </h2>
        <p class="mt-2 text-center text-sm text-gray-600">
          Or
          <a href="/register" class="font-medium text-indigo-600 hover:text-indigo-500">
            create an account
          </a>
        </p>
      </div>

      <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
          <form class="space-y-6" @submit.prevent="login">
            <div>
              <label for="email" class="block text-sm font-medium text-gray-700">
                Email address
              </label>
              <div class="mt-1">
                <input v-model="email" id="email" name="email" type="email" autocomplete="off" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              </div>
            </div>

            <div>
              <label for="password" class="block text-sm font-medium text-gray-700">
                Password
              </label>
              <div class="mt-1">
                <input v-model="password" id="password" name="password" type="password" autocomplete="off" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              </div>
            </div>
<!--
            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="remember-me" class="ml-2 block text-sm text-gray-900">
                  Remember me
                </label>
              </div>

              <div class="text-sm">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">
                  Forgot your password?
                </a>
              </div>
            </div> -->

            <div>
              <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Sign in
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <foot/>
  </template>
