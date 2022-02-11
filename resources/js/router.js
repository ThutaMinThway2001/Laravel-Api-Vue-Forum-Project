import Vue from 'vue';
import VueRouter from 'vue-router';
import HomeComponent from './components/views/Home'
import LoginComponent from './components/session/Login'
import RegisterComponent from './components/register/Register'
import SinglePostComponent from './components/tools/SinglePost'
import CreatePostComponent from './components/views/CreatePost'
import UpdatePostComponent from './components/views/UpdatePost'
import AdminComponent from './components/admin/Index'

Vue.use(VueRouter);

const router =  new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeComponent
        },
        {
            path: '/posts/:id',
            name: 'singlePost',
            component: SinglePostComponent,
            props: true,
        },
        {
            path: '/create',
            name: 'createPost',
            component: CreatePostComponent
        },
        {
            path: '/update/post/:id',
            name: 'updatePost',
            component: UpdatePostComponent,
            props: true
        },
        {
            path: '/login',
            name: 'login',
            component: LoginComponent
        },
        {
            path: '/register',
            name: 'register',
            component: RegisterComponent
        },
        {
            path: '/admin',
            name: 'admin',
            component: AdminComponent
        }
    ]
})

router.beforeEach((to, from, next) => {
    if(to.path === '/login' || to.path === '/register'){
        let accessToken = localStorage.getItem('accessToken');
        if(!accessToken){
            next();
        }else{
            next('/');
        }
    }

    if(to.path === '/admin'){
        let isAdmin = localStorage.getItem('isAdmin');
        if(isAdmin == 0){
            next('/');
        }else{
            next();
        }
    }

    next();
})

export default router;