<script>
import { reactive, toRefs, ref } from 'vue';
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
    const errorMessage = ref("");
    let errorTimeout = null;

    const setErrorMessage = (message) => {
      errorMessage.value = message;

      if (errorTimeout) {
        clearTimeout(errorTimeout);
      }

      errorTimeout = setTimeout(() => {
        errorMessage.value = "";
      }, 5000);
    };

    const addNewRegistrationToDd = async () => {
      if (v$.value.$invalid) {
          console.log('Validation failed');
          return;
      }

      try {
          const response = await axios.post(
              'https://os-beyond.at/htl/smart_sensor_netz/register',
              JSON.stringify(state.newRegistration),
              {
                  headers: { 'Content-Type': 'application/json' }
              }
          );

          console.log("Server Response:", response.data);

          // Prüfen, ob die API eine Meldung zurückgibt
          if (response.data.error) {
              if (response.data.message === "E-Mail bereits registriert") {
                  setErrorMessage("❌ Diese E-Mail ist bereits registriert!");
              } else {
                  setErrorMessage(`⚠️ Fehler: ${response.data.message}`);
              }
              return;
          }

          console.log('User added successfully');

          state.newRegistration.Vorname = '';
          state.newRegistration.Nachname = '';
          state.newRegistration.Email = '';
          state.newRegistration.Passwort = '';
          state.newRegistration.Brokername = '';

          router.push('/login');
      } catch (error) {
          console.error('Ein Fehler ist aufgetreten:', error);

          if (error.response) {
              console.log("Error Response:", error.response.data);

              if (error.response.status === 400 || error.response.status === 409) {
                  if (error.response.data.message === "E-Mail bereits registriert") {
                      setErrorMessage("❌ Diese E-Mail ist bereits registriert!");
                  } else {
                      setErrorMessage(`⚠️ Fehler: ${error.response.data.message}`);
                  }
              } else {
                  setErrorMessage(`⚠️ Fehler: ${error.response.status} - Bitte versuche es später erneut.`);
              }
          } else {
              setErrorMessage("⚠️ Fehler bei der Registrierung. Bitte überprüfe deine Internetverbindung.");
          }
      }
  };


    return {
      ...toRefs(state),
      v$,
      addNewRegistrationToDd,
      errorMessage
    };
  }
};
</script>

<template>
  <div class="flex justify-center items-center mt-10">
    <div class="w-1/3">
      <h2 class="text-2xl font-bold mb-4">Registrierung</h2>

      <transition name="fade">
        <p v-if="errorMessage" class="text-red-600 font-bold mb-4">{{ errorMessage }}</p>
      </transition>

      <form @submit.prevent="addNewRegistrationToDd">
        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.Vorname.$error }">
          <label for="Vorname" class="block mb-2">Vorname</label>
          <input type="text" id="Vorname" class="w-full px-4 py-2 border border-gray-300 rounded" v-model="newRegistration.Vorname" @blur="v$.newRegistration.Vorname.$touch()" />
          <span v-if="v$.newRegistration.Vorname.$error" class="text-red-500">Vorname muss mindestens 3 Zeichen haben</span>
        </div>

        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.Nachname.$error }">
          <label for="Nachname" class="block mb-2">Nachname</label>
          <input type="text" id="Nachname" class="w-full px-4 py-2 border border-gray-300 rounded" v-model="newRegistration.Nachname" @blur="v$.newRegistration.Nachname.$touch()" />
          <span v-if="v$.newRegistration.Nachname.$error" class="text-red-500">Nachname muss mindestens 3 Zeichen haben</span>
        </div>

        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.Brokername.$error }">
          <label for="Brokername" class="block mb-2">Brokername</label>
          <input type="text" id="Brokername" class="w-full px-4 py-2 border border-gray-300 rounded" v-model="newRegistration.Brokername" @blur="v$.newRegistration.Brokername.$touch()" />
          <span v-if="v$.newRegistration.Brokername.$error" class="text-red-500">Brokername muss mindestens 7 Zeichen haben</span>
        </div>

        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.Email.$error }">
          <label for="email" class="block mb-2">E-Mail</label>
          <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded" v-model="newRegistration.Email" @blur="v$.newRegistration.Email.$touch()" />
          <span v-if="v$.newRegistration.Email.$error" class="text-red-500">Eine gültige E-Mail-Adresse ist erforderlich</span>
        </div>

        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.Passwort.$error }">
          <label for="Passwort" class="block mb-2">Passwort</label>
          <input type="password" id="Passwort" class="w-full px-4 py-2 border border-gray-300 rounded" v-model="newRegistration.Passwort" @blur="v$.newRegistration.Passwort.$touch()" />
          <span v-if="v$.newRegistration.Passwort.$error" class="text-red-500">Passwort muss mindestens 6 Zeichen haben</span>
        </div>

        <button type="submit" class="w-full bg-green-700 text-white py-2 px-4 rounded hover:bg-green-800">Registrieren 📝</button>
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
