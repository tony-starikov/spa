import {http, httpFile} from "./http_service";

export function createApartment(data) {
    return httpFile().post('/apartments', data);
}

export function loadAllApartment() {
    return http().get('/apartments');
}

export function deleteApartment(id) {
    return http().delete(`/apartments/${id}`);
}
