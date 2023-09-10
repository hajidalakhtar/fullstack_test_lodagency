<script setup>
import {computed, ref} from "vue";
import axiosClient from "@/axiosClient";
import {useStore} from "vuex";

const userEmail = ref('');
const userPassword = ref('');


const store = useStore();

const login = (email, password) => {
  store.dispatch('login', {email, password});


};

const loginUser = () => {
  login(userEmail.value, userPassword.value);
};


</script>

<template>
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content rounded-4 shadow">
        <div class="modal-header p-5 pb-4 border-bottom-0">
          <h1 class="fw-bold mb-0 fs-2">Sign up for free </h1>
          <p>{{ error }}</p>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-5 pt-0">
          <div class="form-floating mb-3">
            <input type="email" v-model="userEmail" class="form-control rounded-3" id="floatingInput"
                   placeholder="name@example.com">
            <label for="floatingInput">Email address</label>
          </div>
          <div class="form-floating mb-3">
            <input type="password" v-model="userPassword" class="form-control rounded-3" id="floatingPassword"
                   placeholder="Password">
            <label for="floatingPassword">Password</label>
          </div>
          <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" @click="loginUser">Sign up</button>
          <small class="text-body-secondary">By clicking Sign up, you agree to the terms of use.</small>
        </div>
      </div>
    </div>
  </div>
</template>
