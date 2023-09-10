<script setup>
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import {computed, onMounted, ref} from "vue";
import axiosClient from "@/axiosClient";

DataTable.use(DataTablesCore);

const loadArticles = () => {
  var user = JSON.parse(localStorage.getItem("store")).user;

  console.log(user)
  axiosClient.get(`articles/search?user_id=${user.id}`).then(({data}) => {
    articles.value = data;
  });
}

const deleteArticle = (id) => {
  axiosClient.delete(`article/${id}`)
      .then(response => {
        console.log(response);
        loadArticles();
      })
      .catch(error => {
        console.log(error);
      });
}

const columns = [
  {data: 'id', title: 'ID'},
  {data: 'title', title: 'Judul'},
  {
    data: 'content',
    title: 'Konten',
    render: function (data, type, full, meta) {
      const strippedContent = full.content.replace(/<[^>]+>/g, '');
      return "<p class='truncate'>" + strippedContent + "</p>";
    }
  },
  {data: 'publication_date', title: 'Tanggal Publikasi'},
  {
    data: 'Action', title: 'Aksi', render: function (data, type, full, meta) {
      return `
        <a href='/edit/${full.id}' class='mx-1 text-warning'>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
          </svg>
        </a>
        <button data-id='${full.id}' class='delete-btn btn text-danger'>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
          </svg>
        </button>
        <a href='/detail/${full.id}' class='mx-1 text-success'>
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
            <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
            <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
          </svg>
        </a>
      `;
    }
  }
];

const articles = ref([]);
const table = ref();

onMounted(() => {

  loadArticles();

  let dt = table.value.dt;

  dt.on('click', '.delete-btn', function () {
    let id = this.getAttribute('data-id');
    deleteArticle(id);
  });
});
</script>

<template>
  <a href="/create" class="mb-2 btn-sm btn btn-primary mt-4 ">Create Article</a>

  <div class="row  ">
    <div class="col-md-12 ">
      <div class="card">
        <div class="card-body">
          <DataTable
              ref="table"
              :columns="columns"
              :data="articles"
              class="table table-hover table-striped"
              width="100%"
          >
            <thead>
            <tr>
              <th> No.</th>
              <th> Title</th>
              <th> Content</th>
              <th> Publish Date</th>
              <th> Action</th>
            </tr>
            </thead>

          </DataTable>
        </div>
      </div>
    </div>
  </div>

</template>

<style>
@import 'bootstrap';
@import 'datatables.net-bs5';
</style>


<!--<template>-->

<!--  <div class="row mt-4 ">-->
<!--    <div class="col-md-2 ">-->
<!--      <ul class="nav nav-pills flex-column mb-auto">-->
<!--        <li class="nav-item">-->
<!--          <a href="#" class="nav-link active" aria-current="page">-->

<!--            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"-->
<!--                 class="bi bi-house-door-fill mb-1 " viewBox="0 0 16 16">-->
<!--              <path-->
<!--                  d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z"/>-->
<!--            </svg>-->
<!--            &nbsp;-->
<!--            Article-->
<!--          </a>-->
<!--        </li>-->
<!--        <li>-->
<!--          <a href="#" class="nav-link link-dark">-->
<!--            <svg class="bi me-2" width="16" height="16">-->
<!--              <use xlink:href="#speedometer2"></use>-->
<!--            </svg>-->
<!--            Dashboard-->
<!--          </a>-->
<!--        </li>-->
<!--      </ul>-->

<!--    </div>-->
<!--    <div class="col-md-10 ">-->
<!--      <div class="card">-->
<!--        <div class="card-header">-->
<!--          <p>Article</p>-->
<!--        </div>-->
<!--        <div class="card-body">-->
<!--          <table class="table table-bordered">-->
<!--            <thead>-->
<!--            <tr>-->
<!--              <th scope="col">No.</th>-->
<!--              <th scope="col">Title</th>-->
<!--              <th scope="col">Content</th>-->
<!--              <th scope="col">Publise Date</th>-->
<!--              <th scope="col">Action</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--            <tbody>-->
<!--            <tr>-->
<!--              <th scope="row">1</th>-->
<!--              <td>Title 1</td>-->
<!--              <td>Content 1</td>-->
<!--              <td>Publise Date 1</td>-->
<!--              <td>-->
<!--                <button class="btn btn-primary">Edit</button>-->
<!--                <button class="btn btn-danger">Delete</button>-->
<!--              </td>-->
<!--            </tr>-->

<!--            <tr>-->
<!--              <th scope="row">2</th>-->
<!--              <td>Title 2</td>-->
<!--              <td>Content 2</td>-->
<!--              <td>Publise Date 2</td>-->
<!--              <td>-->
<!--                <button class="btn btn-primary">Edit</button>-->
<!--                <button class="btn btn-danger">Delete</button>-->
<!--              </td>-->
<!--            </tr>-->


<!--            </tbody>-->
<!--          </table>-->

<!--        </div>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<!--</template>-->