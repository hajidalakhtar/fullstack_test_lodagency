<script setup>
defineProps({
  article: {
    type: Object,
    required: true,
  }
})
</script>
<template>
  <div class="card mb-3  ">
    <div class="row ">
      <!--        <div class="col-md-4">-->
      <!--          <img src="https://picsum.photos/250/250" class="img-fluid rounded " alt="...">-->
      <!--        </div>-->
      <div class="col-md-12">
        <div class="card-body">
          <h5 class="card-title h4">{{ article.title }}</h5>
          <p class="card-text mt-1"><small class="text-body-secondary">Last updated 3 mins ago</small>

          </p>
          <div style="
   display: -webkit-box;
    -webkit-line-clamp: 4;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;"
          >
            <div class="fw-normal" v-html="article.content.replace(/<[^>]+>/g, '')"></div>
<!--            const strippedContent = ;-->

          </div>

        </div>
        <div class="w-100">
          <router-link :to="'detail/' + article.id" class="d-flex float-end py-2 px-3">
            Read More
          </router-link>
        </div>

      </div>
    </div>
  </div>

</template>