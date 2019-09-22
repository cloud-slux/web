/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

require('./viewform/components/table.vue');
require('./viewform/containers/datagrid.vue');
require('./viewform/containers/multiform.vue');
require('./viewform/containers/formgenerator.vue');

import formBar from './viewform/containers/formbar.vue';

import moduleIndex from './viewform/containers/moduleIndex.vue'

import toolBox from './viewform/containers/toolbox.vue';
import filterBox from './viewform/containers/filterbox.vue';

import numberInput from "./viewform/components/numberInput";
import moneyInput from "./viewform/components/moneyInput";
import choiceInput from "./viewform/components/choiceInput";
import selectInput from "./viewform/components/selectInput";
import pickerInput from "./viewform/components/pickerInput";
import textInput from "./viewform/components/textInput";
import progressBar from "./viewform/components/progressBar";



import classificationComponent from './components/financial/ClassificationComponent.vue';
import addClassification from './components/financial/addClassification.vue';

import VueResource from 'vue-resource';
Vue.use(VueResource);

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

import VueMaterial from 'vue-material';
import 'vue-material/dist/vue-material.min.css';
import 'vue-material/dist/theme/default.css';

Vue.use(VueMaterial);

import store from './store/index';


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
    components: {
        'classification-component': classificationComponent,
        'add-classification': addClassification,
        'module-index': moduleIndex,
        'tool-box': toolBox,
        'filter-box': filterBox,
        'form-bar': formBar,
        'progress-bar': progressBar,
        'text-input': textInput,
        'choice-input': choiceInput,
        'picker-input': pickerInput,
        'select-input': selectInput,
        'number-input': numberInput,
        'money-input': moneyInput
    }
});
