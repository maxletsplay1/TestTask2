<script setup>
import {ref} from "vue";
import axios from "@/lib/axios.js";
const emit = defineEmits(['submit'])
const title = ref(null);
const description = ref(null);
const showSuccessMessage = ref(false)
const addTask = async () =>{
  try {
    await axios.post('/todo', {
      title: title.value,
      description: description.value
    })
    showSuccessMessage.value = true;

    // Hide the success message after 3 seconds
    setTimeout(() => {
      showSuccessMessage.value = false;
    }, 3000);
    emit('submit');
    title.value = null;
    description.value = null;
  } catch (error) {
    console.log(error)
  }
}
</script>

<template>
  <div class="flex flex-col items-center w-full">
    <h1 class="text-3xl font-bold mb-3">
      Новая задача
    </h1>
    <div class="flex-col items-center w-full md:w-96 ">
      <input type="text" required v-model="title" placeholder="Название задачи" class="h-12 w-full placeholder-gray-400/70 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 " />
      <textarea type="text" v-model="description" placeholder="Описание задачи" class="mt-2 w-full placeholder-gray-400/70 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 " />
      <button :disabled="!title" @click="addTask" class="w-full h-12 justify-center flex items-center px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80 disabled:bg-blue-400">
        <span class="mx-1">Добавить</span>
      </button>
    </div>
  </div>
  <div v-if="showSuccessMessage" class="flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md absolute bottom-2 right-2">
    <div class="flex items-center justify-center w-12 bg-emerald-500">
      <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
        <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
      </svg>
    </div>

    <div class="px-4 py-2 -mx-3">
      <div class="mx-3">
        <span class="font-semibold text-emerald-500 ">Запись создана</span>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>