<script setup>
import top from '../include/top.vue';
import foot from '../include/foot.vue';
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'

import { TailwindPagination } from 'laravel-vue-pagination';
import Swal from 'sweetalert2';
// const cars = ref([])
const searchQuery = ref("")
const checkInInput = ref('')
const checkOutInput = ref('')

// fetch the cars data
const cars = ref({ 'data': [] })

// fetch the cars data


const getCars = (page = 1) => {
    const url = `http://127.0.0.1:8000/api/car/search?page=${page}&checkInDate=${checkInInput.value}&checkOutDate=${checkOutInput.value}&car=${searchQuery.value}`;
    axios.get(url)
        .then(response => {
            cars.value = response.data
            console.log(response.data)
        })
        .catch(error => {
            console.error(error)
        });
}

watch(searchQuery, () => {
    getCars()
})
watch(checkOutInput, () => {
    getCars()
})
watch(checkInInput, () => {
    getCars()
})

onMounted(() => {
    getCars()
})

window.addEventListener('load', () => {
    getCars();
});


const reserveCarForm = ref({
    'car_id': '',
    "user_id": '',
    'checkInDate': '',
    'checkOutDate': ''
})
const reserveModal = ref(false)
function openReserveModal(car) {
    reserveCarForm.value.car_id = car.id
    reserveCarForm.value.user_id = JSON.parse(localStorage.getItem('user'))['id']
    reserveCarForm.value.checkInDate = checkInInput.value
    reserveCarForm.value.checkOutDate = checkOutInput.value
    console.log()
    reserveModal.value = true
}


let reserveFormSubmit = ref({
    "car_id": '1',
    "user_id": '',
    "check_in_date": "",
    "check_out_date": ""
})

async function submitReserve(reserveCarForm) {
    reserveModal.value = false
    reserveFormSubmit.value.car_id = reserveCarForm.car_id;
    reserveFormSubmit.value.user_id = reserveCarForm.user_id;
    reserveFormSubmit.value.check_in_date = reserveCarForm.checkInDate;
    reserveFormSubmit.value.check_out_date = reserveCarForm.checkOutDate;
    // console.log(reserveFormSubmit.value)

    axios.post(`http://127.0.0.1:8000/api/reservations`, {
        "car_id": reserveCarForm.car_id,
        "user_id": reserveCarForm.user_id,
        "check_in_date": reserveCarForm.checkInDate,
        "check_out_date": reserveCarForm.checkOutDate,
    })
        .then(function (response) {
            console.log(response.data)
            getCars()
            if (response.data == '1') {
                Swal.fire({
                    title: 'Reservation Saved!',
                    text: 'Your reservation has been successfully saved.',
                    imageUrl: 'https://64.media.tumblr.com/6a0f1da0ff600d160a6bd41abec009d4/tumblr_mm6esrW5sp1spoqhxo6_400.gifv',
                    imageWidth: 400,
                    imageHeight: 200,
                    //   icon: 'success',
                    confirmButtonText: 'Ok'
                })

            } else {
                Swal.fire({
                    title: 'Reservation Failed!',
                    text: response.data,
                    imageUrl: 'https://64.media.tumblr.com/6a0f1da0ff600d160a6bd41abec009d4/tumblr_mm6esrW5sp1spoqhxo6_400.gifv',
                    imageWidth: 400,
                    imageHeight: 200,
                    confirmButtonText: 'Ok'
                })
            }
        })
        .catch(function (error) {

        });
}
</script>



<template>
    <top />
    <br><br><br>
    <div class="relative container mx-auto px-4">
        <div class="flex justify-center gap-2 pb-20">

            <input v-model="searchQuery" type="search"
                class="mt-6 bg-gray-200 border border-gray-300 text-dark text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 p-2.5 dark:slate-100 dark:border-slate-100 dark:placeholder-gray-400 dark:text-dark dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search" aria-label="Search" aria-describedby="button-addon3" />

            <div class="relative">
                <label for="checkin-date">Check-in Date</label>
                <input style="color: green;" id="checkin-date" v-model="checkInInput" type="datetime-local"
                    :min="minCheckinDate"
                    class="relative z-10 m-0 -ml-px block w-50 h-50 min-w-0 rounded-none rounded-r border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary-600 focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                    placeholder="Check-in" />
            </div>
            <div class="relative">
                <label for="checkout-date">Check-out Date</label>
                <input style="color: red;" id="checkout-date" v-model="checkOutInput" type="datetime-local"
                    :min="minCheckoutDate"
                    class="relative z-10 m-0 -ml-px block w-50 h-50 min-w-0 rounded-none rounded-r border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary-600 focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                    placeholder="Check-out" />
            </div>

        </div>


        <div class="table-responsive">
            <table class="w-1/2 mx-auto divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Brand</th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Model</th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Color</th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fuel Type </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            License Plate</th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Power</th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Car Year </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Availability</th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 ">
                    <!-- <tr v-for="(car, index) in cars.slice(firstIndex, lastIndex)" :key="index">
                                                                                                                 -->
                    <!-- <tr v-for="(car, index) in cars.data" :key="index"> -->
                    <tr v-for="(car, index) in cars.data" :key="index">

                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ car.brand }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.model }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.colour }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.fuel_type }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.license_plate }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.power }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.car_year }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.not_available }}</td>
                        <td>
                            <div v-if="car.not_available == null"
                                class="bg-teal-500 flex-inline hover:bg-teal-500 text-white font-bold py-2 px-4 border border-teal-500 rounded">
                                Available!
                            </div>
                            <div v-else
                                class="bg-red-500 hover:bg-red-500 text-white font-bold py-2 px-4 border border-red-500 rounded">
                                Not Available
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button v-if="car.not_available == null" @click="() => openReserveModal(car)"
                                class="bg-indigo-500 hover:bg-indigo-500 text-white font-bold py-2 px-4 border border-indigo-500 rounded"
                                title="Reserve Vehicle">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <TailwindPagination :data="cars" @pagination-change-page="getCars" />
        </div>


        <!-- ADD RESERVATION MODAL -->
        <div v-if="reserveModal" class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>

                <div class="modal bg-white rounded-lg overflow-hidden" style="z-index: 9999">
                    <div style="width: 690px;" class="px-4 py-5 sm:p-12">
                        <div class="flex items-start justify-between">
                            <h3 class="text-lg font-medium text-gray-900">Add Vehicle</h3>
                            <button @click="reserveModal = false"
                                class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="mt-5">
                            <form @submit.prevent="submitReserve(reserveCarForm)" class="space-y-4">
                                <div class="flex flex-col">
                                    <label class="text-lg font-medium mb-2">Car ID:</label>
                                    <input type="text" v-model="reserveCarForm.car_id" required
                                        class="border border-gray-300 rounded-lg py-2 px-3">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-lg font-medium mb-2">User ID:</label>
                                    <input type="text" v-model="reserveCarForm.user_id" required
                                        class="border border-gray-300 rounded-lg py-2 px-3">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-lg font-medium mb-2">Check-in Date:</label>
                                    <input type="datetime-local" v-model="reserveCarForm.checkInDate" required
                                        :min="minCheckinDate" class="border border-gray-300 rounded-lg py-2 px-3">
                                </div>
                                <div class="flex flex-col">
                                    <label class="text-lg font-medium mb-2">Check-out Date:</label>
                                    <input type="datetime-local" v-model="reserveCarForm.checkOutDate" required
                                        :min="minCheckoutDate" class="border border-gray-300 rounded-lg py-2 px-3">
                                </div>

                                <button type="submit"
                                    class="bg-blue-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline hover:bg-blue-700">Submit</button>
                            </form>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button @click="reserveModal = false"
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
export default {
    data() {
        return {
            checkInInput: "",
            checkOutInput: ""
        };
    },
    computed: {
        minCheckinDate() {
            return new Date().toISOString().slice(0, 16);
        },
        minCheckoutDate() {
            const checkInDate = new Date(this.checkInInput);
            if (checkInDate.getTime() >= new Date().getTime()) {
                return checkInDate.toISOString().slice(0, 16);
            } else {
                return new Date().toISOString().slice(0, 16);
            }
        },
        disableCheckout() {
            if (!this.checkInInput || !this.checkOutInput) {
                return false;
            }
            const checkInDate = new Date(this.checkInInput);
            const checkOutDate = new Date(this.checkOutInput);
            return checkOutDate <= checkInDate;
        }
    }
};
</script>
