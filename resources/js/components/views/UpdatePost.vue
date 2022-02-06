<template>
    <div>
        <div class="container mt-5">
            <div class="col-md-4 offset-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Update Post</h4> 
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="UpdatePost">
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
                            <Button :form="form" class="btn btn-sm btn-success mt-3 float-end">Update</Button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'vform'
import axios from 'axios'
export default {
    props: ['id'],
    data(){
        return{
            token: localStorage.getItem('accessToken'),
            errorMessage: '',
            form: new Form({
                title: '',
                slug: '',
                detail: ''
            })
        }
    },
    methods:{
        UpdatePost(){
            this.form.put('http://127.0.0.1:8000/api/posts/' + this.id, {
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer ' + this.token 
                }
            })
            .then((response) => {
                Toast.fire({
                    icon: 'success',
                    title: 'Post Updated Successfully'
                    })
                this.$router.push('/');
            })
            .catch((error) => {
                console.log(error.response);
            })
        },
        getSinglePost(){
            axios.get(`/api/posts/${this.id}`)
            .then((response) => {
                this.form.title = response.data.title
                this.form.slug = response.data.slug
                this.form.detail = response.data.detail
            })
            .catch((err) => console.log(err));
        }
    },
    created(){
        this.getSinglePost();
    }
}
</script>

<style>

</style>