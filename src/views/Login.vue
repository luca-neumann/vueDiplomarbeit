<script>
import { reactive, toRefs } from 'vue';
import useVuelidate from '@vuelidate/core';
import { required, email, minLength } from '@vuelidate/validators';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
    name: 'Login',
    setup() {
        const state = reactive({
            loginData: {
                email: '',
                password: '',
            }
        });

        const rules = {
            loginData: {
                email: { required, email },
                password: { required, minLength: minLength(6) },
            }
        };

        const v$ = useVuelidate(rules, state);
        const router = useRouter();

        const login = async () => {
            if (v$.$invalid) {
                console.log('Validation failed');
                return;
            }

            try {
                const response = await axios.post('http://localhost/php/vuediplomarbeit/src/api/user.php?action=login', state.loginData, {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                console.log(response.data);
                if (response.data.error) {
                    console.error(response.data.message);
                } else {
                    console.log('Login successful, User ID:', response.data.user.UserID);
                    console.log('Token:', response.data.token);
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('userid', response.data.user.UserID);

                    router.push('/feed');
                }
            } catch (error) {
                console.error('An error occurred:', error);
            }
        };

        return {
            ...toRefs(state),
            v$,
            login
        };
    }
};
</script>

<template>
    <div class="flex justify-center items-center mt-10">
        <div class="w-1/3">
            <h2 class="text-2xl font-bold mb-4">Login</h2>
            <form @submit.prevent="login">
                <div class="mb-4" :class="{ 'form-group-error': v$.loginData.email.$error }">
                    <label for="email" class="block mb-2">Email</label>
                    <input type="email" id="email" class="w-full px-4 py-2 border border-green-500 rounded" v-model="loginData.email" @blur="v$.loginData.email.$touch()"/>
                    <span v-if="v$.loginData.email.$error">Email is required or incorrect</span>
                </div>
                <div class="mb-4" :class="{ 'form-group-error': v$.loginData.password.$error }">
                    <label for="password" class="block mb-2">Password</label>
                    <input type="password" id="password" class="w-full px-4 py-2 border border-green-500 rounded" v-model="loginData.password" @blur="v$.loginData.password.$touch()"/>
                    <span v-if="v$.loginData.password.$error">Password is required</span>
                </div>
                <button type="submit" class="w-full bg-green-700 text-white py-2 px-4 rounded hover:bg-green-800">Login</button>
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