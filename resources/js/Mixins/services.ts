import { Paginate } from "../store/messages/definitions";

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
}