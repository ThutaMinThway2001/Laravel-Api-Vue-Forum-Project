<template>
    <div>
        <Navbar @posts="posts = $event" @filterBy="current = $event"></Navbar>
        <Posts :filterByName="filterByName"></Posts>
    </div>
</template>

<script>
import Posts from '../tools/Posts'
import Navbar from "../tools/Navbar";
import axios from 'axios';
export default {
    components: {
    Posts, Navbar },
    data() {
        return {
            posts: [],
            current: 'all',
            authName: localStorage.getItem("authName"),
            token: localStorage.getItem("accessToken"),
            loggedin: localStorage.getItem('loggedin')
        };
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
    computed:{
        filterByName(){
            if(this.current === 'n5'){
                return this.posts.filter((p) => {
                    return p.category.name === 'n5'
                })
            }
            if(this.current === 'n4'){
                return this.posts.filter((p) => {
                    return p.category.name === 'n4'
                })
            }

            return this.posts
        },
    },
    created(){
        this.getPosts();
        if(this.authName && this.token && this.loggedin){
            Toast.fire({
                    icon: 'success',
                    title: 'Welcome Back ' + this.authName 
                    })
        }
        setTimeout(()=>{
            localStorage.removeItem('loggedin');
        }, 2000)
    },
    mounted() {
        // console.log()
    },
};
</script>

<style></style>
