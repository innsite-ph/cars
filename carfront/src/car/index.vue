<script>

import axios from 'axios';
import top from '../include/top.vue';
import foot from '../include/foot.vue';


export default {
  components: { top, foot },
}

</script>


<template>
<top/>
<section class="bg-cover bg-center h-screen flex items-center" style="background-image: url('src/assets/image/homecars.jpg');backdrop-filter: blur(5px);">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto text-center">
      <h1 class="text-4xl sm:text-5xl md:text-6xl hover:text-white font-extrabold text-gray-400 leading-tight mb-5">
        Find the ideal car for you.
      </h1>
      <p class="text-xl sm:text-2xl md:text-3xl hover:text-white text-gray-400 mb-12">
        Drive your dreams with Car Rental
      </p>
      <a href="/car" class="bg-transparent hover:bg-black text-white font-semibold py-3 px-8 rounded-lg">
        Rent now!
      </a>
    </div>
  </div>
</section>

<foot/>
</template>
