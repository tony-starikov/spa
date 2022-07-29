import {httpWithAuth, httpFile} from "./http_service";

export function createAdminApartment(data) {
    return httpFile().post('/admin/apartments', data);
}

export function loadAdminAllApartmentPaginate(page = 1) {
    return httpWithAuth().get('/admin/apartments?page=' + page);
}

export function updateAdminApartment(id, data) {
    return httpFile().post(`/admin/apartments/${id}`, data);
}

export function deleteAdminApartment(id) {
    return httpWithAuth().delete(`/admin/apartments/${id}`);
}
