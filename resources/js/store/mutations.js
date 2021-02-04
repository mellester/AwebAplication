export default {
    sendingRequest(state, boolean) {
        state.sendingRequest = boolean;
    },
    /**
     * 
     * @param {String} key The key in the store to set 
     * @param {Object} payload 
     * @param {string} payload.key - The key in the store 
     * @param {Object} payload.data - The Paginate Info
     */
    setInitState(state, payload) {
        const key = payload.key;
        if (state[key] == null) {
            state[key].data = payload.data.data;
        }
        else {
            payload.data.data.forEach(element => {
                let index = state[key].data.findIndex((value => value.id == element.id))
                if (index == -1) {
                    state[key].data.push(element);
                }
                else {
                    state[key].data[index] = (element);
                }
            });
        }
        state[key].Api = payload.data;
        state[key].pagesRetrieved.add(payload.data.current_page);
    },
};