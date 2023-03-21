<script>
import axios from 'axios';

export default {
    computed: {
    isLoggedIn() {
      return localStorage.getItem('token') && localStorage.getItem('user');
    }
  },
  methods: {
    logout() {
      const token = localStorage.getItem('token');
      const headers = { Authorization: `Bearer ${token}` };

      axios.post('http://127.0.0.1:8000/api/logout', null, { headers })
        .then(response => {
          localStorage.removeItem('token');
          localStorage.removeItem('user');
          this.$router.push('/login');
        })
        .catch(error => {
          console.log(error);
        });
    }
  }
}

</script>
<template>

<nav class="bg-white border-gray-200 dark:bg-gray-900">
    <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl px-4 md:px-6 py-2.5">
        <a href="https://flowbite.com" class="flex items-center">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-6 mr-3 sm:h-9" alt="Flowbite Logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
        </a>
        <div class="flex items-center">
            <a href="tel:5541251234" class="mr-6 text-sm font-medium text-gray-500 dark:text-white hover:underline">09123456789</a>
            <div v-if="isLoggedIn">
      <a href="#" @click="logout" class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline">Logout</a>
    </div>
    <div v-else>
      <a href="/login" class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline">Login</a>
    </div>
        </div>
    </div>
</nav>
<nav class="bg-gray-50 dark:bg-gray-700">
    <div class="max-w-screen-xl px-4 py-3 mx-auto md:px-6">
        <div class="flex items-center">
            <ul class="flex flex-row mt-0 mr-6 space-x-8 text-sm font-medium">
                <li>
                    <a href="/" class="text-gray-900 dark:text-white hover:underline" aria-current="page">Home</a>
                </li>
                <li>
                    <a href="#" class="text-gray-900 dark:text-white hover:underline">Company</a>
                </li>
                <li>
                    <a href="#" class="text-gray-900 dark:text-white hover:underline">Team</a>
                </li>
                <li>
                    <a href="#" class="text-gray-900 dark:text-white hover:underline">Features</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


</template>
