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

    const updateSuccess = ref(false); // Erfolgsnachricht
    const updateAllowed = ref(false); // Checkbox-Status

    const rules = {
      updateUser: {
        Vorname: { minLength: minLength(3) },
        Nachname: { minLength: minLength(3) },
        Brokername: { minLength: minLength(7) },
        Email: { email },
        Passwort: { minLength: minLength(6) }
      }
    };

    const errorMessage = ref("");
    const setErrorMessage = (message) => {
        errorMessage.value = message;
        setTimeout(() => (errorMessage.value = ""), 5000);
    };


    const v$ = useVuelidate(rules, state);

    // Benutzerdaten abrufen und in user speichern
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
      if (!updateAllowed.value) {
          return; // Falls die Checkbox nicht angeklickt wurde, abbrechen
      }

      v$.value.$validate();
      if (v$.value.$error) {
          return;
      }

      try {
          const userId = localStorage.getItem('userid');

          // Nur Felder senden, die ausgefüllt wurden
          const updatedData = {
              Vorname: state.updateUser.Vorname || state.user.Vorname,
              Nachname: state.updateUser.Nachname || state.user.Nachname,
              Brokername: state.updateUser.Brokername || state.user.Brokername,
              Email: state.updateUser.Email || state.user.Email
          };

          // Nur wenn das Passwort nicht leer ist, zur API senden
          if (state.updateUser.Passwort) {
              updatedData.Passwort = state.updateUser.Passwort;
          }

          const response = await axios.put(
              `https://os-beyond.at/htl/smart_sensor_netz/user/${userId}`,
              updatedData,
              {
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }
          );

          console.log("User updated successfully:", response.data);

          if (response.data) {
              state.user = { ...updatedData };
              updateSuccess.value = true;
              setTimeout(() => (updateSuccess.value = false), 3000);
              updateAllowed.value = false; // Checkbox zurücksetzen
          }
      } catch (error) {
          console.error("Error updating user:", error);

          if (error.response) {
              console.log("Error Response:", error.response.data);

              if (error.response.status === 400 || error.response.status === 409) {
                  if (error.response.data.message === "E-Mail bereits registriert") {
                      setErrorMessage("❌ Diese E-Mail ist bereits vergeben!");
                  } else {
                      setErrorMessage(`⚠️ Fehler: ${error.response.data.message}`);
                  }
              } else {
                  setErrorMessage(`⚠️ Fehler: ${error.response.status} - Bitte versuche es später erneut.`);
              }
          } else {
              setErrorMessage("⚠️ Fehler beim Aktualisieren der Einstellungen. Bitte überprüfe deine Internetverbindung.");
          }
      }
  };

    // Account löschen
    const deleteAccount = async () => {
      const userId = localStorage.getItem('userid');

      if (!confirm("Bist du sicher, dass du deinen Account löschen möchtest? Diese Aktion kann nicht rückgängig gemacht werden!")) {
        return;
      }

      try {
        await axios.delete(`https://os-beyond.at/htl/smart_sensor_netz/user/${userId}`, {
          headers: {
            Authorization: 'Bearer ' + localStorage.getItem('token')
          }
        });

        console.log("Account erfolgreich gelöscht");

        localStorage.removeItem('userid');
        localStorage.removeItem('token');
        window.location.href = '/vueDiplomarbeit/'; // href und nicht router push, damit sich Navbar aktualisiert
      } catch (error) {
        console.error("Fehler beim Löschen des Accounts:", error);
      }
    };

    onMounted(() => {
      fetchUserData();
    });

    return {
      ...toRefs(state),
      v$,
      updateSuccess,
      updateAllowed,
      updateSettings,
      errorMessage,
      deleteAccount
    };
  }
};
</script>

<template>
  <div class="flex justify-center items-center mt-10">
    <div class="w-1/3">
      <h2 class="text-2xl font-bold mb-4">Settings</h2>

      <!-- Erfolgsnachricht -->
      <transition name="fade">
        <p v-if="updateSuccess" class="text-green-600 font-bold mb-4">Settings erfolgreich geupdated!</p>
      </transition>
      <!-- Fehlermeldung -->
      <transition name="fade">
        <p v-if="errorMessage" class="text-red-600 font-bold mb-4">{{ errorMessage }}</p>
      </transition>


      <form @submit.prevent="updateSettings">
        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Vorname.$error }">
          <label for="Vorname" class="block mb-2">Vorname</label>
          <input 
            type="text" 
            id="Vorname" 
            class="w-full px-4 py-2 border border-green-500 rounded" 
            :placeholder="user.Vorname || 'Gib deinen Vornamen ein'" 
            v-model="updateUser.Vorname" 
            @blur="v$.updateUser.Vorname.$touch()" 
          />
          <span v-if="v$.updateUser.Vorname.$error">Vorname muss mindestens 3 Zeichen lang sein</span>
        </div>

        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Nachname.$error }">
          <label for="Nachname" class="block mb-2">Nachname</label>
          <input 
            type="text" 
            id="Nachname" 
            class="w-full px-4 py-2 border border-green-500 rounded" 
            :placeholder="user.Nachname || 'Gib deinen Nachnamen ein'" 
            v-model="updateUser.Nachname" 
            @blur="v$.updateUser.Nachname.$touch()" 
          />
          <span v-if="v$.updateUser.Nachname.$error">Nachname muss mindestens 3 Zeichen lang sein</span>
        </div>

        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Brokername.$error }">
          <label for="Brokername" class="block mb-2">Brokername</label>
          <input 
            type="text" 
            id="Brokername" 
            class="w-full px-4 py-2 border border-green-500 rounded" 
            :placeholder="user.Brokername || 'Gib deinen Brokername ein'" 
            v-model="updateUser.Brokername" 
            @blur="v$.updateUser.Brokername.$touch()" 
          />
          <span v-if="v$.updateUser.Brokername.$error">Brokername muss mindestens 7 Zeichen lang sein</span>
        </div>

        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.Email.$error }">
          <label for="Email" class="block mb-2">Email</label>
          <input 
            type="email" 
            id="Email" 
            class="w-full px-4 py-2 border border-green-500 rounded" 
            :placeholder="user.Email || 'Gib deine Email ein'" 
            v-model="updateUser.Email" 
            @blur="v$.updateUser.Email.$touch()" 
          />
          <span v-if="v$.updateUser.Email.$error">Gültige Email-Adresse eingeben</span>
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
          <span v-if="v$.updateUser.Passwort.$error">Passwort muss mindestens 6 Zeichen lang sein</span>
        </div>

        <!-- Checkbox -->
        <div class="mb-4">
          <input type="checkbox" id="confirmUpdate" v-model="updateAllowed" class="mr-2" />
          <label for="confirmUpdate">Ich bestätige, dass ich meine Daten aktualisieren möchte</label>
        </div>

        <button type="submit" class="w-full bg-green-700 text-white py-2 px-4 rounded hover:bg-green-800 disabled:bg-gray-400" :disabled="!updateAllowed">
          Speichern 💾
        </button>

        <!-- Account löschen -->
    <button type="button" class="w-full bg-red-600 text-white py-2 px-4 rounded mt-4 hover:bg-red-700"
          @click="deleteAccount">
          Account löschen 🗑️
        </button>
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

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s ease;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
