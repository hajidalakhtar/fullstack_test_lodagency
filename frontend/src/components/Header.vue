<script setup>
import Login from "@/views/auth/Login.vue";
import {computed} from "vue";
import {useStore} from "vuex";
import Register from "@/views/auth/Register.vue";

const store = useStore()
const user = computed(() => store.getters.getUser);
</script>
<template>
  <header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
      <div class="col-4 pt-1">
        <a class="text-muted" href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
               stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3">
            <circle cx="10.5" cy="10.5" r="7.5"></circle>
            <line x1="21" y1="21" x2="15.8" y2="15.8"></line>
          </svg>
        </a>
      </div>
      <div class="col-4 text-center">
        <a class="blog-header-logo text-dark h2" href="#">LodArticle</a>
      </div>
      <div class="col-4 d-flex justify-content-end align-items-center">
        <div v-if="user == null">
          <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                  data-bs-target="#loginModal">Login
          </button>
          <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal"
                  data-bs-target="#registerModal">Register
          </button>
        </div>
        <div v-else class="d-flex">
          <a href="/dashboard" class="mx-3">My Article</a>
          <p>{{ user.fullname }}</p>
        </div>
      </div>
    </div>
  </header>

  <Login/>
  <Register/>

</template>
<style scoped>

</style>
