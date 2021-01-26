export default {
    methods: {
        /**
         * 
         * @param {Event } event - the Submit event form the dom
         * @param {Object.<string, *>} [form] - optional form data to replace the form data of the event itself
         * @returns {void}
         */
        submit(event, form) {
            const action = event.target.action;
            let method = 'get';
            if (event.target.hasAttribute('method')) {
                method = event.target.attributes.method.value ?? 'get';
            }
            if (!form) {
                // get the form data form the search parrams 
                form = Object.fromEntries(new URLSearchParams(
                    new FormData(event.target).entries()
                ));
            }
            this.$store.commit('sendingRequest', true);
            this.$inertia.visit(action, {
                method: method,
                data: form ?? {},
            },
            ).then((e) => {
                this.$store.commit('sendingRequest', false);
            });

        }
    }
}