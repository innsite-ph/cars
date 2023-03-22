<script setup>

import Swal from 'sweetalert2';
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'

const cars = ref([])
const searchQuery = ref("")

const fetchData = () => {
  axios.get(`http://127.0.0.1:8000/api/cars?query=${searchQuery.value}`)
    .then(response => {
      cars.value = response.data
    })
    .catch(error => {
      console.error(error)
    })
}

watch(searchQuery, () => {
  fetchData()
})

onMounted(() => {
  fetchData()
})

    function deleteCar(id) {
    const swalWithTailwindButtons = Swal.mixin({
  customClass: {
    confirmButton: 'bg-green-500 text-white px-4 py-2 rounded-md mr-3',
    cancelButton: 'bg-red-500 text-white px-4 py-2 rounded-md'
  },
  buttonsStyling: false
})

    swalWithTailwindButtons.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
        axios.delete(`http://127.0.0.1:8000/api/cars/${id}`)
            .then(response => {
            console.log(response.data)
            // Remove the deleted car from the list of cars
            cars.value = cars.value.filter(car => car.id !== id)
            swalWithTailwindButtons.fire(
                'Deleted!',
                'Your data has been deleted.',
                'success'
            )
            })
            .catch(error => {
            console.error(error)
            })
        } else if (
        /* Read more about handling dismissals below */
        result.dismiss === Swal.DismissReason.cancel
        ) {
        swalWithTailwindButtons.fire(
            'Cancelled',
            'The data is safe :)',
            'error'
        )
        }
    })
    }

const editedCar = ref({})
const showModal = ref(false)
const editModal = ref(false)

const newCar = ref({
  vin: '',
  license_plate: '',
  brand: '',
  model: '',
  gearbox_type: '',
  colour: '',
  fuel_type: '',
  engine_capacity: '',
  power: '',
  engine_code: '',
  car_year: '',
})

function createCar() {
  const carData = JSON.stringify(newCar.value);
  const carExists = localStorage.getItem("carData");

  // Check if the car data already exists in local storage
  if (carData === carExists) {
    console.log("Car data already exists");
    return;
  }

  axios.post('http://127.0.0.1:8000/api/cars', newCar.value)
    .then(response => {
      console.log(response.data)
      localStorage.removeItem("carData");

      // Add the new car to the list of cars
      cars.value.push(response.data)
      // Reset the form
      newCar.value = {
        vin: '',
        license_plate: '',
        brand: '',
        model: '',
        gearbox_type: '',
        colour: '',
        fuel_type: '',
        engine_capacity: '',
        power: '',
        engine_code: '',
        car_year: '',
      }
      showModal.value = false
      localStorage.setItem("carData", JSON.stringify(response.data));
    })
    .catch(error => {
      console.error(error)
    })
}

window.addEventListener('load', () => {
  fetchData();
});

function openEditModal(id) {
  const car = cars.value.find(car => car.id === id)
  editedCar.value = car
  editModal.value = true
}

// function to update the car data
async function updateCar() {
  try {
    const response = await axios.put(`http://127.0.0.1:8000/api/cars/${editedCar.value.id}`, editedCar.value)
    console.log(response.data)
    const index = cars.value.findIndex(car => car.id === editedCar.value.id)
    cars.value[index] = response.data
    editModal.value = false
  } catch (error) {
    console.error(error)
  }
}

// fetch the cars data
axios.get('http://127.0.0.1:8000/api/cars')
  .then(response => {
    cars.value = response.data
  })
  .catch(error => {
    console.error(error)
  })

</script>



<template>
<top/>


  <br><br><br>
<!--
  @input="fetchData" -->
  <div class="flex justify-center">
    <div class="mb-3 xl:w-96">
      <div class="relative mb-4 flex w-full flex-wrap items-stretch">
        <input
  v-model="searchQuery"
  type="search"
  class="relative m-0 -mr-px block w-[1%] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary-600 focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
  placeholder="Search"
  aria-label="Search"
  aria-describedby="button-addon3"
/>
            <!-- <button
            @click="fetchData"
            class="relative z-[2] rounded-r border-2 border-primary px-6 py-2 text-xs font-medium uppercase text-primary transition duration-150 ease-in-out hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0"
            type="button"
            id="button-addon3"
            data-te-ripple-init
            >
            Search
            </button> -->
      </div>
    </div>
  </div>

  <div class="w-full flex justify-end items-center mb-4">
    <select id="items-per-page-select" class="px-2 py-1 bg-gray-200 text-gray-600 rounded-md" v-model="itemsPerPage" @change="changeItemsPerPage">
  <option value="5" selected>5</option>
  <option value="10" >10</option>
  <option value="15">15</option>
  <option value="20">20</option>
</select>
    <div class="order-last ml-12">
      <button @click="showModal = true" style="margin-right: 250px;"
        class="modal-open inline-flex items-center justify-center px-4 py-2 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 4h6a2 2 0 012 2v2h3a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2v-8a2 2 0 012-2h3V6a2 2 0 012-2z" />
        </svg>
        Add a Car
      </button>
    </div>
  </div>

  <div v-if="showModal" class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>

      <div class="modal bg-white rounded-lg overflow-hidden" style="z-index: 9999">
        <div style="width: 690px;" class="px-4 py-5 sm:p-12">
          <div class="flex items-start justify-between">
            <h3 class="text-lg font-medium text-gray-900">Add Vehicle</h3>
            <button @click="showModal = false"
              class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
              <span class="sr-only">Close</span>
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <div class="mt-5">
            <form class="space-y-6" @submit.prevent="createCar">

              <div>
                <label for="brand" class="block text-sm font-medium text-gray-700">
                  Car Brand
                </label>
                <div class="mt-1">
                  <input id="brand" name="brand" type="text" autocomplete="off" v-model="newCar.brand" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="model" class="block text-sm font-medium text-gray-700">
                  Car Model
                </label>
                <div class="mt-1">
                  <input id="model" name="model" type="text" autocomplete="off" v-model="newCar.model" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="year" class="block text-sm font-medium text-gray-700">
                  Car Year
                </label>
                <div class="mt-1">
                  <input id="year" name="car_year" type="date" autocomplete="off" v-model="newCar.car_year" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="color" class="block text-sm font-medium text-gray-700">
                  Car Color
                </label>
                <div class="mt-1">
                  <input id="color" name="colour" type="text" autocomplete="off" v-model="newCar.colour" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="license_plate" class="block text-sm font-medium text-gray-700">
                  Car License Plate
                </label>
                <div class="mt-1">
                  <input id="license_plate" name="license_plate" type="text" autocomplete="off"
                    v-model="newCar.license_plate" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="gearbox_type" class="block text-sm font-medium text-gray-700">
                  Car Gearbox Type
                </label>
                <div class="mt-1">
                  <input id="gearbox_type" name="gearbox_type" type="text" autocomplete="off"
                    v-model="newCar.gearbox_type" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="fuel_type" class="block text-sm font-medium text-gray-700">
                  Car Fuel Type
                </label>
                <div class="mt-1">
                  <input id="fuel_type" name="fuel_type" type="text" autocomplete="off" v-model="newCar.fuel_type"
                    required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="power" class="block text-sm font-medium text-gray-700">
                  Car Horse Power
                </label>
                <div class="mt-1">
                  <input id="power" name="power" type="text" autocomplete="off" v-model="newCar.power" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="engine_capacity" class="block text-sm font-medium text-gray-700">
                  Car Engine Capacity
                </label>
                <div class="mt-1">
                  <input id="engine_capacity" name="engine_capacity" type="text" autocomplete="off"
                    v-model="newCar.engine_capacity" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="engine_code" class="block text-sm font-medium text-gray-700">
                  Car Engine Code
                </label>
                <div class="mt-1">
                  <input id="engine_code" name="engine_code" type="text" autocomplete="off" v-model="newCar.engine_code"
                    required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="vin" class="block text-sm font-medium text-gray-700">
                  Car Vehicle Identification Number
                </label>
                <div class="mt-1">
                  <input id="vin" name="vin" type="text" autocomplete="off" v-model="newCar.vin" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <button type="submit"
                  class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
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

      </div>
      </div>
    </div>
  </div>
<div class="table-responsive">
  <table class="w-1/2 mx-auto divide-y divide-gray-200">
    <thead>
      <tr>
        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">VIN</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">License
          Plate</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gearbox Type
        </th>
        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Color</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fuel Type
        </th>
        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Engine
          Capacity</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Power</th>
        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Engine Code
        </th>
        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car Year
        </th>
        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
      </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
      <!-- <tr v-for="(car, index) in cars" :key="index"> -->
        <tr v-for="(car, index) in cars.slice(firstIndex, lastIndex)" :key="index">
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ car.vin }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.license_plate }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.brand }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.model }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.gearbox_type }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.colour }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.fuel_type }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.engine_capacity }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.power }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.engine_code }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.car_year }}</td>
        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
            <button @click="() => openEditModal(car.id)" class="inline-flex items-center px-1 py-1 border border-transparent rounded-md font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w- mr-2" viewBox="0 0 20 20" fill="currentColor">
    <path fill-rule="evenodd" d="M3 13.414V17a1 1 0 001 1h3.586a1 1 0 00.707-.293l9-9a1 1 0 000-1.414l-3.293-3.293a1 1 0 00-1.414 0l-9 9a1 1 0 00-.293.707zm12.293-8.707a1 1 0 010 1.414l-1.586 1.586-3-3L11 3h3a1 1 0 011 1v3zM5 15h6.586L15 10.414v-3L9.414 15H5v3H3v-3a2 2 0 012-2z" clip-rule="evenodd" />
  </svg>
  Edit
</button>
<button style="margin-left: 3px;" @click="() => deleteCar(car.id)" class="inline-flex items-center px-1 py-1 border border-transparent rounded-md font-semibold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w- mr-2" viewBox="0 0 20 20" fill="currentColor">
    <path fill-rule="evenodd" d="M16.707 3.293a1 1 0 00-1.414 0L10 8.586l-5.293-5.293a1 1 0 00-1.414 1.414L8.586 10l-5.293 5.293a1 1 0 001.414 1.414L10 11.414l5.293 5.293a1 1 0 001.414-1.414L11.414 10l5.293-5.293a1 1 0 000-1.414z" clip-rule="evenodd" />
  </svg>
  Delete
</button>


      </td>
    </tr>
  </tbody>
</table>
<br>
    <div style="margin-left: 1600px;" class="flex justify-center space-x-2">
    <button
      @click="goToPage(currentPage - 1)"
      :disabled="currentPage === 1"
      class="bg-gray-200 px-3 py-2 rounded-md text-gray-700 disabled:opacity-50"
    >
      Prev
    </button>
    <template v-for="pageNumber in pages">
      <button
        @click="goToPage(pageNumber)"
        :class="{ 'bg-indigo-500 text-white': pageNumber === currentPage }"
        class="bg-gray-200 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-300"
      >
        {{ pageNumber }}
      </button>
    </template>
    <button
      @click="goToPage(currentPage + 1)"
      :disabled="currentPage === pageCount"
      class="bg-gray-200 px-3 py-2 rounded-md text-gray-700 disabled:opacity-50"
    >
      Next
    </button>

</div>
</div>



<div v-if="editModal" class="fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen">
      <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>

      <div class="modal bg-white rounded-lg overflow-hidden" style="z-index: 9999">
        <div style="width: 690px;" class="px-4 py-5 sm:p-12">
          <div class="flex items-start justify-between">
            <h3 class="text-lg font-medium text-gray-900">Add Vehicle</h3>
            <button @click="editModal = false"
              class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
              <span class="sr-only">Close</span>
              <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </button>
          </div>

          <div class="mt-5">
            <form class="space-y-6" @submit.prevent="updateCar">

              <div>
                <label for="brand" class="block text-sm font-medium text-gray-700">
                  Car Brand
                </label>
                <div class="mt-1">
                  <input id="brand" name="brand" type="text" autocomplete="off" v-model="editedCar.brand" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="model" class="block text-sm font-medium text-gray-700">
                  Car Model
                </label>
                <div class="mt-1">
                  <input id="model" name="model" type="text" autocomplete="off" v-model="editedCar.model" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="year" class="block text-sm font-medium text-gray-700">
                  Car Year
                </label>
                <div class="mt-1">
                  <input id="year" name="car_year" type="date" autocomplete="off" v-model="editedCar.car_year" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="color" class="block text-sm font-medium text-gray-700">
                  Car Color
                </label>
                <div class="mt-1">
                  <input id="color" name="colour" type="text" autocomplete="off" v-model="editedCar.colour" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="license_plate" class="block text-sm font-medium text-gray-700">
                  Car License Plate
                </label>
                <div class="mt-1">
                  <input id="license_plate" name="license_plate" type="text" autocomplete="off"
                    v-model="editedCar.license_plate" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="gearbox_type" class="block text-sm font-medium text-gray-700">
                  Car Gearbox Type
                </label>
                <div class="mt-1">
                  <input id="gearbox_type" name="gearbox_type" type="text" autocomplete="off"
                    v-model="editedCar.gearbox_type" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="fuel_type" class="block text-sm font-medium text-gray-700">
                  Car Fuel Type
                </label>
                <div class="mt-1">
                  <input id="fuel_type" name="fuel_type" type="text" autocomplete="off" v-model="editedCar.fuel_type"
                    required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="power" class="block text-sm font-medium text-gray-700">
                  Car Horse Power
                </label>
                <div class="mt-1">
                  <input id="power" name="power" type="text" autocomplete="off" v-model="editedCar.power" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="engine_capacity" class="block text-sm font-medium text-gray-700">
                  Car Engine Capacity
                </label>
                <div class="mt-1">
                  <input id="engine_capacity" name="engine_capacity" type="text" autocomplete="off"
                    v-model="editedCar.engine_capacity" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="engine_code" class="block text-sm font-medium text-gray-700">
                  Car Engine Code
                </label>
                <div class="mt-1">
                  <input id="engine_code" name="engine_code" type="text" autocomplete="off" v-model="editedCar.engine_code"
                    required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <label for="vin" class="block text-sm font-medium text-gray-700">
                  Car Vehicle Identification Number
                </label>
                <div class="mt-1">
                  <input id="vin" name="vin" type="text" autocomplete="off" v-model="editedCar.vin" required
                    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
              </div>

              <div>
                <button type="submit"
                  class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Update
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
        <button @click="editModal = false" class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-transparent rounded-md hover:bg-gray-200 focus:outline-none focus:bg-gray-200 focus:shadow-outline-blue active:bg-gray-200 transition ease-in-out duration-150">
          Close
        </button>

      </div>
      </div>
    </div>
  </div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<foot/>
</template>
<script>
import { ref, computed} from 'vue';

import top from './include/top.vue';
import foot from './include/foot.vue';

export default {

  components: { top, foot },
  data() {
    return {
      isLoggedIn: false,
      user: '',
      currentPage: 1,
    itemsPerPage: 5,
    cars: []
    }
  },
  mounted() {
    const token = localStorage.getItem('token');
    const user = localStorage.getItem('user');
    if (token && user) {
      this.isLoggedIn = true;
      this.user = JSON.parse(user).name;
    }
    axios.get('http://127.0.0.1:8000/api/cars')
    .then(response => {
      this.cars = response.data;
      console.log()
    })
    .catch(error => {
      console.log(error);
    });
  },
  computed: {
  firstIndex() {
    return (this.currentPage - 1) * this.itemsPerPage;
  },
  lastIndex() {
    return this.currentPage * this.itemsPerPage;
  },
  totalPages() {
    return Math.ceil(this.cars.length / this.itemsPerPage);
  }
},
methods: {
  prevPage() {
    if (this.currentPage > 1) {
      this.currentPage--;
      console.log('currentPage:', this.currentPage);
    }
  },
  nextPage() {
    if (this.currentPage < Math.ceil(this.cars.length / this.itemsPerPage)) {
      this.currentPage++;
      console.log('currentPage:', this.currentPage);
    }
  }
}



}

</script>
