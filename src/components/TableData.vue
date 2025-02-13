<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';

export default {
  name: 'TableData',
  setup() {
    const sensorData = ref([]);
    const sortColumn = ref(null);
    const sortDirection = ref(1);

    const fetchSensorData = async () => {
      try {
        const userId = localStorage.getItem('userid');
        const response = await axios.get(`https://os-beyond.at/htl/smart_sensor_netz/feinstaubwerte/client/${userId}`);
        console.log("API Response:", response.data);
        sensorData.value = response.data.map(entry => ({
          WertID: entry.WertID,
          PM1: entry["PM1.0"],
          PM25: entry["PM2.5"],
          PM10: entry.PM10,
          Zeitstempel: entry.Zeitstempel,
          ClientID: entry.ClientID
        }));
      } catch (error) {
        console.error('An error occurred while fetching sensor data:', error);
      }
    };

    const formatTime = (timestamp) => {
      const date = new Date(timestamp);
      return date.toLocaleTimeString();
    };

    const formatDate = (timestamp) => {
      const date = new Date(timestamp);
      return date.toLocaleDateString('de-DE', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
      });
    };

    const sortTable = (column) => {
      if (sortColumn.value === column) {
        sortDirection.value *= -1;
      } else {
        sortColumn.value = column;
        sortDirection.value = 1;
      }

      sensorData.value.sort((a, b) => {
        let valA = a[column];
        let valB = b[column];

        if (!isNaN(valA) && !isNaN(valB)) {
          return (valA - valB) * sortDirection.value;
        }

        return valA.toString().localeCompare(valB.toString(), 'de', { numeric: true }) * sortDirection.value;
      });
    };

    const getSortIndicator = (column) => {
      if (sortColumn.value === column) {
        return sortDirection.value === 1 ? '⬇️' : '⬆️';
      }
      return '';
    };

    onMounted(() => {
      fetchSensorData();
    });

    return {
      sensorData,
      formatTime,
      formatDate,
      sortTable,
      sortColumn,
      sortDirection,
      getSortIndicator
    };
  }
};
</script>

<template>
  <div class="flex justify-center mt-10">
    <div class="w-4/5 bg-green-700 rounded-lg">
      <table class="w-full border-collapse">
        <thead>
          <tr>
            <th @click="sortTable('ClientID')" class="border border-green-600 p-2 text-center text-gray-800 rounded-lg cursor-pointer">
              Client {{ getSortIndicator('ClientID') }}
            </th>
            <th @click="sortTable('PM1')" class="border border-green-600 p-2 text-center text-gray-800 rounded-lg cursor-pointer">
              Pm1 {{ getSortIndicator('PM1') }}
            </th>
            <th @click="sortTable('PM25')" class="border border-green-600 p-2 text-center text-gray-800 rounded-lg cursor-pointer">
              Pm2.5 {{ getSortIndicator('PM25') }}
            </th>
            <th @click="sortTable('PM10')" class="border border-green-600 p-2 text-center text-gray-800 rounded-lg cursor-pointer">
              Pm10 {{ getSortIndicator('PM10') }}
            </th>
            <th @click="sortTable('Zeitstempel')" class="border border-green-600 p-2 text-center text-gray-800 rounded-lg cursor-pointer">
              Zeitpunkt {{ getSortIndicator('Zeitstempel') }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="sensorData.length === 0">
            <td colspan="5" class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">
              Keine Daten verfügbar.
            </td>
          </tr>
          <tr v-else v-for="data in sensorData" :key="data.WertID">
            <td class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">{{ data.ClientID }}</td>
            <td class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">{{ data.PM1 }}</td>
            <td class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">{{ data.PM25 }}</td>
            <td class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">{{ data.PM10 }}</td>
            <td class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">{{ formatTime(data.Zeitstempel) }} - {{ formatDate(data.Zeitstempel) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>