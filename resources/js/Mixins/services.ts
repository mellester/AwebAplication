import { Paginate } from "../store/messages/definitions";
import route from "../../../vendor/tightenco/ziggy/src/js/index";
interface ZiggyObject {
    route: Function,
}
declare var Ziggy: ZiggyObject;

export default {
    async fetchMessages(pagination: Paginate) {
        let page = (pagination as any).page;
        if (page == undefined)
            page = 1;
        if (typeof pagination.path !== 'string') {
            console.error("pagination did not provide a path")
        }
        let endpoint = new URL(pagination.path)
        const instance = window.axios;
        if (pagination.current_page) {
            endpoint.searchParams.set('page', page.toString())
        }

        if (pagination.per_page) {
            endpoint.searchParams.set('per_page', page.toString())
        }
        endpoint.port = window.location.port;
        return (await instance.get(endpoint.href)).data
    },
    async fetchUsers(ids: Number[]) {
        let endpoint = new URL(window.location.href);
        const z = Ziggy;
        // @ts-ignore 
        let idsString = JSON.stringify(ids);
        endpoint.pathname = route('getResourceCollection', [], false);
        endpoint.searchParams.set('resourceName', 'user');
        endpoint.searchParams.set('resourceIds', idsString);
        console.log(endpoint.href);
        const instance = window.axios;

        return (await instance.get(endpoint.href)).data

    }
}