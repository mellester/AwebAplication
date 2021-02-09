import actions from './action-types'
import { notifyMe } from '../helpers'
import { AxiosInstance } from "axios";
import Echo from "laravel-echo";

declare global {
    /*~ Here, declare things that go in the global namespace, or augment
     *~ existing declarations in the global namespace
     */
    var axios: AxiosInstance;
    var Echo: Echo;
}

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
            const result = await axios.get(url.href);
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
                    .get(url.href)
                    .then((result) => context.commit("setInitState",
                        { data: result.data, key: key })));
            }
            await Promise.all(promises);
            return;
        } finally {
            context.commit("sendingRequest", false);

        }
    },
    [actions.INIT_CHANNEL_LISTENERS](context) {
        console.log('Initializing channel listeners...')
        context.commit('SET_CHANNEL_LISTENING', true)
        let channels: Array<any> = context.state.notifiable_public_channels;
        if (channels instanceof Array)
            channels.forEach(listener => {
                context.dispatch(actions.INIT_PUBLIC_NOTIFIABLE_CHANNEL_LISTENER, listener)
            })
        else {
            console.warn("notifiable_public_channels could not be reached");
            debugger;
        }
    },
    /**
     * 
     * @param context 
     * @param listener 
     */
    [actions.INIT_PUBLIC_NOTIFIABLE_CHANNEL_LISTENER](context, listener: { channel: string, event: string }) {
        console.log(`listing to ${(listener.channel)} on ${listener.event} `);
        (window.Echo as any)?.channel(listener.channel as string).listen(listener.event as string, payload => {
            console.log(payload);

            console.log(payload.message, payload.title);
            notifyMe(payload.message, payload.title)
        })
    }


}