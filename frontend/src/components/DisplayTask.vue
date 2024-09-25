<script setup>
import {onBeforeMount, ref} from "vue";
import axios from "@/lib/axios.js";
const tasks = ref(null)
const showSuccessMessage = ref(false)
const taskModal = ref(false)
const title = ref(null);
const description = ref(null);
const SuccessMessage = ref(null)
const getTasks = async() => {
  try {
    const response = await axios.get('/todo')
    tasks.value = response.data
  } catch (error){
    console.log(error)
  }
}
const checkStatus = async(id)=>{
  try{
    await axios.post('/todo/updateStatus/'+ id);
    const index = tasks.value.findIndex(task => task.id === id);
    tasks.value[index].status = !tasks.value[index].status;
  }catch (error){
    console.log(error)
  }
}
const deleteTask = async (id) =>{
  try{
    await axios.delete('/todo/'+ id);
    const index = tasks.value.findIndex(task => task.id === id);
    tasks.value.splice(index, 1);
    showSuccessMessage.value = true;
    SuccessMessage.value = 'Запись удалена';
    // Hide the success message after 3 seconds
    setTimeout(() => {
      showSuccessMessage.value = false;
    }, 3000);
  }catch (error){
    console.log(error)
  } finally {
    getTasks();
  }
}
const selectedTask = ref(null)
const openModal =(task)=>{
  selectedTask.value = task.id;
  title.value = task.title;
  description.value = task.description;
  taskModal.value = true
}
const closeModal =()=>{
  taskModal.value = false
}
const updateTask = async ()=>{
 try{
   await axios.put('/todo/' + selectedTask.value, {
     title: title.value,
     description: description.value
   }, {
     headers: {
       'Content-Type': 'application/json'
     }
   });
   taskModal.value = false
   showSuccessMessage.value = true;
   SuccessMessage.value = 'Запись отредактирована';
   // Hide the success message after 3 seconds
   setTimeout(() => {
     showSuccessMessage.value = false;
   }, 3000);
 }catch (error){
   console.log(error)
 }finally {
   getTasks();
 }
}
onBeforeMount(()=>{
  getTasks();
})
</script>

<template>
<div class="flex flex-col mt-2 gap-2 md:max-h-screen w-full md:w-1/2" v-if="tasks">
  <div v-for="task in tasks" :key="task.id" class="flex-col w-full">
    <div class="w-full flex flex-col p-2 rounded min-h-8 hover:bg-gray-100">
      <div class="w-full flex  items-center justify-between">
        <div class="flex items-center w-full gap-2">
          <input type="checkbox" :checked="task.status" @click="checkStatus(task.id)">
          <p :class="task.status ? 'line-through break-words': 'break-words'">{{task.title}}</p>
        </div>
        <div id="actions" class="flex items-center gap-2">
          <button class="hover:text-blue-500" @click="openModal(task)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
          </button>
          <button class="hover:text-red-500" @click="deleteTask(task.id)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
            </svg>
          </button>
        </div>
      </div>
      <div class="" v-if="task.description">
        <p :class="task.status ? 'line-through break-words': 'break-words'">Описание: {{task.description}}</p>
      </div>
    </div>
  </div>
</div>
  <div class="w-screen h-screen -mx-6 backdrop-brightness-50 absolute flex items-center justify-center" v-if="taskModal">
  <div class="flex flex-col items-center bg-white p-6 rounded">
    <h1 class="text-3xl font-bold mb-3">
      Обновить задачу
    </h1>
    <div class="flex-col items-center w-full md:w-96">
      <input type="text" required v-model="title" placeholder="Название задачи" class="h-12 w-full placeholder-gray-400/70 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 " />
      <textarea type="text" v-model="description" placeholder="Описание задачи" class="mt-2 w-full placeholder-gray-400/70 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-gray-700 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 " />
      <div class="flex gap-2">
        <button @click="closeModal" class="w-full h-12 justify-center flex items-center px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-400 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-80 disabled:bg-blue-400">
          <span class="mx-1">Назад</span>
        </button>
        <button :disabled="!title" @click="updateTask" class="w-full h-12 justify-center flex items-center px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80 disabled:bg-blue-400">
          <span class="mx-1">Сохранить</span>
        </button>
      </div>
    </div>
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
        <span class="font-semibold text-emerald-500 ">{{SuccessMessage}}</span>
      </div>
    </div>
  </div>
</template>

<style scoped>

</style>