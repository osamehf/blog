require('./bootstrap');
import Vue from 'vue';
import App from "./src/layouts/App.vue";

new Vue({
    render: (h) => h(App),
}).$mount("#app");
  