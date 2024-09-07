<script>
import useVuelidate from '@vuelidate/core';
import { required, email, minLength } from '@vuelidate/validators';
import axios from 'axios';
export default {
  name: 'Registration',
  data() {
    return {
      v$: useVuelidate(),
      newRegistration: {
        name: '',
        brokername: '',
        email: '',
        password: '',
      },
    }
  },
  validations() {
    return {
      newRegistration: {
        name: { required, minLength: minLength(3) },
        brokername: { required, minLength: minLength(7) },
        email: { required, email },
        password: { required, minLength: minLength(6) },
      },
    }
  },
  methods: {
    addNewRegistration() {
      this.v$.$validate(); 
      if(!this.v$.$error) {
        console.log('Registration successful');
        this.$router.push('/login');
      } else {
        console.log('Registration failed');
      }
    },
    // Datenbank
    async addNewRegistrationToDd() {
      try {
        this.v$.$validate();
        if (!this.v$.$error) {
          const formData = new FormData();
          for (const key in this.newRegistration) {
            formData.append(key, this.newRegistration[key]);
          }
          await axios.post('http://localhost/php/vuediplomarbeit/src/api/user.php?action=registration', formData);
          this.newRegistration = {
            name: '',
            brokername: '',
            email: '',
            password: '',
          };
          this.v$.$reset();
        } else {
          console.log('Invalid input fields');
        }
      } catch (error) {
        console.error(error);
      }
    }
  }
};
</script>

<!-- Registration Fenster -->
<template>
  <div class="flex justify-center items-center mt-10">
    <div class="w-1/3">
      <h2 class="text-2xl font-bold mb-4">Registration</h2>
      <form>
        <div class="mb-4" :class="{ ' form-group-error': v$.newRegistration.name.$error}">
          <label for="name" class="block mb-2">Name</label>
            <input type="name" id="name" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.name" @blur="v$.newRegistration.name.$touch()"/>
          <span v-if="v$.newRegistration.name.$error">Name is required</span>
        </div>
        <div class="mb-4" :class="{ ' form-group-error': v$.newRegistration.brokername.$error}">
          <label for="brokername" class="block mb-2">Brokername</label>
          <input type="brokername" id="brokername" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.brokername" @blur="v$.newRegistration.brokername.$touch()"/>
          <span v-if="v$.newRegistration.brokername.$error">Brokername is required</span>
        </div>
        <div class="mb-4" :class="{ ' form-group-error': v$.newRegistration.email.$error}">
          <label for="email" class="block mb-2">Email</label>
          <input type="email" id="email" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.email" @blur="v$.newRegistration.email.$touch()"/>
          <span v-if="v$.newRegistration.email.$error">Email is required or incorrect</span>
        </div>
        <div class="mb-4" :class="{ ' form-group-error': v$.newRegistration.password.$error}">
          <label for="password" class="block mb-2">Password</label>
          <input type="password" id="password" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.password" @blur="v$.newRegistration.password.$touch()"/>
          <span v-if="v$.newRegistration.password.$error">Password is required or too short</span>
        </div>
        <button type="button" class="w-full bg-green-700 text-white py-2 px-4 rounded hover:bg-green-800" @click="addNewRegistration(), addNewRegistrationToDd()">Register</button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.form-group-error {
  color: red;
}
.form-group-error input {
  border-color: red;
}
</style>