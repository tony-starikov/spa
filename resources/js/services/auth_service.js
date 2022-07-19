import {http, httpFile} from "./http_service";

export function register(user) {
    return http().post('/auth/register', user);
}
