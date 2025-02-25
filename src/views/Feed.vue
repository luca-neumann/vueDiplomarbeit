<script>
import TableData from '../components/TableData.vue'
import axios from 'axios';

export default {
  name: 'Feed',
  data() {
    return {
      user: null
    }
  },
  components: {
    TableData
  },
  async created() {
    const userId = localStorage.getItem('userid');
    const response = await axios.get(`https://os-beyond.at/htl/smart_sensor_netz/user/${userId}`, {
      headers: {
        Authorization: 'Bearer ' + localStorage.getItem('token')
      }
    });

    this.user = response.data;
  }
}
</script>

<!-- Ansicht wenn der Benutzer sich angemeldet hat -->
<template>
  <h1 class="text-4xl font-bold text-center mt-10" v-if="user">Willkommen, {{ user.Vorname }} 👋</h1>
  <h1 class="text-4xl font-bold text-center mt-10" v-if="!user">Willkommen 👋</h1>
  <h3 class="text-3xl font-bold text-center mt-3 ">Meine Feinstaubdaten</h3>
  <TableData/>
</template>