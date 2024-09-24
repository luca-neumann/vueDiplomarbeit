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
        firstname: '',
        lastname: '',
        brokername: '',
        email: '',
        password: '',
      }
    });

    const rules = {
      newRegistration: {
        firstname: { required, minLength: minLength(3) },
        lastname: { required, minLength: minLength(3) },
        brokername: { required, minLength: minLength(7) },
        email: { required, email },
        password: { required, minLength: minLength(6) },
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
        const response = await axios.post('http://localhost/php/vuediplomarbeit/src/api/user.php?action=registration', state.newRegistration, {
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
          state.newRegistration.firstname = '';
          state.newRegistration.lastname = '';
          state.newRegistration.brokername = '';
          state.newRegistration.email = '';
          state.newRegistration.password = '';
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
        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.firstname.$error }">
          <label for="firstname" class="block mb-2">First Name</label>
          <input type="text" id="firstname" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.firstname" @blur="v$.newRegistration.firstname.$touch()" />
          <span v-if="v$.newRegistration.firstname.$error">First name is required and must be at least 3 characters long</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.lastname.$error }">
          <label for="lastname" class="block mb-2">Last Name</label>
          <input type="text" id="lastname" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.lastname" @blur="v$.newRegistration.lastname.$touch()" />
          <span v-if="v$.newRegistration.lastname.$error">Last name is required and must be at least 3 characters long</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.brokername.$error }">
          <label for="brokername" class="block mb-2">Brokername</label>
          <input type="text" id="brokername" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.brokername" @blur="v$.newRegistration.brokername.$touch()" />
          <span v-if="v$.newRegistration.brokername.$error">Brokername is required and must be at least 7 characters long</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.email.$error }">
          <label for="email" class="block mb-2">Email</label>
          <input type="email" id="email" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.email" @blur="v$.newRegistration.email.$touch()" />
          <span v-if="v$.newRegistration.email.$error">A valid email is required</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.newRegistration.password.$error }">
          <label for="password" class="block mb-2">Password</label>
          <input type="password" id="password" class="w-full px-4 py-2 border border-green-500 rounded" v-model="newRegistration.password" @blur="v$.newRegistration.password.$touch()" />
          <span v-if="v$.newRegistration.password.$error">Password is required and must be at least 6 characters long</span>
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