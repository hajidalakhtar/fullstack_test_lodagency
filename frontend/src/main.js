import './assets/main.css'
import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import {createApp} from 'vue'
import App from './App.vue'
import router from './router'
import store from "@/store";

const app = createApp(App)

app.use(router)
app.use(store)


store.commit("initialiseStore");
app.mount('#app')
