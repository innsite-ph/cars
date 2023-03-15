<script>

</script>


<template>
    <div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
      <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
          Add Vehicle
        </h2>
      </div>

      <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
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
</div>
</template>
