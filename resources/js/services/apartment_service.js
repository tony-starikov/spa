import {http, httpFile} from "./http_service";

export function loadAllApartment() {
    return http().get('/apartments');
}

export function loadAllApartmentPaginate(page = 1) {
    return http().get('/apartments?page=' + page);
}
