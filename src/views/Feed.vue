<script setup>
import TabeleData from '../components/TableData.vue'
</script>

<!-- Ansicht wenn der Benutzer sich angemeldet hat -->
<template>
  <TabeleData :data="$data" />
</template>