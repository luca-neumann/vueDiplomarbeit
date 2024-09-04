<script setup>
import { RouterLink } from 'vue-router';
</script>

<!-- standard Sicht mit Infos zum Projekt sowie vielleicht Karte -->
<template>
  <h1 class="text-4xl font-bold text-center mt-10">Willkommen auf SmartSensorNetz</h1>
  <!-- hier muss die Karte noch fertig eingebunden werden mit, Messstationen, eventuell Wind -->
  <div class="flex justify-center mt-10">
    <iframe class="flex justify-center mt-10 border-green-500 border-b rounded-lg" 
      src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d150063.20106871874!2d11.405694877591014!3d47.236173106845975!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sde!2sat!4v1725460972084!5m2!1sde!2sat" 
      width="800"
      height="450"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade">
    </iframe>  </div>
</template>