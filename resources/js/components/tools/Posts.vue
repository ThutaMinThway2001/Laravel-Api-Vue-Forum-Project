<template>
    <div class="container">
        <div class="row">
            <div
                class="col-md-3 mt-3"
                v-for="(post, index) in filterByName"
                :key="post.id"
            >
                <div class="card text-center">
                    <div class="card-header bg-success text-light flexing">
                        <div>
                            <router-link
                                :to="{
                                    name: 'singlePost',
                                    params: { id: post.id },
                                }"
                            >
                                <p class="text-white pt-3">
                                    {{ post.title }}
                                </p>
                            </router-link>
                        </div>
                        <div>
                            <p class="pt-3">{{ post.created_at | myDate }}</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            {{ post.detail }}
                        </p>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="flexing">
                            <div class="item">
                                <!-- Before Like -->
                                <span
                                    ><i
                                        class="far fa-heart"
                                        v-if="post.likes.length == 0"
                                        @click.prevent="like(post.id, index)"
                                    ></i
                                ></span>
                                <!-- After Like -->
                                <span
                                    ><i
                                        class="fas fa-heart"
                                        v-if="post.likes.length > 0"
                                        @click.prevent="like(post.id, index)"
                                    ></i
                                ></span>
                                <span>{{post.likes.length}}</span>
                            </div>
                            <div class="item">
                                {{ post.category.name }}
                            </div>
                            <div class="item">
                                {{ post.author.name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    props: ["filterByName"],
    data() {
        return {
            likeCount: '',
            token: localStorage.getItem("accessToken"),
            posts: [],
        };
    },
    methods: {
        like(id, index) {
            
            axios
                .post(
                    "http://127.0.0.1:8000/api/likes",
                    {
                        post_id: id,
                    },
                    {
                        headers: {
                            Accept: "application/json",
                            Authorization: "Bearer " + this.token,
                        },
                    }
                )
                .then((response) => {
                    window.location.reload()
                })
                .catch((error) => console.log(error.response.data));
        },
        getPosts() {
            axios
                .get("/api/posts")
                .then((response) => {
                    this.posts = response.data.data;
                })
                .catch((err) => console.log(err));
        },
    },
    created() {
        this.getPosts();
    },
};
</script>

<style>
.flexing {
    display: flex;
    justify-content: space-between;
}
</style>
