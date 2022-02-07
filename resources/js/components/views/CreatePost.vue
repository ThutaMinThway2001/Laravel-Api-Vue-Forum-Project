<template>
    <div>
        <div class="container mt-5">
            <div class="col-md-4 offset-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Post</h4> 
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="CreatePost">
                            <AlertError :form="form" >{{errorMessage}}</AlertError>
                            <div class="form-group">
                                <label for="text">Enter Your Title</label>
                                <input type="text" class="form-control" id="title" v-model="form.title">
                                <div class="text-danger mt-1" v-if="form.errors.has('title')" v-html="form.errors.get('title')" />
                            </div>
                            <div class="form-group">
                                <label for="slug">Enter Your slug</label>
                                <input type="text" class="form-control" id="slug" v-model="form.slug">
                                <div class="text-danger mt-1" v-if="form.errors.has('slug')" v-html="form.errors.get('slug')" />
                            </div>
                            <div class="form-group">
                                <label for="detail">Enter Your Detail</label>
                                <input type="text" class="form-control" id="detail" v-model="form.detail">
                                <div class="text-danger mt-1" v-if="form.errors.has('detail')" v-html="form.errors.get('detail')" />
                            </div>
                            <div class="form-group">
                                <label for="detail">Choose Level</label>
                                <div class="box">
                                    <select v-model="form.category_id">
                                    <option :value="category.id" v-for="category in categories" :key="category.id">{{category.name}}</option>
                                </select>
                                </div>
                            </div>
                            <Button :form="form" class="btn btn-sm btn-success mt-3 float-end">Create Post</Button>
                        </form>
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
            token: localStorage.getItem('accessToken'),
            errorMessage: '',
            categories: {},
            form: new Form({
                title: '',
                slug: '',
                detail: '',
                category_id: ''
            })
        }
    },
    methods:{
        CreatePost(){
            this.form.post('/api/posts', {
                headers:{
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + this.token
                }
            })
            .then((res) => {
                Toast.fire({
                    icon: 'success',
                    title: 'Post Created Successfully'
                    })
                this.$router.push('/');
            })
            .catch((error) => {
                console.log(error.response.data);
                this.errorMessage = error.response.data.message;
            });
        }
    },
    created(){
        axios.get('http://127.0.0.1:8000/api/categories')
        .then((response) => {
            this.categories = response.data.data;
        })
        .catch((error) => console.log(error));
    }
}
</script>

<style>
    .box select {
    background-color: #0563af;
    color: white;
    padding: 8px;
    width: 324px;
    border: none;
    font-size: 15px;
    box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
    -webkit-appearance: button;
    appearance: button;
    outline: none;
    }

    .box::before {
    content: "\f13a";
    font-family: FontAwesome;
    position: absolute;
    top: 0;
    right: 0;
    width: 20%;
    height: 100%;
    text-align: center;
    font-size: 28px;
    line-height: 45px;
    color: rgba(255, 255, 255, 0.5);
    background-color: rgba(255, 255, 255, 0.1);
    pointer-events: none;
    }

    .box:hover::before {
    color: rgba(255, 255, 255, 0.6);
    background-color: rgba(255, 255, 255, 0.2);
    }

    .box select option {
    padding: 30px;
    }
</style>