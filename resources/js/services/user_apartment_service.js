import {httpWithAuth, httpFile} from "./http_service";

export function createAdminApartment(data) {
    return httpFile().post('/user/apartments', data);
}

export function loadAdminAllApartmentPaginate(page = 1) {
    return httpWithAuth().get('/user/apartments?page=' + page);
}

export function updateAdminApartment(id, data) {
    return httpFile().post(`/user/apartments/${id}`, data);
}

export function deleteAdminApartment(id) {
    return httpWithAuth().delete(`/user/apartments/${id}`);
}
