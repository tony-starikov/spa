import {http, httpFile} from "./http_service";

export function createApartment(data) {
    return httpFile().post('/apartments', data);
}
