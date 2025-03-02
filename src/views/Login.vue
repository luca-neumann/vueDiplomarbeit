<script>
import { reactive, toRefs, ref } from 'vue';
import useVuelidate from '@vuelidate/core';
import { required, email, minLength } from '@vuelidate/validators';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
    name: 'Login',
    setup() {
        const state = reactive({
            loginData: {
                Email: '',
                Passwort: '',
            }
        });

        const rules = {
            loginData: {
                Email: { required, email },
                Passwort: { required, minLength: minLength(6) },
            }
        };

        const v$ = useVuelidate(rules, state);
        const router = useRouter();
        const errorMessage = ref("");
        let errorTimeout = null;

        const setErrorMessage = (message) => {
            errorMessage.value = message;

            // Vorherigen Timer löschen, falls ein neuer Fehler kommt
            if (errorTimeout) {
                clearTimeout(errorTimeout);
            }

            // Fehler nach 5 Sekunden automatisch löschen
            errorTimeout = setTimeout(() => {
                errorMessage.value = "";
            }, 5000);
        };

        const login = async () => {
            errorMessage.value = ""; 

            if (v$.value.$invalid) {
                console.log('Validation failed');
                return;
            }

            try {
                const response = await axios.post('https://os-beyond.at/htl/smart_sensor_netz/login', JSON.stringify(state.loginData), {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });

                console.log(response.data);

                if (response.data.error) {
                    console.error(response.data.message);
                    setErrorMessage("❌ Ungültige E-Mail oder falsches Passwort!");
                } else {
                    console.log('Login erfolgreich, User ID:', response.data.userId);
                    console.log('Token:', response.data.token);
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('userid', response.data.userId);

                    router.push('/feed');
                    location.reload();
                }
            } catch (error) {
                console.error('Ein Fehler ist aufgetreten:', error);

                if (error.response) {
                    if (error.response.status === 401) {
                        setErrorMessage("❌ Ungültige E-Mail oder falsches Passwort!");
                    } else {
                        setErrorMessage(`⚠️ Fehler: ${error.response.status} - Bitte versuche es später erneut.`);
                    }
                } else {
                    setErrorMessage("⚠️ Fehler beim Login. Bitte überprüfe deine Internetverbindung.");
                }
            }

        };

        return {
            ...toRefs(state),
            v$,
            login,
            errorMessage
        };
    }
};
</script>

<template>
    <div class="flex justify-center items-center mt-10">
        <div class="w-1/3">
            <h2 class="text-2xl font-bold mb-4">Anmelden</h2>

            <!-- Fehlermeldung -->
            <transition name="fade">
                <p v-if="errorMessage" class="text-red-600 font-bold mb-4">{{ errorMessage }}</p>
            </transition>

            <!-- Login Feld -->
            <form @submit.prevent="login">
                <div class="mb-4" :class="{ 'form-group-error': v$.loginData.Email.$error }">
                    <label for="Email" class="block mb-2">Email</label>
                    <input type="email" id="Email" class="w-full px-4 py-2 border border-green-500 rounded"
                           v-model="loginData.Email" @blur="v$.loginData.Email.$touch()" />
                    <span v-if="v$.loginData.Email.$error" class="text-red-500">Gültige E-Mail erforderlich</span>
                </div>

                <div class="mb-4" :class="{ 'form-group-error': v$.loginData.Passwort.$error }">
                    <label for="Passwort" class="block mb-2">Passwort</label>
                    <input type="password" id="Passwort" class="w-full px-4 py-2 border border-green-500 rounded"
                           v-model="loginData.Passwort" @blur="v$.loginData.Passwort.$touch()" />
                    <span v-if="v$.loginData.Passwort.$error" class="text-red-500">Mindestens 6 Zeichen erforderlich</span>
                </div>

                <button type="submit" class="w-full bg-green-700 text-white py-2 px-4 rounded hover:bg-green-800">
                    LogIn 🔓
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
