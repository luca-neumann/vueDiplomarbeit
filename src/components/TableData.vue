<script>
import axios from 'axios';
import { ref, onMounted, computed } from 'vue';
import Plotly from 'plotly.js-dist';

export default {
  name: 'TableData',
  setup() {
    const sensorData = ref([]);
    const sortColumn = ref(null);
    const sortDirection = ref(1);
    const currentPage = ref(1);
    const itemsPerPage = 10;

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

    const paginatedData = computed(() => {
      if (sensorData.value.length === 0) return [];
      const startIndex = (currentPage.value - 1) * itemsPerPage;
      const endIndex = currentPage.value * itemsPerPage;
      return sensorData.value.slice(startIndex, endIndex);
    });

    const totalPages = computed(() => {
      return Math.ceil(sensorData.value.length / itemsPerPage);
    });

    const goToPage = (pageNumber) => {
      if (pageNumber >= 1 && pageNumber <= totalPages.value) {
        currentPage.value = pageNumber;
      }
    };

    // Berechnung der Veränderung der PM-Werte in den letzten 30 Tagen
    const calculatePMChange = computed(() => {
      const thirtyDaysAgo = new Date();
      thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);

      // Filtere die Daten der letzten 30 Tage
      const recentData = sensorData.value.filter(entry => {
        const timestamp = new Date(entry.Zeitstempel);
        return timestamp >= thirtyDaysAgo;
      });

      if (recentData.length === 0) {
        return {
          PM1: 0,
          PM25: 0,
          PM10: 0,
          message: 'Keine Daten der letzten 30 Tage verfügbar.'
        };
      }

      // Berechnung der durchschnittlichen PM-Werte zu Beginn und Ende des 30-Tage-Zeitraums
      const startData = recentData[0]; // Erstes Element (vor 30 Tagen)
      const endData = recentData[recentData.length - 1]; // Letztes Element (heute)

      const changePM1 = endData.PM1 - startData.PM1;
      const changePM25 = endData.PM25 - startData.PM25;
      const changePM10 = endData.PM10 - startData.PM10;

      return {
        PM1: changePM1,
        PM25: changePM25,
        PM10: changePM10,
        message: 'Veränderung der PM-Werte in den letzten 30 Tagen'
      };
    });

    // Plotly
    const renderPlot = () => {
      if (sensorData.value.length === 0) return;

      const thirtyDaysAgo = new Date();
      thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);

      const recentData = sensorData.value.filter(entry => new Date(entry.Zeitstempel) >= thirtyDaysAgo);
      if (recentData.length === 0) return;

      const dates = recentData.map(entry => new Date(entry.Zeitstempel));
      const pm1Values = recentData.map(entry => entry.PM1);
      const pm25Values = recentData.map(entry => entry.PM25);
      const pm10Values = recentData.map(entry => entry.PM10);

      const data = [
        { x: dates, y: pm1Values, type: 'scatter', mode: 'lines', name: 'PM1', line: { color: 'red' } },
        { x: dates, y: pm25Values, type: 'scatter', mode: 'lines', name: 'PM2.5', line: { color: 'blue' } },
        { x: dates, y: pm10Values, type: 'scatter', mode: 'lines', name: 'PM10', line: { color: 'green' } }
      ];

      const layout = {
        title: {
          text: 'Feinstaubwerte der letzten 30 Tage',
          font: {
            size: 20,
            color: 'black'
          },
          x: 0.5,
          xanchor: 'center',
          y: 0.95,
          yanchor: 'top'
        },
        xaxis: { title: 'Datum', type: 'date' },
        yaxis: { title: 'PM-Wert (µg/m³)' },
        plot_bgcolor: "#f5f5f5",
        paper_bgcolor: "#f5f5f5",
        font: { color: "Black" }
      };

      Plotly.newPlot('plotly-chart', data, layout);
    };


    onMounted(async () => {
      await fetchSensorData();
      renderPlot();
    });

    return {
      sensorData,
      formatTime,
      formatDate,
      sortTable,
      sortColumn,
      sortDirection,
      getSortIndicator,
      paginatedData,
      currentPage,
      totalPages,
      goToPage,
      calculatePMChange
    };
  }
};
</script>

<template>
  <div class="flex justify-center mt-3">
    <div class="w-4/5 bg-green-700 rounded-lg">
      <table class="w-full border-collapse">
        <thead>
          <tr>
            <th @click="sortTable('ClientID')" class="border border-green-600 p-2 text-center text-white rounded-lg cursor-pointer">
              Client {{ getSortIndicator('ClientID') }}
            </th>
            <th @click="sortTable('PM1')" class="border border-green-600 p-2 text-center text-white rounded-lg cursor-pointer">
              Pm1 {{ getSortIndicator('PM1') }}
            </th>
            <th @click="sortTable('PM25')" class="border border-green-600 p-2 text-center text-white rounded-lg cursor-pointer">
              Pm2.5 {{ getSortIndicator('PM25') }}
            </th>
            <th @click="sortTable('PM10')" class="border border-green-600 p-2 text-center text-white rounded-lg cursor-pointer">
              Pm10 {{ getSortIndicator('PM10') }}
            </th>
            <th @click="sortTable('Zeitstempel')" class="border border-green-600 p-2 text-center text-white rounded-lg cursor-pointer">
              Zeitpunkt {{ getSortIndicator('Zeitstempel') }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-if="paginatedData.length === 0">
            <td colspan="5" class="border border-green-600 p-2 text-center text-white rounded-lg">
              Keine Daten verfügbar 😟
            </td>
          </tr>
          <tr v-else v-for="data in paginatedData" :key="data.WertID">
            <td class="border border-green-600 p-2 text-center text-white rounded-lg">{{ data.ClientID }}</td>
            <td class="border border-green-600 p-2 text-center text-white rounded-lg">{{ data.PM1 }}</td>
            <td class="border border-green-600 p-2 text-center text-white rounded-lg">{{ data.PM25 }}</td>
            <td class="border border-green-600 p-2 text-center text-white rounded-lg">{{ data.PM10 }}</td>
            <td class="border border-green-600 p-2 text-center text-white rounded-lg">{{ formatTime(data.Zeitstempel) }} - {{ formatDate(data.Zeitstempel) }}</td>
          </tr>
        </tbody>
      </table>
      <div class="flex justify-between mt-4">
        <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1" class="bg-green-600 text-white pt-2 pb-2 pr-4 pl-4 rounded-lg ml-2 mb-2">⬅️</button>
        <span class="text-white">
          Seite {{ currentPage }} von {{ totalPages }}
        </span>
        <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages" class="bg-green-600 text-white pt-2 pb-2 pr-4 pl-4 rounded-lg mr-2 mb-2">➡️</button>
      </div>
    </div>
  </div>
  <!-- hier Plotly -->
  <div v-if="sensorData.length > 0" class="flex justify-center">
    <div class="mt-6 text-white bg-green-600 p-4 rounded-lg w-4/5">
      <div id="plotly-chart"></div>
    </div>
  </div>
  <!-- Veränderung der PM-Werte -->
   <div class="flex justify-center">
    <div class="mt-6 text-white bg-green-600 p-4 rounded-lg w-4/5">
        <h3 class="font-bold">{{ calculatePMChange.message }}</h3>
        <p>PM1 Veränderung: {{ calculatePMChange.PM1.toFixed(2) }} µg/m³</p>
        <p>PM2.5 Veränderung: {{ calculatePMChange.PM25.toFixed(2) }} µg/m³</p>
        <p>PM10 Veränderung: {{ calculatePMChange.PM10.toFixed(2) }} µg/m³</p>
      </div>
   </div>
</template>
