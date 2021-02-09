<template>
  <BasicLayout>
    Chat
    <div v-for="option in options" v-bind:key="option">
      <input type="radio" :id="option" :value="option" v-model="picked" />
      <label :for="option">{{ option }}</label>
      <br />
    </div>

    <span>Picked: {{ picked }}</span>
    <chatWindowd :isOpen="false"></chatWindowd>
  </BasicLayout>
</template>




<script>
import { mapActions, mapState } from "vuex";

import { MESSAGES_MODULE, FETCH_MESSAGES } from "@/store/messages";

import chatWindowd from "/resources/js/components/chatWindowd.vue";
//import Launcher from

import BasicLayout from "../Layouts/BasicLayout.vue";
import Paginate from "/resources/js/components/Paginate.vue";
import Button from "@/Jetstream/Button.vue";
import { MESSAGES, PAGINATION } from "../store/messages/state";

export default {
  components: { BasicLayout, chatWindowd, Button },
  data() {
    return {
      picked: null,
      isOpen: false,
      error: null,
      loading: false,
      promise: false,
      search: undefined,
      PublishedProduct: undefined,
      options: ["Server", "two"],
    };
  },
  computed: {
    products() {},
    ...mapState(MESSAGES_MODULE, {
      messages: MESSAGES,
      pagination: PAGINATION,
    }),
  },
  created() {
    this.fetchEmployees({ page: 1, limit: 20 });
  },
  methods: {
    ...mapActions(MESSAGES_MODULE, {
      fetchEmployees: FETCH_MESSAGES,
    }),
  },
  mounted() {
    const req = require.context(
      "../../../app/Events",
      false,
      /\.(php)$/i,
      "weak"
    );

    const channel = Echo.channel("messages");
    const eventsTolisten = req.keys().map((item) => item.slice(2, -4));
    eventsTolisten.push(".message");
    eventsTolisten.push(".newMessage");
    console.log(eventsTolisten);
    eventsTolisten.forEach((event) => {
      channel.listen(event, (e) => {
        console.log("window", event, e);
      });
    });
  },
};
</script>

