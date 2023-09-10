<script setup>
import Card from "@/components/Card.vue";
import HeroCard from "@/components/HeroCard.vue";
import {onMounted, ref} from "vue";
import axiosClient from "@/axiosClient";

const articles = ref([]);
onMounted(async () => {
  axiosClient
      .get(`articles`)
      .then(({data}) => articles.value.push(data.data));
});

</script>

<template>
  <HeroCard/>
  <div class="mt-3">
    <div class="mb-5 ">
      <nav class="nav d-flex   border-bottom">
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

    <div class="row row-cols-lg-2 gx-3 ">
      <div v-for="article in articles[0]" :key="article.id" class="col ">
        <Card :article="article"/>
      </div>
    </div>
  </div>
</template>
