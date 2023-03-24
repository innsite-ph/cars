<script>
import axios from 'axios';
export default {
    computed: {
    isLoggedIn() {
      return localStorage.getItem('token') && localStorage.getItem('user');
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
  // any additional logic you need here
    const token = localStorage.getItem('token');
    const user = localStorage.getItem('user');
    if (token && user) {
      this.isLoggedIn = true;
      this.user = JSON.parse(user).name;
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
        <a href="/" class="flex items-center">
            <img src="../assets/image/car-key.png" class="h-6 mr-3 sm:h-9" alt="Flowbite Logo" />
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Car Reservation</span>
        </a>
        <div class="flex items-center">
            <ul class="flex flex-row mt-0 mr-6 space-x-8 text-sm font-medium">
                <li>
                    <a href="/" class="text-gray-900 dark:text-white hover:underline" aria-current="page">Home</a>
                </li>
                <li>
                    <a href="/car" class="text-gray-900 dark:text-white hover:underline">Manage Vehicles</a>
                </li>
                <li>
                    <a href="/reservation" class="text-gray-900 dark:text-white hover:underline">Reservation</a>
                </li>
            </ul>
        </div>
        <div class="flex items-center">
            <h1 class="mr-6 text-sm font-medium text-gray-500 dark:text-white" v-if="isLoggedIn">Welcome Back! {{ user }}</h1>
            <h1 class="mr-6 text-sm font-medium text-gray-500 dark:text-white" v-else></h1>
            <div v-if="isLoggedIn">
      <a href="#" @click="logout" class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline">Logout</a>
    </div>
    <div v-else>
      <a href="/login" class="text-sm font-medium text-blue-600 dark:text-blue-500 hover:underline">Login</a>
    </div>
        </div>
    </div>
</nav>
</template>