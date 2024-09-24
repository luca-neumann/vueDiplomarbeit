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
    const response = await axios.get(`http://localhost/php/vuediplomarbeit/src/api/user.php?action=getUser&UserID=${userId}`, {
      headers: {
        Authorization: 'Bearer ' + localStorage.getItem('token')
      }
    });

    this.user = response.data.user;
  }
}
</script>

<!-- Ansicht wenn der Benutzer sich angemeldet hat -->
<template>
  <h1 class="text-4xl font-bold text-center mt-10">Feed</h1>
  <h3 class="text-3xl font-bold text-center mt-3" v-if="user">Willkommen, {{ user.Firstname }}</h3>
  <h3 class="text-3xl font-bold text-center mt-3" v-if="!user">Willkommen</h3>
  <TableData/>
</template>