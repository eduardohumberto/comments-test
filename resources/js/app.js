/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
import VueTailwind from 'vue-tailwind'
import {
    TInput,
    TTextarea,
    TSelect,
    TRadio,
    TCheckbox,
    TButton,
    TInputGroup,
    TCard,
    TAlert,
    TModal,
    TDialog,
} from 'vue-tailwind/dist/components';


Vue.use(VueTailwind, {
    TModal,
    TAlert,
    TDialog,
})

Vue.component('blog-post', require('./components/BlogPostComponent.vue').default);


const app = new Vue({
    el: '#app',
});
