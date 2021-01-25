import * as Duration from "/resources/js/enums/Duration.js";

export default {

    methods: {
        hasErrors(bag) {
            return this.$page.errorBags[bag] && Object.keys(this.$page.errorBags[bag]).length > 0;
        },

        errorFor(key, bag = 'default') {
            if (!this.hasErrors(bag) || !this.$page.errorBags[bag][key] || this.$page.errorBags[bag][key].length == 0) {
                return;
            }

            return this.$page.errorBags[bag][key][0];
        },
        hasSuccess() {
            return this.$page.flash['success'];
        },
        /**
         * A helper fucntion to detrimne a date in th future is valid
         * @param {*} optionsC 
         * @param {*} time 
         */
        offerValid(optionsC, time = null) {
            let date = new Date();
            if (time != null)
                date = new Date(time);
            const toAdd = parseInt(optionsC.timeData[0]);
            // console.log(date, this.optionsC.timeData[1], date.getHours());
            switch (optionsC.timeData[1]) {
                case Duration.Hour:
                    date.setHours(parseInt(date.getHours()) + toAdd);
                    break;
                case Duration.Month:
                    date.setMonth(date.getMonth() + toAdd);
                    break;
                case Duration.Week:
                    date.setDate(date.getDate() + toAdd * 7);
                    break;
                case Duration.Day:
                    date.setDate(date.getDate() + toAdd);
                    break;
            }
            return date.toLocaleString("en-gb");
        },
    },

};
