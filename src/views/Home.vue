<script setup>
import { RouterLink } from 'vue-router';
</script>

<!-- standard Sicht mit Infos zum Projekt sowie vielleicht Karte -->
<template>
  <h1 class="text-4xl font-bold text-center mt-10">Willkommen auf SmartSensorNetz</h1>
  <RouterLink to="/login" class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2">Login</RouterLink>
  <RouterLink to="/registration" class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2">Registration</RouterLink>
</template>