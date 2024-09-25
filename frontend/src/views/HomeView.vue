<script setup>
import AddTask from "@/components/AddTask.vue";
import DisplayTask from "@/components/DisplayTask.vue";
</script>

<template>
  <div class="min-h-screen min-w-screen flex justify-center md:overflow-hidden">
    <div class="flex flex-col md:flex-row-reverse md:justify-between w-full gap-2 mx-6">
      <div class="md:w-1/2 md:h-full flex items-center justify-center">
        <AddTask class="md:w-full"/>
      </div>
      <DisplayTask class="md:w-1/2 h-screen overflow-y-auto"/>
    </div>
  </div>
</template>
