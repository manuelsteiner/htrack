/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const feather = require('feather-icons');

feather.replace();

import Vue from 'vue';
import Notification from './components/Notification.vue';
import vSelect from 'vue-select';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('notification', Notification);
Vue.component('v-select', vSelect);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',

    data: {
        selected: {},

        show_details: false
    },

    computed: {
        selected_id: function() {
            return this.selected.id;
        },

        selected_name: function () {
            return this.selected.name;
        },

        selected_serving_size: function() {
            return this.selected.serving_size;
        },

        selected_calories: function() {
            return this.selected.calories;
        },

        selected_carbohydrates: function() {
            return this.selected.carbohydrates;
        },

        selected_sugar: function() {
            return this.selected.sugar;
        },

        selected_fibre: function() {
            return this.selected.fibre;
        },

        selected_fat: function() {
            return this.selected.fat;
        },

        selected_saturated_fat: function() {
            return this.selected.saturated_fat;

        },

        selected_protein: function() {
            return this.selected.protein;

        },

        selected_sodium: function() {
            return this.selected.sodium;
        },

        details: function () {
            return {
                'd-none': (!this.selected.id && !this.selected.name) || (this.selected.id && !this.show_details)
            };
        },

        disable_details_button: function () {
            if(this.selected.id) {
                return false;
            }
            else {
                return true;
            }
        },

        existing_food_selected: function () {
            if(this.selected.id) {
                return true;
            }
            else {
                return false;
            }
        }
    },

    methods: {
        onSelectionChange(value) {
            if(value) {
                this.selected = value;
            }
            else {
                this.selected = {};
                this.show_details = false;
            }
        },

        onDetailsClick(event) {
            this.show_details = !this.show_details;
        }
    }
});

(function() {
    'use strict';
    window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
