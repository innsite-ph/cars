<script setup>
import top from '../include/top.vue';
import foot from '../include/foot.vue';
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'

const cars = ref([])
const searchQuery = ref("")
const checkInInput = ref('')
const checkOutInput = ref('')
const getCars = () => {
    const url = `http://127.0.0.1:8000/api/car/search?checkInDate=${checkInInput.value}&checkOutDate=${checkOutInput.value}&car=${searchQuery.value}`;
    axios.get(url)
        .then(response => {
            cars.value = response.data
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
    reserveCarForm.value.car_id = car.car_id
    reserveCarForm.value.user_id = JSON.parse(localStorage.getItem('user'))['id']
    reserveCarForm.value.checkInDate = checkInInput.value
    reserveCarForm.value.checkOutDate = checkOutInput.value
    console.log()
    reserveModal.value = true
}

</script>



<template>
    <top />
    <br><br><br>
    <div class="relative mb-4 flex w-full flex-wrap items-stretch">
        <input style="margin-left: 670px" v-model="searchQuery" type="search"
            class="relative m-0 -mr-px block w-48 min-w-0 flex-shrink-0 rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary-600 focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
            placeholder="Search" aria-label="Search" aria-describedby="button-addon3" />
            
        <div class="relative">
            <label for="checkin-date" >Check-in Date</label>
            <input id="checkin-date" v-model="checkInInput" type="datetime-local"
                class="relative z-10 m-0 -ml-px block w-50 min-w-0 rounded-none rounded-r border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary-600 focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                placeholder="Check-in" />
        </div>

        <div class="relative">
            <label for="checkout-date" >Check-out Date</label>
            <input id="checkout-date" v-model="checkOutInput" type="datetime-local"
                class="relative z-10 m-0 -ml-px block w-50 min-w-0 rounded-none rounded-r border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-1.5 text-base font-normal text-neutral-700 outline-none transition duration-300 ease-in-out focus:border-primary-600 focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200"
                placeholder="Check-out" />
        </div>

        <button @click="fetchData"
            class="relative z-[2] rounded-r border-2 border-primary px-6 py-2 text-xs font-medium uppercase text-primary transition duration-150 ease-in-out hover:bg-black hover:bg-opacity-5 focus:outline-none focus:ring-0"
            type="button" id="button-addon3" data-te-ripple-init>
            Search
        </button>
    </div>

    <div class="w-full flex justify-end items-center mb-4">
        <select style="margin-right: 400px;" id="items-per-page-select"
            class="px-2 py-1 bg-gray-200 text-gray-600 rounded-md" v-model="itemsPerPage" @change="changeItemsPerPage">
            <option value="5" selected>5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
        </select>
        <div class="order-last ml-12">
        </div>
    </div>
    <div class="table-responsive">
        <table class="w-1/2 mx-auto divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Brand</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Model</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Color</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Fuel Type </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        License Plate</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Power</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Car Year </th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Availability</th>
                    <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="(car, index) in cars.slice(firstIndex, lastIndex)" :key="index">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ car.brand }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.model }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.colour }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.fuel_type }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.license_plate }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.power }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ car.car_year }}</td>
                    <td>
                        <div v-if="!car.not_available"
                            class="bg-teal-500 hover:bg-teal-500 text-white font-bold py-2 px-4 border border-teal-500 rounded">
                            Available!
                        </div>
                        <h1 v-else
                            class="bg-red-500 hover:bg-red-500 text-white font-bold py-2 px-4 border border-red-500 rounded">
                            Not Available</h1>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button @click="() => openReserveModal(car)"
                            class="bg-indigo-500 hover:bg-indigo-500 text-white font-bold py-2 px-4 border border-indigo-500 rounded">
                            <svg style="margin: 0px;" xmlns="http://www.w3.org/2000/svg" class="h-5 w- mr-2"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3 13.414V17a1 1 0 001 1h3.586a1 1 0 00.707-.293l9-9a1 1 0 000-1.414l-3.293-3.293a1 1 0 00-1.414 0l-9 9a1 1 0 00-.293.707zm12.293-8.707a1 1 0 010 1.414l-1.586 1.586-3-3L11 3h3a1 1 0 011 1v3zM5 15h6.586L15 10.414v-3L9.414 15H5v3H3v-3a2 2 0 012-2z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <div style="margin-left: 1000px;" class="flex justify-center space-x-2">
            <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1"
                class="bg-gray-200 px-3 py-2 rounded-md text-gray-700 disabled:opacity-50">
                Prev
            </button>
            <template v-for="pageNumber in pages">
                <button @click="goToPage(pageNumber)" :class="{ 'bg-indigo-500 text-white': pageNumber === currentPage }"
                    class="bg-gray-200 px-3 py-2 rounded-md text-gray-700 hover:bg-gray-300">
                    {{ pageNumber }}
                </button>
            </template>
            <button @click="goToPage(currentPage + 1)" :disabled="currentPage === pageCount"
                class="bg-gray-200 px-3 py-2 rounded-md text-gray-700 disabled:opacity-50">
                Next
            </button>

        </div>
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
                                    class="border border-gray-300 rounded-lg py-2 px-3">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-lg font-medium mb-2">Check-out Date:</label>
                                <input type="datetime-local" v-model="reserveCarForm.checkOutDate" required
                                    class="border border-gray-300 rounded-lg py-2 px-3">
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
    <foot />
</template>
<script>
// function to update the car data

let reserveFormSubmit = ref({
    "car_id": '1',
    "user_id": '',
    "check_in_date": "",
    "check_out_date": ""
})
async function submitReserve(reserveCarForm) {
    reserveFormSubmit.value.car_id = reserveCarForm.car_id;
    reserveFormSubmit.value.user_id = reserveCarForm.user_id;
    reserveFormSubmit.value.check_in_date = reserveCarForm.checkInDate;
    reserveFormSubmit.value.check_out_date = reserveCarForm.checkOutDate;
    console.log(reserveFormSubmit.value)
    try {
        console.log({
            "car_id": reserveCarForm.car_id,
            "user_id": reserveCarForm.user_id,
            "check_in_date": reserveCarForm.checkInDate,
            "check_out_date": reserveCarForm.checkOutDate
        })
        const response = await axios.post(`http://127.0.0.1:8000/api/reservations`, {
            "car_id": reserveCarForm.car_id,
            "user_id": reserveCarForm.user_id,
            "check_in_date": reserveCarForm.checkInDate,
            "check_out_date": reserveCarForm.checkOutDate
        })
        console.log(response.data)
        const index = cars.value.findIndex(car => car.id === editedCar.value.id)
        cars.value[index] = response.data
        editModal.value = false
    } catch (error) {
        console.error(error)
    }
}
</script>