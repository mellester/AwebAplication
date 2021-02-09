export const MESSAGES = 'data'
export const PAGINATION = 'pagination'
// import './defenitons';
import { Paginate as PaginateInterface } from './definitions'
export class Pagination extends PaginateInterface {
    page: number = 1;
    per_page: number = 10;
    path: string = "http://localhost/message";

}

export default {
    [MESSAGES]: [],
    [PAGINATION]: new Pagination(),
}