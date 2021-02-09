//https://whatthecode.dev/easy-vuejs-vuex-pagination/#:~:text=Modules%20in%20Vuex%20are%20used,of%20concerns%20and%20easier%20management.&text=We%20will%20store%20the%20data,to%20manage%20the%20pagination%20options.
import state from './state'
import actions from './actions'
import mutations from './mutations'
import { dispatch } from 'rxjs/internal/observable/pairs'

export const MESSAGES_MODULE = 'messages'

export default {
    namespaced: true,
    state,
    actions,
    mutations,
    getters: 

    
}

export * from './state'
export * from './actions'
export * from './mutations'