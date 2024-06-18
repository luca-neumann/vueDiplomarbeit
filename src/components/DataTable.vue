<template>
  <div>
    <h1>Data Table</h1>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Wert</th>
          <th>Time</th>
          <th>Client</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in data" :key="index">
          <td>{{ row.ID }}</td>
          <td>{{ row.Wert }}</td>
          <td>{{ row.Time }}</td>
          <td>{{ row.Client }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      data: [],
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    async fetchData() {
      try {
        const response = await axios.get('http://localhost:3000/api/data'); // Ändern Sie die URL auf den richtigen Port
        this.data = response.data;
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    }
  }
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
}
th, td {
  border: 1px solid #ddd;
  padding: 8px;
}
th {
  background-color: #f2f2f2;
}
</style>
