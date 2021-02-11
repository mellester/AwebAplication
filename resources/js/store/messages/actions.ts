import api from '/resources/js/Mixins/services'
import {
    SET_DATA,
    SET_PAGINATION,
    SET_DATA_USERS,
} from './mutations'
import { State } from './state'

export const FETCH_MESSAGES = 'fetch_messages'

export default {
    /**
     * 
     * @param param0 
     * @param payload 
     */
    async [FETCH_MESSAGES](context, payload) {
        const data = await api.fetchMessages({
            ...context.state.pagination,
            ...payload,
        })

        context.commit(SET_DATA, data.data)

        context.commit(SET_PAGINATION, {
            page: data.page,
            limit: data.limit,
            totalPages: data.totalPages,
        })
        console.log(context, 'context');
        let userIds = [
            ...new Set(context.state.data.map((message) => message.from_user_id)),
        ];
        const dataUsers = await api.fetchUsers(
            userIds
        );
        context.commit(SET_DATA_USERS, dataUsers.data);

        return data.data;
    },
}