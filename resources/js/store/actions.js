import { cond } from "lodash";

export default {
    async load(context, { key, page = null }) {
        //let { key, page } = payload;
        const base = window.location.protocol + '//' + window.location.hostname + ":" + window.location.port;
        context.commit("sendingRequest", true);
        try {
            // debugger;
            let url = new URL(context.state[key].Api.path, base);
            if (page != null) {
                // if (!context.state[key].pagesRetrieved.has(pageNum))
                url.searchParams.set('page', page)
                // else
                //     return;
            }
            else {
                if (context.state[key]?.Api?.next_page_url == null) {
                    // debugger; // we are on the last page 
                    return;
                }
                else {
                    url.href = context.state[key]?.Api?.next_page_url;
                }
            }
            const result = await axios.get(url);
            // debugger;
            return context.commit("setInitState", { data: result.data, key: key });
        } finally {
            context.commit("sendingRequest", false);
        }
    },
    async loadAll(context, key) {
        const last = context.state[key].Api.last_page
        let itter = context.state[key].Api.current_page;
        let promises = [];
        const base = window.location.protocol + '//' + window.location.hostname + ":" + window.location.port;
        context.commit("sendingRequest", true);
        try {
            while (++itter <= last) {
                console.log(itter, last);
                let url = new URL(context.state[key].Api.next_page_url, base);
                url.searchParams.set('page', itter);
                promises.push(axios
                    .get(url)
                    .then((result) => context.commit("setInitState",
                        { data: result.data, key: key })));
            }
            await Promise.all(promises);
            return;
        } finally {
            context.commit("sendingRequest", false);

        }
    }

}