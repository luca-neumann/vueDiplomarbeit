<script>
import useVuelidate from '@vuelidate/core';
import { required, email, minLength } from '@vuelidate/validators';
import axios from 'axios';

export default {
  name: 'Settings',
  data() {
    return {
      v$: useVuelidate(),
      user: {
        name: '',
        brokername: '',
        email: '',
        password: '',
      },
      updateUser: {
        name: '',
        brokername: '',
        email: '',
        password: '',
      },
    };
  },
  validations() {
    return {
      user: {
        name: { required, minLength: minLength(3) },
        brokername: { required, minLength: minLength(7) },
        email: { required, email },
        password: { required, minLength: minLength(6) },
      },
    };
  },
  async created() {
    const userId = localStorage.getItem('userid');
    const response = await axios.get(`http://localhost/php/vuediplomarbeit/src/api/user.php?action=getUser&UserID=${userId}`, {
      headers: {
        Authorization: 'Bearer ' + localStorage.getItem('token')
      }
    });
    console.log(response.data.user); 
    this.user = response.data.user;
    this.updateUser = { ...this.user };
  },
  methods: {
    async updateSettings() {
//      this.v$.$validate();
//      if (this.v$.$error) {
//        return;
//      }
      const userId = localStorage.getItem('userid');
      const response = await axios.post(`http://localhost/php/vuediplomarbeit/src/api/user.php?action=updateUser&UserID=${userId}`, this.updateUser, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      });
      console.log(response.data);
    },
  },
};
</script>

<!-- Funktioniert noch nicht -->
 
<template>
  <div class="flex justify-center items-center mt-10">
    <div class="w-1/3">
      <h2 class="text-2xl font-bold mb-4">Settings</h2>
      <form @submit.prevent="updateSettings">
        <div class="mb-4">
          <h3 class="text-3xl font-bold text-center mt-3" v-if="user">Willkommen, {{ user.Name }}</h3>
          <label for="name" class="block mb-2">Name: {{ user.name }}</label>
          <input type="text" id="name" class="w-full px-4 py-2 border border-green-500 rounded" :placeholder="user.name" v-model="updateUser.name" />
        </div>
        <div class="mb-4">
          <label for="brokername" class="block mb-2">Brokername: {{ user.brokername }}</label>
          <input type="text" id="brokername" class="w-full px-4 py-2 border border-green-500 rounded" v-model="updateUser.brokername" />
        </div>
        <div class="mb-4">
          <label for="email" class="block mb-2">Email: {{ user.email }}</label>
          <input type="email" id="email" class="w-full px-4 py-2 border border-green-500 rounded" v-model="updateUser.email" />
        </div>
        <div class="mb-4">
          <label for="password" class="block mb-2">Password: {{ user.password }}</label>
          <input type="password" id="password" class="w-full px-4 py-2 border border-green-500 rounded" v-model="updateUser.password" />
        </div>
        <button type="submit" class="w-full bg-green-700 text-white py-2 px-4 rounded hover:bg-green-800" @onclick="updateSettings()">Save</button>
      </form>
    </div>
  </div>
</template>

