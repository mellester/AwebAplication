<template>
  <table class="mtable divide-y">
    <thead>
      <tr>
        <th></th>
        <th>Name</th>
        <th>Cost</th>
        <th>Weight</th>
        <th>Source</th>
      </tr>
    </thead>

    <product-modal
      class="border"
      v-for="product in productlist"
      :key="product['data'].key"
      :product="product"
    />
  </table>
</template>

<script>
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import * as Status from "/resources/js/enums/productStatus.js";

export default {
  components: {
    JetResponsiveNavLink,
  },
  props: {
    productlist: {
      type: Array,
      required: true,
    },
  },
};
</script>

<style   scoped>
</style>