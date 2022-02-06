<template>
    <div>
        <Navbar></Navbar>
        <Posts></Posts>
    </div>
</template>

<script>
import Posts from '../tools/Posts'
import Navbar from "../tools/Navbar";
export default {
    components: {
    Posts, Navbar },
    data() {
        return {
            authName: localStorage.getItem("authName"),
            token: localStorage.getItem("accessToken"),
            loggedin: localStorage.getItem('loggedin')
        };
    },
    created(){
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
    },
};
</script>

<style></style>
