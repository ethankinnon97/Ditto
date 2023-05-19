import Vue from 'vue';
require('./bootstrap');

Vue.component('input-form', require('./components/form.vue').default);

const app = new Vue({
    el: '#app',
});
