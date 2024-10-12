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
        firstname: '',
        lastname: '',
        brokername: '',
        email: '',
        password: '',
      },
      updateUser: {
        firstname: '',
        lastname: '',
        brokername: '',
        email: '',
        password: '',
      }
    });

    const rules = {
      updateUser: {
        firstname: { minLength: minLength(3) },
        lastname: { minLength: minLength(3) },
        brokername: { minLength: minLength(7) },
        email: { email },
        password: { required, minLength: minLength(6) },
      }
    };

    const v$ = useVuelidate(rules, state);

    const fetchUserData = async () => {
      const userId = localStorage.getItem('userid');
      const response = await axios.get(`http://localhost/php/vuediplomarbeit/src/api/user.php?action=getUser&UserID=${userId}`, {
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
      const response = await axios.post(`http://localhost/php/vuediplomarbeit/src/api/user.php?action=updateUser&UserID=${userId}`, state.updateUser, {
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
        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.firstname.$error }">
          <label for="firstname" class="block mb-2">First Name</label>
          <input type="text" id="firstname" class="w-full px-4 py-2 border border-green-500 rounded" :placeholder="user.Firstname" v-model="updateUser.firstname" @blur="v$.updateUser.firstname.$touch()" />
          <span v-if="v$.updateUser.firstname.$error">First name is required and must be at least 3 characters long</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.lastname.$error }">
          <label for="lastname" class="block mb-2">Last Name</label>
          <input type="text" id="lastname" class="w-full px-4 py-2 border border-green-500 rounded" :placeholder="user.Lastname" v-model="updateUser.lastname" @blur="v$.updateUser.lastname.$touch()" />
          <span v-if="v$.updateUser.lastname.$error">Last name is required and must be at least 3 characters long</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.brokername.$error }">
          <label for="brokername" class="block mb-2">Brokername</label>
          <input type="text" id="brokername" class="w-full px-4 py-2 border border-green-500 rounded" :placeholder="user.Brokername" v-model="updateUser.brokername" @blur="v$.updateUser.brokername.$touch()" />
          <span v-if="v$.updateUser.brokername.$error">Brokername is too short</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.email.$error }">
          <label for="email" class="block mb-2">Email</label>
          <input type="email" id="email" class="w-full px-4 py-2 border border-green-500 rounded" :placeholder="user.Email" v-model="updateUser.email" @blur="v$.updateUser.email.$touch()" />
          <span v-if="v$.updateUser.email.$error">Email is incorrect</span>
        </div>
        <div class="mb-4" :class="{ 'form-group-error': v$.updateUser.password.$error }">
          <label for="password" class="block mb-2">Password</label>
          <input type="password" id="password" class="w-full px-4 py-2 border border-green-500 rounded" :placeholder="user.password" v-model="updateUser.password" @blur="v$.updateUser.password.$touch()" />
          <span v-if="v$.updateUser.password.$error">Password is required</span>
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