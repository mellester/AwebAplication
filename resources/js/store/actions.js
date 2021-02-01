import { cond } from "lodash";

export default {
    async load(context, key) {
        if (context.state[key].next_page_url == null) {
            return;
        }
        var result = await axios.get(context.state[key].next_page_url);
        return context.commit("setInitState", { data: result.data, key: key.slice(0, -3) });
    },
    async loadAll(context, key) {
        const last = context.state[key].last_page
        let itter = context.state[key].current_page;
        let promises = [];
        const base = window.location.protocol + '//' + window.location.hostname + ":" + window.location.port;

        while (++itter <= last) {
            console.log(itter, last);
            let url = new URL(context.state[key].next_page_url, base);
            url.searchParams.set('page', itter);
            promises.push(axios
                .get(url)
                .then((result) => context.commit("setInitState",
                    { data: result.data, key: key.slice(0, -3) })));
        }
        await Promise.all(promises);
        return;
    }

}