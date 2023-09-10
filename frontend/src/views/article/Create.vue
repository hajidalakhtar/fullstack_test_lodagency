<script setup>
import TextEditor from "@/components/TextEditor.vue";
import {computed, onMounted, ref} from "vue";
import axiosClient from "@/axiosClient";
import {useStore} from "vuex";
import {useRoute} from "vue-router";


const store = useStore();
const route = useRoute();
const token = computed(() => store.getters.getToken);

const isEdit = route.name === "edit"


const title = ref("")
const content = ref("")
const category = ref("")

onMounted(() => {
  if (isEdit) {
    axiosClient
        .get(`article/${route.params.id}`)
        .then(({data}) => {
          title.value = data.data.title
          content.value = data.data.content
          category.value = data.data.category

        })

  }

})


const createArticle = (token) => {
  let loginData = new FormData();
  loginData.append('title', title.value);
  loginData.append('content', content.value);
  loginData.append('category', category.value);
  loginData.append('slug', title.value);
  loginData.append('user_id', 10);
  loginData.append('publication_date', "2023-01-01");


  axiosClient
      .post('article', loginData, {
        headers: {
          Authorization: `Bearer ${token}`,
        }
      })
      .then(({data}) => {
        window.location.href = '/detail/' + data.data.id;
      })
      .catch(err => {
        console.error(err);
      });

};


const updateArticle = (token) => {
  let loginData = new FormData();
  loginData.append('title', title.value);
  loginData.append('content', content.value);
  loginData.append('category', category.value);
  loginData.append('slug', title.value);
  loginData.append('publication_date', "2023-01-01");
  // loginData.append('thumbnail', thumbnail);

  // thumbnail
  axiosClient
      .post(`article/update/${route.params.id}`, loginData, {
        headers: {
          'Content-Type': 'multipart/form-data',
          Authorization: `Bearer ${token}`,
        }
      })
      .then(() => {
        window.location.href = '/detail/' + route.params.id;
      })
      .catch(err => {
        console.error(err);
      });

};


</script>
<template>
  <!--  <p>{{}}</p>-->
  <div class="row  mt-4" style="min-height: 700px">
    <div class="col-md-12 d-flex">
      <div class="card w-100">
        <div class="card-body  ">
          <input type="text" class="h1-input mb-3" style="width:100%" v-model="title" placeholder="Title">
          <TextEditor v-model="content"/>
        </div>
      </div>
    </div>

  </div>
  <div class="w-100 ">

    <button v-if="isEdit" type="button" class="float-end my-3 btn btn-secondary" @click="updateArticle(token)">
      Save
    </button>

    <button v-else type="button" class="float-end my-3 btn btn-secondary" data-bs-toggle="modal"
            data-bs-target="#createArticleModal">
      Submit
    </button>


    <div class="modal fade" id="createArticleModal" tabindex="-1" aria-labelledby="createArticleModal"
         aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content rounded-4 shadow">
          <div class="modal-header border-bottom-0">
            <h1 class="modal-title fs-5">Modal title</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body py-0">
            <label>Category</label>

            <select class="form-select " aria-label="Default select example" v-model="category">
              <option value="World">World</option>
              <option value="U.S.">U.S.</option>
              <option value="Technology">Technology</option>
              <option value="Design">Design</option>
              <option value="Culture">Culture</option>
              <option value="Business">Business</option>
              <option value="Politics">Politics</option>
              <option value="Opinion">Opinion</option>
              <option value="Science">Science</option>
              <option value="Health">Health</option>
              <option value="Style">Style</option>

            </select>
          </div>
          <div class="modal-footer flex-column align-items-stretch w-100 gap-2 pb-3 border-top-0">
            <button type="button" class="btn  btn-primary" @click="createArticle(token)">Submit</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>
