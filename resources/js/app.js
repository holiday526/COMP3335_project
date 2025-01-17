/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// import bootstrap-vue
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

import '../sass/custom.scss';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import UserProfile from "./components/users/UserProfile";
import SystemCard from "./components/dashboard/SystemCard";
import HistoryTable from "./components/history/HistoryTable";
import SystemLoadBarChart from "./components/action/SystemLoadBarChart";
import LoadedComponentsListedGroup from "./components/action/LoadedComponentsListedGroup";
import SystemInformationStackTable from "./components/action/SystemInformationStackTable";
import PatchInfoBanner from "./components/patch/PatchInfoBanner";
import PatchInfoBarChart from "./components/patch/PatchInfoBarChart";
import GameLogsTable from "./components/game_logs/GameLogsTable";

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components: {
        UserProfile,
        SystemCard,
        HistoryTable,
        SystemLoadBarChart,
        LoadedComponentsListedGroup,
        SystemInformationStackTable,
        PatchInfoBanner,
        PatchInfoBarChart,
        GameLogsTable
    }
});
