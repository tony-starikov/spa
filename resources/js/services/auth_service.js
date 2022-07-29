import {http, httpFile, httpWithAuth} from "./http_service";
import jwt from 'jsonwebtoken';
import store from "../store";

export function register(user) {
    return http().post('/auth/register', user);
}

export function login(user) {
    return http().post('/auth/login', user)
        .then(response => {
            if (response.status === 200) {
                setToken(response.data);
            }

            return response.data;
        });
}

function setToken(user) {
    const token = jwt.sign({ user: user }, 'key');
    localStorage.setItem('laravel-spa', token);
    store.dispatch('authenticate', user.user);
}

export function isLoggedIn() {
    const token = localStorage.getItem('laravel-spa');
    return token != null;
}

export function logout() {
    if (isLoggedIn()) {
        const response = httpWithAuth().get('/auth/logout');
        localStorage.removeItem('laravel-spa');
    }
}

export function getAccessToken() {
    const token = localStorage.getItem('laravel-spa');

    if (!token) {
        return null
    }

    const tokenData = jwt.verify(token, 'key');

    return tokenData.user.access_token;
}

export function getUserRole() {
    const token = localStorage.getItem('laravel-spa');

    if (!token) {
        return null
    }

    const tokenData = jwt.verify(token, 'key');

    return tokenData.user.user.role;
}

export function getProfile() {
     return httpWithAuth().get('/auth/profile');
}

export function resetPasswordRequest(user) {
    return http().post('/auth/reset-password-request', user);
}

export function resetPassword(user) {
    return http().post('/auth/reset-password', user);
}
