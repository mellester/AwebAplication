export default {
    PublishedProduct: {
        Api: null,
        data: [],
        pagesRetrieved: new Set(),
    },
    sendingRequest: false,
    myResources: {
        contacts: [
            {
                // id is required for each record
                id: '1',
                address: '1 Hacker Way, Menlo Park',
                name: 'Dr. Katrina Stehr',
            },
            {
                id: '2',
                address: '06176 Georgiana Points',
                name: 'Edyth Grimes',
            },
        ],
    },
}

