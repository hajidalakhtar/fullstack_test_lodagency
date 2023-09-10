<template>
  <div class="mt-3">
    <div class="mb-3">
      <nav class="nav d-flex border-bottom">
        <a class="p-2 link-secondary" href="#">World</a>
        <a class="p-2 link-secondary" href="#">U.S.</a>
        <a class="p-2 link-secondary" href="#">Technology</a>
        <a class="p-2 link-secondary" href="#">Design</a>
        <a class="p-2 link-secondary" href="#">Culture</a>
        <a class="p-2 link-secondary" href="#">Business</a>
        <a class="p-2 link-secondary" href="#">Politics</a>
        <a class="p-2 link-secondary" href="#">Opinion</a>
        <a class="p-2 link-secondary" href="#">Science</a>
        <a class="p-2 link-secondary" href="#">Health</a>
        <a class="p-2 link-secondary" href="#">Style</a>
      </nav>
    </div>
    <div class="input-group mb-5">
      <input type="text" class="form-control" v-model="searchInput" placeholder="Recipient's username"
             aria-label="Recipient's username" aria-describedby="basic-addon2">
      <span class="input-group-text" id="basic-addon2">
        <button @click="search">Search</button>
      </span>
    </div>
    <div class="row row-cols-2 gx-5">
      <template v-if="articles.length > 0">
        <div v-for="article in articles" :key="article.id" class="col">
          <Card :article="article"/>
        </div>
      </template>
      <template v-else>
        <div v-if="searchInput.value === null">
          <p>Silahkan cari...</p>
        </div>
        <div v-else>
          <p>Artikel tidak ditemukan</p>
        </div>
      </template>
    </div>
  </div>
</template>

<script setup>
import Card from "@/components/Card.vue";
import axiosClient from "@/axiosClient";
import {ref} from "vue";

const articles = ref([]);
const searchInput = ref('');

const search = () => {
  if (searchInput.value === '') {
    return;
  }

  axiosClient.get(`articles/search/?title=${searchInput.value}`)
      .then(({ data }) => {
        articles.value = data;
      });
}
</script>
