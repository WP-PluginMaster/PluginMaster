<script setup>
import { ref } from 'vue'

let counter = ref(0)

setInterval(() => {
  counter.value++
}, 1000)
</script>

<template>
  <div>
    <header class="bg-white shadow"  >
      <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <h1
            @click="counter = 0"
            class="text-3xl font-bold leading-tight text-gray-900"
        >
     <h1>Hello AL EMRAN </h1>
          {{ counter }}
        </h1>
      </div>
    </header>

  </div>
</template>
