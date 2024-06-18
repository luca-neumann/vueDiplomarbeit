<template>
  <div id="app">
    <DataTable />
  </div>
</template>

<script>
import DataTable from './components/DataTable.vue';

export default {
  name: 'App',
  components: {
    DataTable
  }
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
