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
import PDFObject from 'pdfobject'
import datePicker from 'vue-bootstrap-datetimepicker';
import draggable from 'vuedraggable';

// Components

import Vue from "vue";
import VueRx from "vue-rx";
import VuejsClipper from "vuejs-clipper/dist/vuejs-clipper.umd";

import vSelect from "vue-select";
Vue.component("v-select", vSelect);

import DatePicker from 'v-calendar/lib/components/date-picker.umd'
// Register components in your 'main.js'
Vue.component('v-date-picker', DatePicker)

import VueFormWizard from 'vue-form-wizard'
import {FormWizard, TabContent} from 'vue-form-wizard';
import 'vue-form-wizard/dist/vue-form-wizard.min.css'
Vue.use(VueFormWizard, {
    FormWizard,
    TabContent
});

Vue.use(VueRx);
Vue.use(VuejsClipper,{
    components: {
        clipperPreview: true,
        clipperFixed: true,
        clipperUpload: true
     }
});

window.moment = moment;
window.Swal = Swal;
window.Form = Form;
window.PDFObject = PDFObject;
window.datePicker = datePicker;
window.draggable = draggable;

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

Vue.component('pagination', require('laravel-vue-pagination'));

Vue.prototype.$gate = new Gate(window.user);
Vue.use(VueRouter);
const options = {
    color: '#007bff',
    failedColor: '#874b4b',
    thickness: '3px',
}
Vue.use(VueProgressBar, options);


const routes = [
    { path: '/', component: require('./components/Dashboard.vue').default },
    { path: '/plantilla', name: 'Plantilla', component: require('./components/plantilla/AnnualPlantilla.vue').default },
    { path: '/salaryschedule', component: require('./components/plantilla/SalarySchedule.vue').default },
    { path: '/departments', component: require('./components/plantilla/Departments.vue').default },
    { path: '/positions', component: require('./components/plantilla/Positions.vue').default },
    { path: '/appointments', component: require('./components/plantilla/Appointments.vue').default },
    { path: '/leave-credits', component: require('./components/leave/Credits.vue').default },
    { path: '/leave-applications', component: require('./components/leave/LeaveApplications.vue').default },
    { path: '/leave-form', component: require('./components/leave/LeaveForm.vue').default },
    { path: '/leave-types', component: require('./components/leave/LeaveTypes.vue').default },
    { path: '/leave-reports', component: require('./components/leave/LeaveReports.vue').default },
    { path: '/employees', component: require('./components/Employees.vue').default },
    { path: '/employees-pds', component: require('./components/employees/Pds-form.vue').default },
    { path: '/employees-pds-view', component: require('./components/employees/EmployeePDS.vue').default },
    { path: '/employee-pds-edit-requests', component: require('./components/employees/EmployeeEditRequests.vue').default },
    { path: '/employee-reappointments', component: require('./components/employees/Reappointments.vue').default },
    { path: '/employee-status', component: require('./components/employees/EmployeeStatus.vue').default },
    { path: '/employee-leave-applications', component: require('./components/employees/EmployeeLeaveApplications.vue').default },
    { path: '/employee-leave-form', component: require('./components/employees/EmployeeLeaveForm.vue').default },
    { path: '/employee-service-record', component: require('./components/servicerecords/ServiceRecords.vue').default },
    { path: '/requests', component: require('./components/Requests.vue').default },
    { path: '/reports', component: require('./components/reports/Others.vue').default },
    { path: '/nosi', component: require('./components/reports/NOSI.vue').default },
    { path: '/nosa', component: require('./components/reports/NOSA.vue').default },
    { path: '/service-record', component: require('./components/reports/ServiceRecord.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/settings', component: require('./components/management/Settings.vue').default },
    { path: '/users', component: require('./components/management/Users.vue').default },
    { path: '/developer', component: require('./components/management/Developer.vue').default },
    { path: '/audits', component: require('./components/management/Audits.vue').default },
    { path: '/activities', name: 'activities', component: require('./components/activities/Index.vue').default },
    { path: '/activities-create', component: require('./components/activities/Create.vue').default },
    { path: '/activities-edit', component: require('./components/activities/Edit.vue').default },
    { path: '/separations', component: require('./components/plantilla/Separation.vue').default },
    { path: '/dtr', component: require('./components/dtr/Dtr.vue').default },
]

const router = new VueRouter({
    mode: 'history',
    routes // short for `routes: routes`
})

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

Vue.filter('addOneDay', function(value) {
    return moment(value).add(1, "days").format('LL');
})

Vue.filter('moment_filter', function(value, format) {
    return moment(value).format(format);
})

Vue.filter('amount', function(value){
    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
        settings: {}
    },
    methods: {
        logout() {
            Swal.fire({
                title: 'Logout Account',
                text: "Are you sure you want to logout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Proceed'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$Progress.start();
                    document.getElementById('logout-form').submit()
                    this.$Progress.finish();
                }
            });
        },
        getSettings() {
            axios.get('api/setting')
                .then(({data}) => {
                    this.settings = data;
                })
                .catch(error => {
                    console.log(error.response.data.message);
                });
        }
    },
    created() {
        this.getSettings();
    }
});
