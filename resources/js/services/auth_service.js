import {http, httpFile} from "./http_service";
import jwt from 'jsonwebtoken';

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
    localStorage.setItem('laravel-spa', JSON.stringify(token));
}


export function isLoggedIn() {
    const token = localStorage.getItem('laravel-spa');
    return token != null;
}
