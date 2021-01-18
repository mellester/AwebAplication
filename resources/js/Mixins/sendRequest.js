export default {
    methods: {
        submit(event, form) {
            const action = event.srcElement.action;
            const method = event.srcElement.method ?? 'get';
            this.$inertia.visit(action, {
                method: method,
                data: form ?? {},
            });
        }
    },
};