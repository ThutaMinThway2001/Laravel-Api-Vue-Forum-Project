<template>
    <div>
        <div class="container mt-5">
            <div class="col-md-4 offset-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Register</h4> 
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="RegisterUser">
                            <AlertError :form="form" >{{form.errorMessage}}</AlertError>
                            <div class="form-group">
                                <label for="name">Enter Your Name</label>
                                <input type="name" class="form-control" id="name" v-model="form.name">
                                <div class="text-danger mt-1" v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
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
                            <Button :form="form" class="btn btn-sm btn-success mt-3 float-end">Register</Button>
                        </form>
                    </div>
                    <div class="card-footer">
                        <p class="text-center">already login? 
                            <router-link :to="{name: 'login'}">
                                Login Here!
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
            authName: localStorage.getItem('authName'),
            form: new Form({
                errorMessage: '',
                name: '',
                email: '',
                password: '',
            })
        }
    },
    methods:{
        RegisterUser(){
            this.form.post('api/register')
            .then((response) => {
                localStorage.setItem('accessToken', response.data.token);
                localStorage.setItem('authName', response.data.data.name);
                localStorage.setItem('authID', response.data.data.id);
                Toast.fire({
                    icon: 'success',
                    title: 'Registered Successfully'
                    })
                this.$router.push('/') 
            }).catch((error) => {
                this.form.errorMessage = error.response.data.message;
            })
        }
    }
}
</script>

<style>

</style>