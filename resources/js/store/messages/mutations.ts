export const SET_PAGINATION = 'set_pagination'
export const SET_DATA = 'set_data'
export const SET_DATA_USERS = 'set_data_users'

export default {
    [SET_PAGINATION](state, pagination) {
        state.pagination = pagination
    },

    [SET_DATA](state, data) {
        state.data = data
    },
    [SET_DATA_USERS](state, data) {
        state.users = data
    },
}