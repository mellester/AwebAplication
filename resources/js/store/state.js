

export default {
  PublishedProduct: {
    Api: null,
    data: [],
    pagesRetrieved: new Set(),
  },
  sendingRequest: false,
  channel_listening: false,
  notifiable_public_channels: [
    {
      channel: 'messages',
      event: '.message'
    }
  ],
}

