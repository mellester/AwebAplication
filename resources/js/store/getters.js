import { haversine_distance } from "/resources/js/libary.js";

export default {
    sortByDistance: (state) => (ArrayOrKey) => {
        let toBeSorted; //
        //check if we got a string or a array
        if (typeof ArrayOrKey != typeof "string") {
            // ArrayOrKey is of type array lets sort that one
            toBeSorted = ArrayOrKey;
        }
        else {
            // lets try and retrieve a array from the store
            toBeSorted = state[ArrayOrKey].data ?? [];
        }
        if (state.userLocation == null) {
            // we have no location data to sort by
            return toBeSorted;
        }
        toBeSorted.forEach((product) => {
            product.distance = haversine_distance(product?.owner?.location, state.userLocation);
        });
        toBeSorted.sort((lhs, rhs) => parseFloat(lhs.distance) - parseFloat(rhs.distance));
        return toBeSorted;
    },
    doneTodos: state => {
        return state.todos.filter(todo => todo.done)
    }
}