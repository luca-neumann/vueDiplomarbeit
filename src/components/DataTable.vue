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
        <tr v-for="(row, index) in sortedData" :key="index">
          <td>{{ row.ID }}</td>
          <td>{{ row.Wert }}</td>
          <td style="white-space: nowrap;">{{ formatDateTime(row.Time) }}</td>
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
    },
    formatDateTime(dateTimeString) {
      const date = new Date(dateTimeString);

      // Optionen für die Locale-String Methode
      const options = {
        timeZone: 'Europe/Berlin',
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false,
      };

      // Formatierte Datum-Zeit-String
      const formattedDate = date.toLocaleString('de-DE', options);

      // Datum und Zeit trennen
      const [datePart, timePart] = formattedDate.split(', ');

      return `${datePart} ${timePart.slice(0, 5)}`;
    }
  },
  computed: {
    sortedData() {
      return this.data.slice().sort((a, b) => new Date(b.Time) - new Date(a.Time));
    }
  }
};
</script>

<style>
.date-time {
  white-space: nowrap;
}
</style>


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
