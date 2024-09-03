<script setup>
import Navbar from './components/Navbar.vue'
import TabeleData from './components/TableData.vue'
</script>

<template>
  <header>
    <Navbar/>
  </header>
    <main>
    <TabeleData :data="$data" />
  </main>
</template>

<style scoped>
.template {
  background-color: #181818;
}
</style>
