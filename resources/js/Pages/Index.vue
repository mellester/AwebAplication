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
    };
  },
  components: { BasicLayout, productOffer },
  props: {
    productsPaginate: {
      type: Object,
    },
  },
  computed: {
    products() {
      return this.productsPaginate?.data ?? [];
    },
  },
};
</script>

