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
        }
    },
    validations() {
    return {
        updateUser: {
        name: { required, minLength: minLength(3) },
        brokername: { required, minLength: minLength(7) },
        email: { required, email },
        password: { required, minLength: minLength(6) },
      },
    }
  },
    methods: {
        updateUserSettings() {
            this.v$.$validate(); 
            if(!this.v$.$error) {
                console.log('Update successful');
            } else {
                console.log('Update failed');
            }
        },
        async updateSettings() {
            try {
                this.v$.$validate();
                if (!this.v$.$error) {
                    const formData = new FormData();
                    for (const key in this.updateUser) {
                        formData.append(key, this.updateUser[key]);
                    }
                    await axios.post('http://localhost/php/vuediplomarbeit/src/api/user.php?action=update', formData);
                    this.updateUser = {
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
        },
    }
};
</script>

<template>
    <div class="flex justify-center items-center mt-10">
        <div class="w-1/3">
            <h2 class="text-2xl font-bold mb-4">Settings</h2>
            <form>
                <div class="mb-4">
                    <label for="name" class="block mb-2">Name</label>
                    <input type="text" id="name" class="w-full px-4 py-2 border border-green-500 rounded" v-model="user.name" disabled />
                </div>
                <div class="mb-4">
                    <label for="brokername" class="block mb-2">Brokername</label>
                    <input type="text" id="brokername" class="w-full px-4 py-2 border border-green-500 rounded" v-model="user.brokername" />
                </div>
                <div class="mb-4">
                    <label for="email" class="block mb-2">Email</label>
                    <input type="email" id="email" class="w-full px-4 py-2 border border-green-500 rounded" v-model="user.email" />
                </div>
                <div class="mb-4">
                    <label for="password" class="block mb-2">Password</label>
                    <input type="password" id="password" class="w-full px-4 py-2 border border-green-500 rounded" v-model="user.password" />
                </div>
                <button type="button" class="w-full bg-green-700 text-white py-2 px-4 rounded hover:bg-green-800" @click="updateUserSettings(), updateSettings()">Save</button>
            </form>
        </div>
    </div>
</template>