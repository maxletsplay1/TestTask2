<script setup>
import AddTask from "@/components/AddTask.vue";
import DisplayTask from "@/components/DisplayTask.vue";
import {ref} from "vue";
const ticker = ref(1);
const tick = () =>{
  ticker.value++
  console.log(ticker.value)
}
</script>

<template>
  <div class="min-h-screen min-w-screen flex justify-center md:overflow-hidden">
    <div class="flex flex-col md:flex-row-reverse md:justify-between w-full gap-2 mx-6">
      <div class="md:w-1/2 md:h-full flex items-center justify-center">
        <AddTask @submit="tick" class="md:w-full"/>
      </div>
      <DisplayTask :ticker="ticker" class="md:w-1/2 h-screen overflow-y-auto"/>
    </div>
  </div>
</template>
