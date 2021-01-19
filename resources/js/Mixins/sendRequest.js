export default {
    methods: {
        submit(event, form) {
            const action = event.srcElement.action;
            let method = 'get';
            if (event.srcElement.hasAttribute('method')) {
                method = event.srcElement.attributes.method.value ?? 'get';
            }
            this.$inertia.visit(action, {
                method: method,
                data: form ?? {},
            });
        }
    },
};