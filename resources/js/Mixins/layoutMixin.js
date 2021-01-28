export default {
    beforeMount() {
        console.log("InitTheStoreWIthPageData")
        if (this.$page.PublishedProductApi) {
            this.$page
            Object.keys(this.$page).forEach(key => {
                switch (key) {
                    case 'PublishedProductApi':
                        console.log("set PublishedProductApi");
                        this.$store.commit('setInitState', { key: key.slice(0, -3), data: this.$page[key] })
                        break;

                    default:
                        break;
                }
            });

        }
        else {
            console.log('We dont have a ');

        }

    }

}