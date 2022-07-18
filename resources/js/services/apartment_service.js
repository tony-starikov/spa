import {http, httpFile} from "./http_service";

export function createApartment(data) {
    return httpFile().post('/apartments', data);
}

export function updateApartment(id, data) {
    return httpFile().post(`/apartments/${id}`, data);
}

export function loadAllApartment() {
    return http().get('/apartments');
}

export function loadAllApartmentPaginate(page = 1) {
    return http().get('/apartments?page=' + page);
}

export function deleteApartment(id) {
    return http().delete(`/apartments/${id}`);
}
