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

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//login y menu principal
Vue.component('ingreso-component', require('./components/IngresoComponent.vue').default);
Vue.component('principal-menu-component', require('./components/PrincipalMenuComponent.vue').default);

//acciones netas
Vue.component('principal-work-component', require('./components/PrincipalWorkComponent.vue').default);
Vue.component('principal-gestion-ot-component', require('./components/PrincipalGestionOtComponent.vue').default);
Vue.component('principal-gestion-material-component', require('./components/PrincipalGestionMaterialComponent.vue').default);


//opciones de boton
Vue.component('iniciar-trabajo-component', require('./components/IniciarTrabajoComponent.vue').default);
Vue.component('gestionar-ot-component', require('./components/GestionarOtComponent.vue').default);
Vue.component('gestionar-material-component', require('./components/GestionarMaterialComponent.vue').default);

//atomicos
Vue.component('modal-ot-component', require('./components/ModalOtComponent.vue').default);
Vue.component('modal-ot-edit-component', require('./components/ModalOtEditComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
