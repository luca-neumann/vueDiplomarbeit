<script>
import { reactive, toRefs, onMounted } from 'vue';
import useVuelidate from '@vuelidate/core';
import { required, email, minLength } from '@vuelidate/validators';
import axios from 'axios';

export default {
  name: 'Settings',
  setup() {
    const state = reactive({
      user: {
        Vorname: '',
        Nachname: '',
        Brokername: '',
        Email: '',
        Passwort: '',
      },
      updateUser: {
        Vorname: '',
        Nachname: '',
        Brokername: '',
        Email: '',
        Passwort: '',
      }
    });

    const rules = {
      updateUser: {
        Vorname: { minLength: minLength(3) },
        Nachname: { minLength: minLength(3) },
        Brokername: { minLength: minLength(7) },
        Email: { email },
        Passwort: { required, minLength: minLength(6) },
      }
    };

    const v$ = useVuelidate(rules, state);

    const fetchUserData = async () => {
      const userId = localStorage.getItem('userid');
      const response = await axios.get(`https://os-beyond.at/htl/smart_sensor_netz/user/${userId}`, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      });
      console.log(response.data.user); 
      state.user = response.data.user;
      state.updateUser = { ...response.data.user };
    };

    const updateSettings = async () => {
      v$.value.$validate();
      if (v$.value.$error) {
        return;
      }
      const userId = localStorage.getItem('userid');
      const response = await axios.post(`https://os-beyond.at/htl/smart_sensor_netz/user/${userId}`, state.updateUser, {
        headers: {
          Authorization: 'Bearer ' + localStorage.getItem('token')
        }
      });
      console.log("User updated successfully");
      console.log(response.data);
    // Aktualisierte Benutzerdaten anzeigen
    if (response.data.user) {
        state.user = response.data.user;
        state.updateUser = { ...response.data.user };
      }
    };

    onMounted(fetchUserData);

    return {
      ...toRefs(state),
      v$,
      updateSettings
    };
  }
};
</script>

<!-- geht immer noch nicht-->
<!-- damit der :placeholder="user.Name" im Inputfeld richtig angezeigt wird muss der Anfangsbuchstabe Großgeschrieben werden -> keine Ahnung warum -->

<template>
  <div class="flex justify-center items-center mt-10">
    <div class="w-1/3">
      <h2 class="text-2xl font-bold mb-4">Settings</h2>
      <form @submit.prevent="updateSettings">
        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Vorname.$error }">
          <label for="Vorname" class="block mb-2">First Name</label>
          <input type="text" id="Vorname" class="w-full px-4 py-2 border border-green-500 rounded" :placeholder="user.Vorname" v-model="updateUser.Vorname" @blur="v$.updateUser.Vorname.$touch()" />
          <span v-if="v$.updateUser.Vorname.$error">First name is required and must be at least 3 characters long</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Nachname.$error }">
          <label for="Nachname" class="block mb-2">Last Name</label>
          <input type="text" id="Nachname" class="w-full px-4 py-2 border border-green-500 rounded" :placeholder="user.Nachname" v-model="updateUser.Nachname" @blur="v$.updateUser.Nachname.$touch()" />
          <span v-if="v$.updateUser.Nachname.$error">Last name is required and must be at least 3 characters long</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Brokername.$error }">
          <label for="Brokername" class="block mb-2">Brokername</label>
          <input type="text" id="Brokername" class="w-full px-4 py-2 border border-green-500 rounded" :placeholder="user.Brokername" v-model="updateUser.Brokername" @blur="v$.updateUser.Brokername.$touch()" />
          <span v-if="v$.updateUser.Brokername.$error">Brokername is too short</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Email.$error }">
          <label for="Email" class="block mb-2">Email</label>
          <input type="email" id="Email" class="w-full px-4 py-2 border border-green-500 rounded" :placeholder="user.Email" v-model="updateUser.Email" @blur="v$.updateUser.Email.$touch()" />
          <span v-if="v$.updateUser.Email.$error">Email is incorrect</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Passwort.$error }">
          <label for="Passwort" class="block mb-2">Passwort</label>
          <input type="password" id="Passwort" class="w-full px-4 py-2 border border-green-500 rounded" :placeholder="user.Passwort" v-model="updateUser.Passwort" @blur="v$.updateUser.Passwort.$touch()" />
          <span v-if="v$.updateUser.Passwort.$error">Passwort is required</span>
        </div>
        <button type="submit" class="w-full bg-green-700 text-white py-2 px-4 rounded hover:bg-green-800">Save</button>
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