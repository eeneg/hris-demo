/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment';
import { Form, HasError, AlertError } from 'vform'
import VueRouter from 'vue-router'
import VueProgressBar from 'vue-progressbar'
import Swal from 'sweetalert2'
import Gate from './gate'

window.Swal = Swal;
window.Form = Form;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.prototype.$gate = new Gate(window.user);
Vue.use(VueRouter);
Vue.use(VueProgressBar, options);


const routes = [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/employees', component: require('./components/Employees.vue').default },
    { path: '/requests', component: require('./components/Requests.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/settings', component: require('./components/management/Settings.vue').default },
    { path: '/users', component: require('./components/management/Users.vue').default },
    { path: '/developer', component: require('./components/management/Developer.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default },
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

const options = {
    color: '#a50d75',
    failedColor: '#874b4b',
    thickness: '3px',
}

const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.toast = toast;


Vue.filter('capitalize', function(value){
    if (!value) return ''
    value = value.toString()
    return value.toUpperCase()
    // return value.charAt(0).toUpperCase() + value.slice(1)
})

Vue.filter('validateCount', function(value){
    if (value == null) {
        return '0'
    } else {
        return value
    }
    
    // return value.charAt(0).toUpperCase() + value.slice(1)
})

Vue.filter('myDate', function(value){
    return moment(value).format('LL');
})

Vue.filter('initial', function(value){
    if (value == null) {
        return ''
    } else {
        return value.charAt(0).toUpperCase() +'.'
    }
})


window.Fire = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-authorized',
    require('./components/NotAuthorized.vue').default
);


Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data: {
        search: ''
    },
    methods: {
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        }, 400)
    }
});
