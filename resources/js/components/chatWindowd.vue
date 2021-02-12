<template>
  <beautiful-chat
    :participants="participants"
    :titleImageUrl="chat.titleImageUrl"
    :onMessageWasSent="onMessageWasSent"
    :messageList="messageList"
    :newMessagesCount="chat.newMessagesCount"
    :close="closeChat"
    :isOpen="chat.chatOpen"
    :icons="chat.icons"
    :open="openChat"
    :showEmoji="true"
    :showFile="true"
    :showEdition="true"
    :showDeletion="true"
    :showTypingIndicator="chat.showTypingIndicator"
    :showLauncher="true"
    :showCloseButton="true"
    :colors="chat.colors"
    :alwaysScrollToBottom="chat.alwaysScrollToBottom"
    :messageStyling="chat.messageStyling"
    @onType="handleOnType"
    @edit="editMessage"
  />
</template>

<script>
import CloseIcon from "/resources/assets/close-icon.png";
import OpenIcon from "/resources/assets/logo-no-bg.svg";
import FileIcon from "/resources/assets/file.svg";
import CloseIconSvg from "/resources/assets/close.svg";
import { MESSAGES_MODULE, SEND_MESSAGE } from "@/store/messages";
import { mapActions, mapState } from "vuex";

export default {
  props: {
    messages: {
      type: Array,
    },
    users: {
      type: Array,
      required: true,
    },
    isChatOpen: {
      default: false,
    },
    userPicked: {},
  },
  computed: {
    participants() {
      let userIds = [
        ...new Set(this.messages.map((message) => message.from_user_id)),
      ];
      return userIds.map((id) => {
        return {
          id: id ?? 1,
          name: this.users[id]?.["name"] ?? "Unkown",
          imageUrl: this.users[id]?.["profile_photo_url"] ?? "",
        };
      });
    },
    messageList() {
      return this.messages.map((ellement) => {
        return {
          type: "text",
          author: ellement.from_user_id,
          data: {
            text: ellement.message,
          },
        };
      });
    },
  },
  data() {
    return {
      chat: {
        icons: {
          open: {
            img: OpenIcon,
            name: "default",
          },
          close: {
            img: CloseIcon,
            name: "default",
          },
          file: {
            img: FileIcon,
            name: "default",
          },
          closeSvg: {
            img: CloseIconSvg,
            name: "default",
          },
        },
        titleImageUrl:
          "https://a.slack-edge.com/66f9/img/avatars-teams/ava_0001-34.png",
        chatOpen: true,
        newMessagesCount: 1,
        closeChat: false,
        showTypingIndicator: "",
        colors: {
          header: {
            bg: "#4e8cff",
            text: "#ffffff",
          },
          launcher: {
            bg: "#4e8cff",
          },
          messageList: {
            bg: "#ffffff",
          },
          sentMessage: {
            bg: "#4e8cff",
            text: "#ffffff",
          },
          receivedMessage: {
            bg: "#eaeaea",
            text: "#222222",
          },
          userInput: {
            bg: "#f4f7f9",
            text: "#565867",
          },
        }, // specifies the color scheme for the component
        alwaysScrollToBottom: false, // when set to true always scrolls the chat to the bottom when new events are in (new message, user starts typing...)
        messageStyling: true, //
      },
    };
  },
  methods: {
    ...mapActions(MESSAGES_MODULE, {
      vuexSendMessage: SEND_MESSAGE,
    }),
    sendMessage(text) {
      if (text.length > 0) {
        this.newMessagesCount = this.isChatOpen
          ? this.newMessagesCount
          : this.newMessagesCount + 1;
        this.onMessageWasSent({
          author: "support",
          type: "text",
          data: { text },
        });
      }
    },
    onMessageWasSent(message) {
      // called when the user sends a message
      message["to_user_id"] = this.userPicked;
      console.log(message);
      this.vuexSendMessage(message);
    },
    openChat() {
      // called when the user clicks on the fab button to open the chat
      this.chat.chatOpen = true;
      this.newMessagesCount = 0;
    },
    closeChat() {
      // called when the user clicks on the botton to close the chat
      this.chat.chatOpen = false;
    },
    handleScrollToTop() {
      // called when the user scrolls message list to top
      // leverage pagination for loading another page of messages
    },
    handleOnType() {
      console.log("Emit typing event");
    },
    editMessage(message) {
      const m = this.messageList.find((m) => m.id === message.id);
      m.isEdited = true;
      m.data.text = message.data.text;
    },
  },
};
</script>

<style>
</style>