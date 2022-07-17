import Vue from 'vue';
import Router from 'vue-router';
import Main from "./views/Main";
import About from "./views/About";

Vue.use(Router);

const routes = [
    {
        path: '/',
        name: 'main',
        component: Main
    },
    {
        path: '/about',
        name: 'about',
        component: About
    }
]

const router = new Router({
    mode: 'history',
    hash: false,
    linkActiveClass: 'active',
    routes: routes
})

export default router;
