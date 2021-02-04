<template>
  <BasicLayout>
    Chat
    <Button>Sever </Button>
    <chatWindowd :isOpen="false"></chatWindowd>
  </BasicLayout>
</template>




<script>
import chatWindowd from "/resources/js/components/chatWindowd.vue";
//import Launcher from

import BasicLayout from "../Layouts/BasicLayout.vue";
import Paginate from "/resources/js/components/Paginate.vue";
import Button from "@/Jetstream/Button.vue";

export default {
  components: { BasicLayout, chatWindowd, Button },
  data() {
    return {
      isOpen: false,
      error: null,
      loading: false,
      promise: false,
      search: undefined,
      PublishedProduct: undefined,
    };
  },
  computed: {
    products() {},
  },
  methods: {},
  mounted() {
    const req = require.context(
      "../../../app/Events",
      false,
      /\.(php)$/i,
      "weak"
    );
    const channel = Echo.channel("messages");
    const eventsTolisten = req.keys().map((item) => item.slice(2, -4));
    eventsTolisten.push(".event");
    eventsTolisten.push(".newMessage");
    console.log(eventsTolisten);
    eventsTolisten.forEach((event) => {
      channel.listen(event, (e) => {
        console.log(event, e);
      });
    });
  },
};
</script>

