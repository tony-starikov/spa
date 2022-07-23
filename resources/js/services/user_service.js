import {http, httpWithAuth} from "./http_service";

export function userScope() {
    return httpWithAuth().get('/user/user-page');
}

export function adminScope() {
    return httpWithAuth().get('/user/admin-page');
}
