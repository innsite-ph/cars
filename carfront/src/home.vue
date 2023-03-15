<script setup>

</script>

<template>
<h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
     Vehicle Rental Service
    </h2>

    <br><br><br>


    <div class="w-full flex justify-end items-center mb-4">
  <div class="order-last ml-12">

<button @click="showModal = true" style="margin-right: 490px;" class="modal-open inline-flex items-center justify-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 4h6a2 2 0 012 2v2h3a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2v-8a2 2 0 012-2h3V6a2 2 0 012-2z" />
      </svg>
      Rent a Car
    </button>


  </div>
</div>

<div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
  <div class="flex items-center justify-center min-h-screen">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>

    <div class="modal bg-white rounded-lg overflow-hidden" style="z-index: 9999">
      <div style="width: 490px;" class="px-4 py-5 sm:p-12">
        <div class="flex items-start justify-between">
          <h3 class="text-lg font-medium text-gray-900">Add Vehicle</h3>
          <button @click="showModal = false" class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
            <span class="sr-only">Close</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>

        <div class="mt-5">
            <form class="space-y-6" @submit.prevent="register">

<div>
  <label for="brand" class="block text-sm font-medium text-gray-700">
    Car Brand
  </label>
  <div class="mt-1">
    <input id="brand" name="brand" type="text" autocomplete="off" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="brand">
  </div>
</div>

 <div>
  <label for="model" class="block text-sm font-medium text-gray-700">
    Car Model
  </label>
  <div class="mt-1">
    <input id="model" name="model" type="text" autocomplete="off" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="model">
  </div>
</div>

<div>
<label for="year" class="block text-sm font-medium text-gray-700">
Car Year
</label>
<div class="mt-1">
<input id="year" name="year" type="text" autocomplete="off" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="year">
</div>
</div>

<div>
<label for="color" class="block text-sm font-medium text-gray-700">
Car Color
</label>
<div class="mt-1">
<input id="color" name="color" type="text" autocomplete="off" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="color">
</div>
</div>

<div>
<label for="license_plate" class="block text-sm font-medium text-gray-700">
Car License Plate
</label>
<div class="mt-1">
<input id="license_plate" name="license_plate" type="text" autocomplete="off" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="license_plate">
</div>
</div>

<div>
<label for="gearbox_type" class="block text-sm font-medium text-gray-700">
Car Gearbox Type
</label>
<div class="mt-1">
<input id="gearbox_type" name="gearbox_type" type="text" autocomplete="off" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="gearbox_type">
</div>
</div>

<div>
<label for="fuel_type" class="block text-sm font-medium text-gray-700">
Car Fuel Type
</label>
<div class="mt-1">
<input id="fuel_type" name="fuel_type" type="text" autocomplete="off" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="fuel_type">
</div>
</div>

<div>
<label for="power" class="block text-sm font-medium text-gray-700">
Car Horse Power
</label>
<div class="mt-1">
<input id="power" name="power" type="text" autocomplete="off" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="power">
</div>
</div>

<div>
<label for="engine_capacity" class="block text-sm font-medium text-gray-700">
Car Engine Capacity
</label>
<div class="mt-1">
<input id="engine_capacity" name="engine_capacity" type="text" autocomplete="off" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="engine_capacity">
</div>
</div>

<div>
<label for="engine_code" class="block text-sm font-medium text-gray-700">
Car Engine Code
</label>
<div class="mt-1">
<input id="engine_code" name="engine_code" type="text" autocomplete="off" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="engine_code">
</div>
</div>

<div>
<label for="vin" class="block text-sm font-medium text-gray-700">
Car Vehicle Identification Number
</label>
<div class="mt-1">
<input id="vin" name="vin" type="text" autocomplete="off" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" v-model="vin">
</div>
</div>

<div>
    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
Register
</button>
</div>
</form>
        </div>
      </div>

      <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <button @click="showModal = false" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-transparent rounded-md hover:bg-gray-200 focus:outline-none focus:bg-gray-200 focus:shadow-outline-blue active:bg-gray-200 transition ease-in-out duration-150">
          Close
        </button>
        <button class="inline-flex justify-center ml-3 px-4 py-2 text-sm font-medium text-white bg-blue-500 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150"
                @click="submit">
          Submit
        </button>
      </div>
    </div>
  </div>
    </div>

<table class="w-1/2 mx-auto divide-y divide-gray-200">
  <thead>
    <tr>
      <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
      <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
      <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
      <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
      <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
      <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
    </tr>
  </thead>
  <tbody class="bg-white divide-y divide-gray-200">
    <tr>
      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">John Doe</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Software Engineer</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Active</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Admin</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">johndoe@example.com</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
        <a href="#" class="text-red-600 hover:text-red-900 ml-4">Delete</a>
      </td>
    </tr>
    <tr>
      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Jane Smith</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Product Manager</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">Inactive</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">User</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">janesmith@example.com</td>
      <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
        <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
        <a href="#" class="text-red-600 hover:text-red-900 ml-4">Delete</a>
      </td>
    </tr>
    <!-- ... -->
  </tbody>
</table>


</template>

<script>
export default {
  data() {
    return {
      showModal: false,
    };
  },

  methods: {
    submit() {
      // Handle form submission
    },
  },
};
</script>
