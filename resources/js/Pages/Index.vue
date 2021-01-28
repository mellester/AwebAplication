<template>
  <BasicLayout>
    <productOffer
      v-for="(product, key) in products"
      :key="key"
      :product="product"
      class="m-2"
    />
  </BasicLayout>
</template>


<script>
import Welcome from "@/Jetstream/Welcome";

import BasicLayout from "../Layouts/BasicLayout.vue";
import productOffer from "/resources/js/components/productOffer.vue";

export default {
  data() {
    return {
      isOpen: false,
      error: null,
      loading: false,
    };
  },
  components: { BasicLayout, productOffer },
  props: {
    PublishedProductApi: {
      type: Object,
    },
  },
  computed: {
    products() {
      return this.PublishedProductApi?.data ?? [];
    },
  },
  methods: {
    scroll() {
      window.onscroll = () => {
        let bottomOfWindow =
          document.documentElement.scrollTop + window.innerHeight ===
          document.documentElement.offsetHeight;

        if (bottomOfWindow) {
          console.log("bottomOfWindow");
          this.$store
            .dispatch("load", "PublishedProductApi")
            .then(() => (this.isBusy = false))
            .catch(() => {
              this.error = "Failed to load data";
              console.log(this.error);
            })
            .finally(() => (this.isBusy = false));
        }
      };
    },
  },
  mounted() {
    this.scroll();
  },
};
</script>

