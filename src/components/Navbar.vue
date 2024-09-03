<script> 
 // funktioniert so noch nicht
 import logo from '@/assets/logo.svg';
 import home from '@/assets/home.svg';
</script>

<template>
<nav class="bg-green-700 border-b border-green-500 lg:mt-7 mr-7 ml-7 md:mt-7 sm:mt-0 rounded-lg">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="flex h-20 items-center justify-between">
        <div class="flex flex-1 items-center justify-start">
        <a class="flex flex-shrink-0 items-center mr-4" href="index.html">
          <img class="h-10 w-auto" src="..\assets\logo.svg" alt="Logo" />
          <!-- Weg? -->
          <!-- <span class="hidden md:block text-white text-2xl font-bold ml-2">Smart Sensor Netz</span> -->
        </a>
        
        <div class="flex flex-1 items-center justify-center">
          <div class="flex space-x-2">
            <a href="features.html"
            class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2"
            >Features</a>
            <a href="project.html"
            class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2"
            >About the Project</a>
            <a href="contact.html"
            class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2"
            >Contact</a>
          </div>
        </div>
        </div>
        <div class="flex items-center justify-end md:ml-auto">
        <a href="home.html"
          class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2">
          <img class="h-6 w-auto" src="..\assets\home.svg" alt="Home" />
        </a>
        </div>
      </div>
    </div>
    </nav>
  </template>

<!-- braucht man nicht mehr, übernimmt TailwindCss oben -->
<style scoped>
</style>
  