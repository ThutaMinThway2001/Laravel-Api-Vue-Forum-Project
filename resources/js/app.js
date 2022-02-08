import Vue from 'vue'
import router from './router'
import Swal from 'sweetalert2'
import moment from 'moment';

const Toast = Swal.mixin({
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
import {
  Button,
  HasError,
  AlertError,
  AlertErrors,
  AlertSuccess
} from 'vform/src/components/bootstrap5'

window.Swal = Swal;
window.Toast = Toast;

Vue.component(Button.name, Button)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)

Vue.component('app-component', require('./components/App').default);

Vue.filter('myDate', function(created){
  return moment(created).format("MMMM Do YYYY");
})

Vue.filter('second', function(created){
  return moment(created).fromNow();
})
const app = new Vue({
  el: '#app',
  router
});