export const MESSAGES = 'data'
export const USERS = 'users'
export const PAGINATION = 'pagination'
// import './defenitons';
import { Paginate as PaginateInterface } from './definitions'
export class Pagination extends PaginateInterface {
    page: number = 1;
    per_page: number = 10;
    path: string = "http://localhost/message";

}

export class State {
    [MESSAGES]: any[] = [];
    [PAGINATION]: Pagination = new Pagination();
    [USERS]: any[] = [];
}