<template>
  <BasicLayout>
    Chat
    <div v-for="user in users" v-bind:key="user.id">
      <input type="radio" :id="user.id" :value="user.id" v-model="picked" />
      <label :for="user.id">{{ user.name }}</label>
      <br />
    </div>

    <span>Picked: {{ picked }}</span>
    <chatWindowd
      :users="userData"
      :messages="messagesPicked"
      :userPicked="picked"
      :isOpen="false"
    ></chatWindowd>
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
import { MESSAGES, PAGINATION, USERS } from "../store/messages/state";

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
      users: USERS,
    }),
    messagesPicked() {
      return this.messages.filter((message) => {
        return message.from_user_id == this.picked;
      });
    },
    userData() {
      return this.users.map((user) => {
        return {
          id: user.id ?? 1,
          name: user["name"] ?? "Unkown",
          imageUrl: user["profile_photo_url"] ?? "",
        };
      });
    },
  },
  created() {},
  methods: {
    ...mapActions(MESSAGES_MODULE, {
      fetchMessages: FETCH_MESSAGES,
    }),
    refres_messages() {
      let promise = this.fetchMessages({ page: 1, limit: 20 });
      this.loading = true;
      promise
        .then(() => {
          console.log("Test");
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
  mounted() {
    this.refres_messages();
  },
};
</script>

