<script>
import { reactive, toRefs } from 'vue';
import useVuelidate from '@vuelidate/core';
import { required, email, minLength } from '@vuelidate/validators';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
  name: 'Registration',
  setup() {
    const state = reactive({
      newRegistration: {
        Vorname: '',
        Nachname: '',
        Email: '',
        Passwort: '',
        Brokername: '',
      }
    });

    const rules = {
      newRegistration: {
        Vorname: { required, minLength: minLength(3) },
        Nachname: { required, minLength: minLength(3) },
        Email: { required, email },
        Passwort: { required, minLength: minLength(6) },
        Brokername: { required, minLength: minLength(7) },
      }
    };

    const v$ = useVuelidate(rules, state);
    const router = useRouter();

    const addNewRegistrationToDd = async () => {
      if (v$.$invalid) {
        console.log('Validation failed');
        return;
      }

      try {
        const response = await axios.post('https://os-beyond.at/htl/smart_sensor_netz/register', JSON.stringify(state.newRegistration), {
          headers: {
            'Content-Type': 'application/json'
          }
        });
        console.log(response.data);
        if (response.data.error) {
          console.error(response.data.message);
        } else {
          console.log('User added successfully');
          // v$.$reset(); -> geht nicht deswegen manuell:
          state.newRegistration.Vorname = '';
          state.newRegistration.Nachname = '';
          state.newRegistration.Email = '';
          state.newRegistration.Passwort = '';
          state.newRegistration.Brokername = '';
          router.push('/login');
        }
      } catch (error) {
        console.error('An error occurred:', error);
      }
    };

    return {
      ...toRefs(state),
      v$,
      addNewRegistrationToDd
    };
  }
};
</script>

<template>
  <div class="flex justify-center items-center mt-10">
    <div class="w-1/3">
      <h2 class="text-2xl font-bold mb-4">Registration</h2>
      <form @submit.prevent="addNewRegistrationToDd">
        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.Vorname.$error }">
          <label for="Vorname" class="block mb-2">First Name</label>
          <input type="text" id="Vorname" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.Vorname" @blur="v$.newRegistration.Vorname.$touch()" />
          <span v-if="v$.newRegistration.Vorname.$error">First name is required and must be at least 3 characters long</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.Nachname.$error }">
          <label for="Nachname" class="block mb-2">Last Name</label>
          <input type="text" id="Nachname" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.Nachname" @blur="v$.newRegistration.Nachname.$touch()" />
          <span v-if="v$.newRegistration.Nachname.$error">Last name is required and must be at least 3 characters long</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.Brokername.$error }">
          <label for="Brokername" class="block mb-2">Brokername</label>
          <input type="text" id="Brokername" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.Brokername" @blur="v$.newRegistration.Brokername.$touch()" />
          <span v-if="v$.newRegistration.Brokername.$error">Brokername is required and must be at least 7 characters long</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.Email.$error }">
          <label for="email" class="block mb-2">Email</label>
          <input type="email" id="email" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.Email" @blur="v$.newRegistration.Email.$touch()" />
          <span v-if="v$.newRegistration.Email.$error">A valid Email is required</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.Passwort.$error }">
          <label for="Passwort" class="block mb-2">Passwort</label>
          <input type="Password" id="Passwort" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.Passwort" @blur="v$.newRegistration.Passwort.$touch()" />
          <span v-if="v$.newRegistration.Passwort.$error">Password is required and must be at least 6 characters long</span>
        </div>
        <button type="submit" class="w-full bg-green-700 text-white py-2 px-4 rounded hover:bg-green-800">Register</button>
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