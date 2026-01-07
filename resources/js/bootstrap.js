import axios from 'axios';
import $ from 'jquery'; // Добавьте эту строку

window.axios = axios;
window.$ = window.jQuery = $; // И эту строку

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
