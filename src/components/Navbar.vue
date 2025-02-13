<script>
import { ref, onMounted } from 'vue';
import { useRouter, RouterLink } from 'vue-router';
import logo from '@/assets/logo.svg';
import home from '@/assets/home.svg';

export default {
  name: 'Navbar',
  setup() {
    const showMenu = ref(false);
    const isLoggedIn = ref(false);
    const router = useRouter();

    const checkLoginStatus = () => {
      isLoggedIn.value = !!localStorage.getItem('token');
    };

    const logout = () => {
      localStorage.removeItem('token');
      localStorage.removeItem('userid');
      isLoggedIn.value = false;
      router.push('/login');
    };

    const isLogin = () => {
      isLoggedIn.value = true;
    };

    onMounted(() => {
      checkLoginStatus();
    });

    return {
      showMenu,
      isLoggedIn,
      logout,
      checkLoginStatus
    };
  }
};
</script>

<template>
<nav class="bg-green-700 border-b border-green-500 lg:mt-7 mr-7 ml-7 md:mt-7 sm:mt-0 rounded-lg">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="flex h-20 items-center justify-between">
        <div class="flex flex-1 items-center justify-start">
        <RouterLink class="flex flex-shrink-0 items-center mr-4" to="/">
          <img class="h-10 w-auto" src="..\assets\logo.svg" alt="Logo" />
          <!-- Weg? -->
          <!-- <span class="hidden md:block text-white text-2xl font-bold ml-2">Smart Sensor Netz</span> -->
        </RouterLink>
        
        <div class="flex flex-1 items-center justify-center">
          <div class="flex space-x-2">
            <RouterLink to="/features" class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2">Messung</RouterLink>
            <RouterLink to="/project" class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2">Über das Projekt</RouterLink>
            <RouterLink to="/contact" class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2">Kontakt</RouterLink>
          </div>
        </div>
        </div>
        <div class="flex items-center justify-end md:ml-auto" v-if="!isLoggedIn">
          <div class="flex space-x-2">
            <RouterLink to="/registration" class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2">Registrieren</RouterLink>
            <RouterLink to="/login" class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2" @click="isLogin">Anmelden</RouterLink>
          </div>
        </div>
        <div class="flex items-center justify-end md:ml-auto" v-if="isLoggedIn">
          <button class="text-white hover:bg-green-900 hover:text-white rounded-md px-3 py-2" @click="showMenu = !showMenu">
            <img class="h-6 w-auto" src="..\assets\home.svg" alt="Home" />
            <!-- 👤 -->
          </button>
          <div v-if="showMenu" class="absolute top-28 mt-2 bg-white border border-green-500 rounded-md shadow-lg">
            <RouterLink to="/feed" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Your Data 📊</RouterLink>
            <RouterLink to="/settings" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Settings ⚙️</RouterLink>
            <RouterLink v-if="isLoggedIn" to="/login" class="block px-4 py-2 text-gray-800 hover:bg-gray-200" @click="logout()">Sign Out 🔙</RouterLink>
            <!-- Wir eigentlich nicht mehr benötig, weil wenn der User nicht eingeloggt ist, sieht er diese div sowieso nicht -->
            <!-- <RouterLink v-else to="/login" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Sign In</RouterLink> -->
          </div>
        </div>
      </div>
    </div>
    </nav>
  </template>

<!-- braucht man nicht mehr, übernimmt TailwindCss oben -->
<style scoped>
</style>
  