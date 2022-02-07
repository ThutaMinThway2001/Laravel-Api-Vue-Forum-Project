<template>
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-2 mt-5">
                <div class="card text-center">
                    <div class="card-header bg-success text-light flexing">
                        <div>
                            <h3>{{post.title}}</h3>
                        </div>
                        <div><span>1s ago</span></div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            {{post.detail}}
                        </p>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="flexing">
                            <div class="item">
                                N5
                            </div>
                            <div class="item">
                                {{post.author.name}}
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="btnFlexing">
                            <div class="item">
                                <router-link :to="{name: 'updatePost', params: {id: post.id}}">
                                    <button class="btn btn-sm btn-rounded btn-warning">
                                    <span><i class="fas fa-edit me-2"></i></span>Edit
                                </button>
                                </router-link>
                            </div>
                            <div class="item">
                                <button @click.prevent="deletePost(post.id)" class="btn btn-sm btn-rounded btn-danger ms-3">
                                    <span><i class="far fa-trash-alt me-2"></i></span>Delete
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <form @submit.prevent="storeComment">
                            <div class="form-group">
                            <label for="" class="">Enter Comment</label>
                            <textarea class="form-control" v-model="comment"></textarea>
                            </div>
                            <button class="btn btn-sm btn-success float-end mt-4">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3 offset-1 mt-3">
                <h3>Post You May Like</h3>
                <div class="card text-center mb-2">
                    <div class="card-header bg-success text-light flexing">
                        <div>
                            <h3>{{post.title}}</h3>
                        </div>
                        <div><span>1s ago</span></div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            {{post.detail}}
                        </p>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="flexing">
                            <div class="item">
                                N5
                            </div>
                            <div class="item">
                                {{post.author.name}}
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
        <div class="row" v-for="comment in post.comments" :key="comment.id">
            <div class="col-md-6 offset-2 mt-3">
            <div class="card text-white">
                <div class="card-header bg-dark">
                    <img
                        src=""
                        alt=""
                        width="30px"
                        style="border-radius: 50%"
                    />
                    {{comment.author.name}}
                    <small>1s</small>
                </div>
                <div class="card-body text-dark">
                    <p >{{comment.comment}}</p>
                </div>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
export default {
    props: ['id'],
    data(){
        return{
            comment: '',
            token: localStorage.getItem('accessToken'),
            post: {}
        }
    },
    methods:{
        storeComment(){
            axios.post('http://127.0.0.1:8000/api/comments', {
                comment: this.comment,
                post_id: this.post.id
            },{
                headers: {
                    'Accept' : 'application/json',
                    'Authorization' : 'Bearer ' + this.token
                }
            }).then((response) => {
                this.$router.go(0);
            }).catch((error) => {
                console.log(error);
            })
        },
        deletePost(id){
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/posts/${id}`, {
                    headers:{
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + this.token
                    }
                }).then((response) => {
                    Swal.fire({ title: 'Deleted', icon: 'success' })
                    this.$router.push('/');
                }).catch((error) => console.log(error));
                }
                })
            
        },
        getSinglePost(){
            axios.get(`/api/posts/${this.id}`)
            .then((response) => {
                this.post = response.data
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
    .btnFlexing{
        display: flex;
        justify-content: flex-end;
    }
</style>