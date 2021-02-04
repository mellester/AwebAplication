<template>
  <component :is="layout">
    <product-show class="m-3" :product="product" dusk="vue-product" />
  </component>
</template>

<script>
import ProductLayout from "@/Layouts/ProductLayout";
import BasicLayout from "@/Layouts/BasicLayout";
import Welcome from "@/Jetstream/Welcome";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import ProductShow from "/resources/js/components/ProductShow";

export default {
  components: {
    JetResponsiveNavLink,
    ProductLayout,
    Welcome,
    ProductShow,
  },
  data() {
    return {
      layout: this.$page.props.user ? ProductLayout : BasicLayout,
    };
  },
  props: {
    product: Object,
  },
};
</script>