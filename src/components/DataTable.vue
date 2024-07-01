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
          <td>{{ row.id }}</td>
          <td>{{ row.wert }}</td>
          <td>{{ row.time }}</td>
          <td>{{ row.client }}</td>
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
        headers: []
      };
    },
    created() {
      this.fetchData();
    },
    methods: {
      async fetchData() {
        try {
          const response = await axios.get('http://localhost:3306');
          this.data = response.data;
          if (this.data.length > 0) {
            this.headers = Object.keys(this.data[0]);
          }
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
  