<script setup>

import Swal from 'sweetalert2';
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'


import { TailwindPagination } from 'laravel-vue-pagination';
// const cars = ref([])
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
  // const swalWithTailwindButtons = Swal.mixin({
  //   customClass: {
  //     confirmButton: 'bg-green-500 text-white px-4 py-2 rounded-md mr-3',
  //     cancelButton: 'bg-red-500 text-white px-4 py-2 rounded-md'
  //   },
  //   buttonsStyling: false
  // })
  // swalWithTailwindButtons.fire({
  //   title: 'Are you sure?',
  //   text: "You won't be able to revert this!",
  //   icon: 'warning',
  //   showCancelButton: true,
  //   confirmButtonText: 'Yes, delete it!',
  //   cancelButtonText: 'No, cancel!',
  //   reverseButtons: true
  // })
  // if (result.isConfirmed) {
  //     axios.delete(`http://127.0.0.1:8000/api/cars/${id}`)
  //       .then(response => {
  //         console.log(response.data)
  //         // Remove the deleted car from the list of cars
  //         // cars.value = cars.value.filter(car => car.id !== id)
  //         swalWithTailwindButtons.fire(
  //           'Deleted!',
  //           'Your data has been deleted.',
  //           'success'
  //         )
  //       location.reload()
  //       })
  //       .catch(error => {
  //         console.error(error)
  //       })
  //   }





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
          // cars.value = cars.value.filter(car => car.id !== id)
          swalWithTailwindButtons.fire(
            'Deleted!',
            'Your data has been deleted.',
            'success'
          )
          // location.reload()
          carDito();
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
      // cars.value.push(response.data)
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
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Vehicle has been added!',
        showConfirmButton: false,
        timer: 1500
      })
      carDito();
    })
    .catch(error => {
      console.error(error)
    })
}

window.addEventListener('load', () => {
  fetchData();
});

function openEditModal(id) {
  const car = id
  editedCar.value = car
  editModal.value = true
}

// function to update the car data
async function updateCar() {
  try {
    const response = await axios.put(`http://127.0.0.1:8000/api/cars/${editedCar.value.id}`, editedCar.value)
    console.log(response.data)
    // const index = cars.value.findIndex(car => car.id === editedCar.value.id)
    // cars.value[index] = response.data
    editModal.value = false

    Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: 'Update vehicle success!',
      showConfirmButton: false,
      timer: 1500
    })
  } catch (error) {
    console.error(error)
  }
}

// fetch the cars data
// axios.get('http://127.0.0.1:8000/api/cars')
//   .then(response => {
//     cars.value = response.data
//   })
//   .catch(error => {
//     console.error(error)
//   })
const cars = ref({ 'data': [] })
// fetch the cars data
const carDito = (page = 1) => {
  axios.get(`http://127.0.0.1:8000/api/cars?page=${page}`)
    .then(response => {
      cars.value = response.data
      console.log(response)
    })
    .catch(error => {
      console.error(error)
    })
}

</script>



<template>
  <top />

  <div class="container mx-auto px-4">
    <div class="flex justify-between pt-20">
      <div class="mb-3 xl:w-96">
        <div class="relative mb-4 flex w-full flex-wrap items-stretch">
          <div>
            <label class="text-lg font-black text-cyan-400" for="search">Search Here</label>
            <input id="search" v-model="searchQuery" type="search"
              class="bg-gray-200 border border-gray-300 text-dark text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:slate-100 dark:border-slate-100 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500"
              placeholder="Search" aria-label="Search" aria-describedby="button-addon3" />
          </div>
        </div>
      </div>
      <button @click="showModal = true"
        class="inline-flex items-center px-3 my-5 bg-cyan-500 hover:bg-cyan-400 text-white text-sm font-semibold rounded-md shadow focus:outline-none">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 4h6a2 2 0 012 2v2h3a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2v-8a2 2 0 012-2h3V6a2 2 0 012-2z" />
        </svg>
        Add Vehicle
      </button>
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
            <button @click="showModal = false"
              class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-transparent rounded-md hover:bg-gray-200 focus:outline-none focus:bg-gray-200 focus:shadow-outline-blue active:bg-gray-200 transition ease-in-out duration-150">
              Close
            </button>

          </div>
        </div>
      </div>
    </div>
    <div class="overflow">
      <table class="table-auto w-full divide-y divide-gray-200">
        <thead>
          <tr>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">VIN</th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">License
              Plate</th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gearbox
              Type
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Color
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fuel
              Type
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Engine
              Capacity</th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Power
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Engine
              Code
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Car Year
            </th>
            <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200" v-if="cars.data.length > 0">
          <!-- <tr v-for="(car, index) in cars" :key="index"> -->
          <tr v-for="(car, index) in cars.data" :key="index">
            <td class="px-6 py-4  text-sm font-medium text-gray-900">{{ car.vin }}</td>
            <td class="px-6 py-4  text-sm text-gray-500">{{ car.license_plate }}</td>
            <td class="px-6 py-4  text-sm text-gray-500">{{ car.brand }}</td>
            <td class="px-6 py-4  text-sm text-gray-500">{{ car.model }}</td>
            <td class="px-6 py-4  text-sm text-gray-500">{{ car.gearbox_type }}</td>
            <td class="px-6 py-4  text-sm text-gray-500">{{ car.colour }}</td>
            <td class="px-6 py-4  text-sm text-gray-500">{{ car.fuel_type }}</td>
            <td class="px-6 py-4  text-sm text-gray-500">{{ car.engine_capacity }}</td>
            <td class="px-6 py-4  text-sm text-gray-500">{{ car.power }}</td>
            <td class="px-6 py-4  text-sm text-gray-500">{{ car.engine_code }}</td>
            <td class="px-6 py-4  text-sm text-gray-500">{{ car.car_year }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <button @click="() => openEditModal(car)" title="Edit Vehicle"
                class="inline-flex items-center px-1 py-1 border border-transparent rounded-md font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
              </button>
              <button style="margin-left: 3px;" @click="() => deleteCar(car.id)"
                class="inline-flex items-center px-1 py-1 border border-transparent rounded-md font-semibold text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                title="Delete">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <TailwindPagination :data="cars" @pagination-change-page="carDito" />
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
                    <input id="engine_code" name="engine_code" type="text" autocomplete="off"
                      v-model="editedCar.engine_code" required
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
            <button @click="editModal = false"
              class="inline-flex justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-transparent rounded-md hover:bg-gray-200 focus:outline-none focus:bg-gray-200 focus:shadow-outline-blue active:bg-gray-200 transition ease-in-out duration-150">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <foot />
</template>
<script>
import { ref, computed } from 'vue';

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
