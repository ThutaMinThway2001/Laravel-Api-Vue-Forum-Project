<template>
    <div class="container">
        <div class="row">
            <div class="col-md-3 mt-3" v-for="post in posts" :key="post.id">
                <div class="card text-center">
                    <div class="card-header bg-success text-light flexing">
                        <div>
                            <router-link :to="{name: 'singlePost', params: {id: post.id}}" >
                                <p class="text-white pt-3">
                                    {{post.title}}
                                </p>
                            </router-link>
                        </div>
                        <div><p class="pt-3">1s ago</p></div>
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
    </div>
</template>

<script>
import axios from 'axios'
export default {
    data(){
        return{
            posts: []
        }
    },
    methods:{
        getPosts(){
            axios.get('/api/posts')
            .then((response)=>{
                this.posts = response.data.data;
            })
            .catch((err) => console.log(err));
            }
    },
    created(){
        this.getPosts();
    }
}
</script>

<style>
    .flexing{
        display: flex;
        justify-content: space-between;
    }
</style>