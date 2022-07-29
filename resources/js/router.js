import Vue from 'vue';
import Router from 'vue-router';
import Main from "./views/Main";
import About from "./views/About";
import Error404 from "./views/Error404";
import Register from "./views/autentication/Register";
import Login from "./views/autentication/Login";
import ResetPassword from "./views/autentication/ResetPassword";
import * as auth from "./services/auth_service";
import AdminApartments from "./views/admin/AdminApartments";
import Admin from "./views/admin/Admin"
import UserApartments from "./views/user/UserApartments";
import User from "./views/user/User"

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
        path: '/register',
        name: 'register',
        component: Register,
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next();
            } else {
                next('/');
            }
        }
    },
    {
        path: '/reset-password',
        name: 'reset-password',
        component: ResetPassword
    },
    {
        path: '*',
        name: 'Error404',
        component: Error404
    },
    {
        path: '/admin',
        name: 'admin',
        component: Admin,
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next('/login');
            } else {
                console.log(auth.getUserRole())
                if (auth.getUserRole() === 'admin') {
                    next();
                } else {
                    next('/404');
                }
            }
        },
        children: [
            {
                path: 'apartments',
                name: 'admin-apartments',
                component: AdminApartments,
            },
        ],
    },
    {
        path: '/user',
        name: 'user',
        component: User,
        beforeEnter(to, from, next) {
            if (!auth.isLoggedIn()) {
                next('/login');
            } else {
                console.log(auth.getUserRole())
                if (auth.getUserRole() === 'user') {
                    next();
                } else {
                    next('/404');
                }
            }
        },
        children: [
            {
                path: 'apartments',
                name: 'user-apartments',
                component: UserApartments,
            },
        ],
    },
]

const router = new Router({
    mode: 'history',
    hash: false,
    linkActiveClass: 'active',
    routes: routes
})

export default router;
