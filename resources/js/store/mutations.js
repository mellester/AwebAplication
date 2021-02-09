/** Calc the distance a product is removed from a user */
function setDistance(key, state) {
    let array = state[key]?.data;
    if (typeof array != [])
        return;
    let user = state.user;
    debugger;
    array;
}

export default {
    sendingRequest(state, boolean) {
        state.sendingRequest = boolean;
    },
    /**
     * 
     * @param {*} state 
     * @param {*} payload 
     * @param {*} payload.user the user object
     */
    userLocation(state, payload) {
        state.userLocation = payload;

    },
    SET_CHANNEL_LISTENING(state, payload) {
        state.channel_listening = payload;

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
            state[key] = {};
        }
        if (state[key].data == null) {
            state[key].data = [];
        }
        let dirty = false;
        payload.data?.data.forEach(element => {
            dirty = true;
            let index = state[key].data.findIndex((value => value.id == element.id))
            if (index != -1) {
                state[key].data[index] = (element);
            }
            else {
                // push the new ellemnt to the end of the array
                index = state[key].data.length;
                state[key].data.push(element);
            }


        });
        if (state.user && dirty) {
            setDistance(key, state);
        }


        state[key].Api = payload.data;
        // state[key].pagesRetrieved.add(payload.data.current_page);
    },
};