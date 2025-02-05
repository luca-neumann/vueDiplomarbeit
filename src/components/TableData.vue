<script>
import axios from 'axios';
import { ref, onMounted } from 'vue';

export default {
  name: 'TableData',
  setup() {
    const sensorData = ref([]);

    const fetchSensorData = async () => {
      try {
        const userId = localStorage.getItem('userid');
        const response = await axios.get(`https://os-beyond.at/htl/smart_sensor_netz/feinstaubwerte/client/${userId}`);
        console.log(response.data);
        sensorData.value = response.data.sensordata; // Extrahieren der sensordata
      } catch (error) {
        console.error('An error occurred while fetching sensor data:', error);
      }
    };

    const formatTime = (timestamp) => {
      const date = new Date(timestamp);
      return date.toLocaleTimeString();
    };

    const formatDate = (dateString) => {
      const date = new Date(dateString);
      return date.toLocaleDateString('de-DE', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
      });
    };

    onMounted(() => {
      fetchSensorData();
    });

    return {
      sensorData,
      formatTime,
      formatDate
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
            <th class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">Client</th>
            <th class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">Pm1</th>
            <th class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">Pm2.5</th>
            <th class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">Pm10</th>
            <th class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">Zeitpunkt</th>
            <th class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">Datum</th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="sensorData.length === 0">
            <td colspan="6" class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">
              Keine Daten verfügbar oder Verbindung zur Datenbank fehlgeschlagen.
            </td>
          </tr>
          <tr v-else v-for="data in sensorData" :key="data.ValueID">
            <td class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">{{ data.ClientID }}</td>
            <td class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">{{ data['Pm1.0'] }}</td>
            <td class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">{{ data['Pm2.5'] }}</td>
            <td class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">{{ data.Pm10 }}</td>
            <td class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">{{ formatTime(data.Timestamp) }}</td>
            <td class="border border-green-600 p-2 text-center text-gray-800 rounded-lg">{{ formatDate(data.Date) }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>