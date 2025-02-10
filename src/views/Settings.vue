<script>
import { reactive, toRefs, onMounted, ref } from 'vue';
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

    const updateSuccess = ref(false); // Erfolgsnachricht steuern

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

    // Benutzerdaten abrufen und in "user" speichern
    const fetchUserData = async () => {
      try {
        const userId = localStorage.getItem('userid');
        const response = await axios.get(`https://os-beyond.at/htl/smart_sensor_netz/user/${userId}`, {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        });

        console.log("User data fetched:", response.data);
        state.user = response.data || {};
      } catch (error) {
        console.error("Error fetching user data:", error);
      }
    };

    // Benutzereinstellungen aktualisieren
    const updateSettings = async () => {
      v$.value.$validate();
      if (v$.value.$error) {
        return;
      }

      try {
        const userId = localStorage.getItem('userid');
        const response = await axios.post(`https://os-beyond.at/htl/smart_sensor_netz/user/${userId}`, state.updateUser, {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        });

        console.log("User updated successfully:", response.data);

        // Daten nur aktualisieren, wenn die API erfolgreich war
        if (response.data) {
          state.user = { ...state.updateUser }; // Speichert die neuen Werte in user
          updateSuccess.value = true; // Erfolgsmeldung aktivieren
          setTimeout(() => updateSuccess.value = false, 3000); // Nach 3 Sekunden ausblenden
        }
      } catch (error) {
        console.error("Error updating user:", error);
      }
    };

    onMounted(() => {
      fetchUserData();
    });

    return {
      ...toRefs(state),
      v$,
      updateSuccess,
      updateSettings
    };
  }
};
</script>

<template>
  <div class="flex justify-center items-center mt-10">
    <div class="w-1/3">
      <h2 class="text-2xl font-bold mb-4">Settings</h2>

      <!-- Erfolgsnachricht -->
      <p v-if="updateSuccess" class="text-green-600 font-bold mb-4">Settings updated successfully!</p>

      <form @submit.prevent="updateSettings">
        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Vorname.$error }">
          <label for="Vorname" class="block mb-2">First Name</label>
          <input 
            type="text" 
            id="Vorname" 
            class="w-full px-4 py-2 border border-green-500 rounded" 
            :placeholder="user.Vorname || 'Enter your first name'" 
            v-model="updateUser.Vorname" 
            @blur="v$.updateUser.Vorname.$touch()" 
          />
          <span v-if="v$.updateUser.Vorname.$error">First name must be at least 3 characters long</span>
        </div>

        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Nachname.$error }">
          <label for="Nachname" class="block mb-2">Last Name</label>
          <input 
            type="text" 
            id="Nachname" 
            class="w-full px-4 py-2 border border-green-500 rounded" 
            :placeholder="user.Nachname || 'Enter your last name'" 
            v-model="updateUser.Nachname" 
            @blur="v$.updateUser.Nachname.$touch()" 
          />
          <span v-if="v$.updateUser.Nachname.$error">Last name must be at least 3 characters long</span>
        </div>

        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Brokername.$error }">
          <label for="Brokername" class="block mb-2">Brokername</label>
          <input 
            type="text" 
            id="Brokername" 
            class="w-full px-4 py-2 border border-green-500 rounded" 
            :placeholder="user.Brokername || 'Enter your broker name'" 
            v-model="updateUser.Brokername" 
            @blur="v$.updateUser.Brokername.$touch()" 
          />
          <span v-if="v$.updateUser.Brokername.$error">Brokername must be at least 7 characters long</span>
        </div>

        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Email.$error }">
          <label for="Email" class="block mb-2">Email</label>
          <input 
            type="email" 
            id="Email" 
            class="w-full px-4 py-2 border border-green-500 rounded" 
            :placeholder="user.Email || 'Enter your email'" 
            v-model="updateUser.Email" 
            @blur="v$.updateUser.Email.$touch()" 
          />
          <span v-if="v$.updateUser.Email.$error">Enter a valid email</span>
        </div>

        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Passwort.$error }">
          <label for="Passwort" class="block mb-2">Passwort</label>
          <input 
            type="password" 
            id="Passwort" 
            class="w-full px-4 py-2 border border-green-500 rounded" 
            v-model="updateUser.Passwort" 
            @blur="v$.updateUser.Passwort.$touch()" 
          />
          <span v-if="v$.updateUser.Passwort.$error">Passwort must be at least 6 characters long</span>
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
