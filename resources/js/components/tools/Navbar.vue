<template>
    <div>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button
            class="navbar-toggler"
            type="button"
            data-mdb-toggle="collapse"
            data-mdb-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02"
            aria-expanded="false"
            aria-label="Toggle navigation"
            >
            <i class="fas fa-bars"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <!-- home link disable -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                <router-link :to="{name: 'createPost'}">
                    <p class="nav-link" aria-current="page">CreatePost</p>
                </router-link>
                </li>
                <li class="nav-item dropdown">
                    <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="navbarDropdownMenuLink"
                    role="button"
                    data-mdb-toggle="dropdown"
                    aria-expanded="false"
                    >
                    Category
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li v-for="category in categories" :key="category.id">
                            <a class="logout dropdown-item" @click.prevent="categoryName(category.name)">{{category.name}}</a>
                        </li> 
                        <li>
                            <a class="dropdown-item" @click.prevent="categoryName('all')">all</a>
                        </li>
                    </ul>
                </li>
                
            </ul>
            <!-- search -->
            <form class="d-flex input-group w-auto" @submit.prevent="searchPost">
                <input
                type="text"
                class="form-control"
                placeholder="Type query"
                v-model="search"
                />
                <button
                class="btn btn-outline-primary"
                type="submit"
                data-mdb-ripple-color="dark"
                
                >
                Search
                </button>
            </form>
            <!-- login register -->
            <ul class="navbar-nav ms-5 me-5 mb-2 mb-lg-0">
                <li class="nav-item" v-if="!loggedIn">
                    <router-link :to="{name: 'login'}">
                        <button type="button" class="btn btn-primary">
                            login
                        </button>
                    </router-link>
                    <router-link :to="{name: 'register'}">
                        <button type="button" class="btn btn-primary">
                            register
                        </button>
                    </router-link>
                </li>
                <li class="nav-item dropdown" v-else>
                    <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="navbarDropdownMenuLink"
                    role="button"
                    data-mdb-toggle="dropdown"
                    aria-expanded="false"
                    >
                    {{authUser}}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <a class="logout dropdown-item" @click.prevent="logoutUser">Logout</a>
                        </li>
                    </ul>
                </li>
            </ul>
            </div>
        </div>
        </nav>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data(){
        return{
            search: '',
            categories: {},
            authUser: '',
            token: localStorage.getItem('accessToken'),
        }
    },
    computed:{
        loggedIn(){
            return this.token !== null;
        },
        notLoggedIn(){
            return this.token == null;
        }
    },
    methods:{
        searchPost(){
            
            axios.get('http://127.0.0.1:8000/api/posts?search=' + this.search)
            .then((response) => {
                // console.log(response);
                this.$emit('posts' , response.data.data)
            })
            .catch((error) => {
                console.log(error);
            })
        },
        categoryName(value){
            this.$emit('filterBy', value)
        },
        getCategory(){
            axios.get('http://127.0.0.1:8000/api/categories')
            .then((response) => {
                this.categories = response.data.data;
            })
            .catch((error) => console.log(error));
            },
        getUser(){
            axios.get('/api/user', {
                headers: {
                    'Accept' : 'application/json',
                    'Authorization' : `Bearer ${this.token}`
                }
            })
            .then((response) => {
                this.authUser = response.data.name;
            })
        },
        logoutUser(){
            axios.post('api/logout', this.getUser(), {
                headers:{
                    'Accept' : 'application/json',
                    'Authorization' : `Bearer ${this.token}`
                }
            })
            .then((response) => {
                localStorage.clear();
                this.$router.push({name: 'login'});
            })
        }
    },
    created(){
        this.getUser();
        this.getCategory();
    },
}
</script>

<style>
    .logout{
        cursor: pointer;
        user-select: none;
    }
</style>