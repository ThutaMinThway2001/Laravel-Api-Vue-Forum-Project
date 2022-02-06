<template>
    <div>
        <div class="container mt-5">
            <div class="col-md-4 offset-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Login</h4> 
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="LoginUser">
                            <AlertError :form="form" >{{form.errorMessage}}</AlertError>
                            <div v-if="showError" class="error w-100 rounded-5 mb-3" style="height:70px">
                                <p class="text-center pt-4 text-red" >
                                    {{error}}
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="email">Enter Your Email</label>
                                <input type="email" class="form-control" id="email" v-model="form.email">
                                <div class="text-danger mt-1" v-if="form.errors.has('email')" v-html="form.errors.get('email')" />
                            </div>
                            <div class="form-group">
                                <label for="password">password</label>
                                <input type="password" class="form-control" id="password" v-model="form.password">
                                <div class="text-danger mt-1" v-if="form.errors.has('password')" v-html="form.errors.get('password')" />
                            </div>
                            <Button :form="form" class="btn btn-sm btn-success mt-3 float-end">Login</Button>
                        </form>
                    </div>
                    <div class="card-footer">
                        <p class="text-center">Sign up here! 
                            <router-link :to="{name: 'register'}">
                                Register Here!
                            </router-link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'vform'
import axios from 'axios';
export default {
    data(){
        return{
            error: null,
            showError: false,
            form: new Form({
                errorMessage: '',
                email: '',
                password: ''
            })
        }
    },
    methods:{   
        LoginUser(){
            this.form.post('api/login')
            .then((response) => {
                if(response.data.status === 200){
                    localStorage.setItem('accessToken', response.data.token);
                    localStorage.setItem('authName', response.data.data.name);
                    localStorage.setItem('loggedin', 'success');
                    this.$router.push('/')
                }else{
                    this.showError = true
                    setTimeout(() => {
                        this.showError = false
                    }, 
                    5000);
                    
                    this.error = response.data.data.error;
                }
            }).catch((error) => {
                this.form.errorMessage = error.response.data.message;
            })
        }
    }
}
</script>

<style>
    .error{
        background-color: #fed6dd;
    }
</style>