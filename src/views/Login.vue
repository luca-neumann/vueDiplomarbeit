<script>
import useVuelidate from '@vuelidate/core';
import { required, email, minLength } from '@vuelidate/validators';
import axios from 'axios';

export default {
    name: 'Login',
    data() {
        return {
            v$: useVuelidate(),
            loginData: {
                email: '',
                password: '',
            },
        }
    },
    validations() {
        return {
            loginData: {
                email: { required, email },
                password: { required, minLength: minLength(6) },
            },
        }
    },
    methods: {
        checkLogin() {
        this.v$.$validate(); 
            if(!this.v$.$error) {
                this.$router.push('/feed');
            } else {
                console.log('Login failed');
            }
        },
        // Datenbank
        async login() {
            try {
            const formData = new FormData();
            for (const key in this.loginData) {
                formData.append(key, this.loginData[key]);
            }
            const response = await axios.post('http://localhost/php/vuediplomarbeit/src/api/user.php?action=login', formData);
            if (response.data.status === 'success') {
                console.log('Login successful');
                // es wird in den Local Storage geschrieben
                localStorage.setItem('userData', JSON.stringify(response.data.userData));
            } else {
                console.log(response.data.message || 'Login failed');
                if (response.data.message === 'User not found') {
                alert('User not found');
                } else if (response.data.message === 'Invalid password') {
                alert('Invalid password');
                } 
            }
            } catch (error) {
            console.error(error);
            alert('An error occurred while trying to log in.');
            }
        },
    },
}
</script>

<template>
    <div class="flex justify-center items-center mt-10">
        <div class="w-1/3">
            <h2 class="text-2xl font-bold mb-4">Login</h2>
            <form>
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
                <button type="button" class="w-full bg-green-700 text-white py-2 px-4 rounded hover:bg-green-800" @click="login(), checkLogin()">Login</button>
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