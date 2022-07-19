import Vue from 'vue';
import Router from 'vue-router';
import Main from "./views/Main";
import About from "./views/About";
import Apartments from "./views/Apartments";
import Register from "./views/autentication/Register";
import Login from "./views/autentication/Login";
import ResetPassword from "./views/autentication/ResetPassword";

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
    },
    {
        path: '/apartments',
        name: 'apartments',
        component: Apartments
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/reset-password',
        name: 'reset-password',
        component: ResetPassword
    },
]

const router = new Router({
    mode: 'history',
    hash: false,
    linkActiveClass: 'active',
    routes: routes
})

export default router;
