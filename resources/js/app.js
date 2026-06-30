/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';

import feather from 'feather-icons';

import { createApp } from 'vue';
import Notification from './components/Notification.vue';
import vSelect from 'vue-select';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = createApp({
    data() {
        return {
            selected: {},
            show_details: false
        };
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

    mounted() {
        // Replace feather icons after Vue has rendered the DOM
        feather.replace();

        // Initialize Bootstrap dropdowns after Vue mounts, since Vue takes
        // over the DOM and Bootstrap's auto-init may not find the elements.
        var dropdownTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="dropdown"]'));
        dropdownTriggerList.map(function (el) {
            return new window.bootstrap.Dropdown(el);
        });

        // Tri-state theme picker (system / light / dark) in the user menu. The
        // resolved theme is applied before paint in the layout <head>; here we
        // persist the chosen preference, mark the active option, and follow the
        // OS setting live whenever the preference is "system".
        const root = document.documentElement;
        const themeItems = document.querySelectorAll('[data-theme-pref]');
        if (themeItems.length) {
            const media = window.matchMedia('(prefers-color-scheme: dark)');

            const getPref = () => localStorage.getItem('theme') || 'system';
            const resolve = (pref) =>
                pref === 'dark' || (pref === 'system' && media.matches) ? 'dark' : 'light';

            const apply = () => {
                const pref = getPref();
                root.setAttribute('data-bs-theme', resolve(pref));
                themeItems.forEach((item) => {
                    item.setAttribute('aria-checked',
                        item.getAttribute('data-theme-pref') === pref ? 'true' : 'false');
                });
            };

            apply();

            themeItems.forEach((item) => {
                item.addEventListener('click', (event) => {
                    event.preventDefault();
                    localStorage.setItem('theme', item.getAttribute('data-theme-pref'));
                    apply();
                });
            });

            // Follow the OS setting live while the preference is "system".
            media.addEventListener('change', () => {
                if (getPref() === 'system') {
                    apply();
                }
            });
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

app.component('notification', Notification);
app.component('v-select', vSelect);

app.mount('#app');

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
