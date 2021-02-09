import api from '/resources/js/Mixins/services'
import {
    SET_DATA,
    SET_PAGINATION,
} from './mutations'
import state from './state'

export const FETCH_MESSAGES = 'fetch_messages'

export default {
    /**
     * 
     * @param param0 
     * @param payload 
     */
    async [FETCH_MESSAGES]({ commit }, payload) {
        const data = await api.fetchMessages({
            ...state.pagination,
            ...payload,
        })

        commit(SET_DATA, data.data)
        commit(SET_PAGINATION, {
            page: data.page,
            limit: data.limit,
            totalPages: data.totalPages,
        })
    },
}