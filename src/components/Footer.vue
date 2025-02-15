<script>
import { ref, onMounted } from 'vue';
import { useRouter, RouterLink } from 'vue-router';
import logo from '@/assets/logo.svg';

export default {
  name: 'Footer',
  setup() {
    const isLoggedIn = ref(false);
    const router = useRouter();

    const checkLoginStatus = () => {
      isLoggedIn.value = !!localStorage.getItem('token');
    };

    onMounted(() => {
      checkLoginStatus();
    });

    return {
      isLoggedIn,
      checkLoginStatus
    };
  }
};
</script>

<template>
  <footer class="bg-green-700 border-t border-green-500 mt-7 lg:mb-7 mr-7 ml-7 md:mb-7 sm:mb-0 rounded-lg">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8 py-4">
      <div class="flex flex-col md:flex-row items-center justify-between">
        <div class="flex items-center justify-start mb-4 md:mb-0">
          <RouterLink class="flex flex-shrink-0 items-center mr-4" to="/">
            <img class="h-10 w-auto" src="..\assets\logo.svg" alt="Logo" />
          </RouterLink>
          <span class="text-white text-sm">&copy; 2025 Smart Sensor Netz. All rights reserved.</span>
        </div>
        <div class="flex items-center justify-center space-x-4">
          <RouterLink to="/privacy-policy" class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2">Datenschutzerklärung</RouterLink>
          <RouterLink to="/imprint" class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2">Impressum</RouterLink>
          <RouterLink to="/contact" class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2">Kontakt</RouterLink>
        </div>
      </div>
    </div>
  </footer>
</template>

<style scoped>
</style>