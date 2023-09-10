<script setup>
import {onMounted, ref} from "vue";
import axiosClient from "@/axiosClient";
import {useRoute} from "vue-router";
import moment from "moment";

const route = useRoute();
const article = ref({});
const author = ref({});

onMounted(async () => {
  axiosClient
      .get(`article/${route.params.id}`)
      .then(({data}) => {
        article.value = data.data
        author.value = data.data.author
      })
});

</script>
<template>
  <div class="row g-5">
    <div class="col-md-12 container-xl	">
      <h3 class="pb-4 mt-3 mb-4 fst-italic border-bottom">

      </h3>

      <article class="blog-post">
        <h2 class="blog-post-title">{{ article.title }}</h2>
        <p class="blog-post-meta">{{ article.publication_date   }} BY <a
            href="#">{{ author.username }}</a></p>

        <div v-html="article.content">

        </div>

      </article>


    </div>

  </div>
</template>