<template>
  <ProductLayout>
    <product-list :productlist="productlist" dusk="vue-product" />
  </ProductLayout>
</template>

<script>
import ProductLayout from "@/Layouts/ProductLayout";
import Welcome from "@/Jetstream/Welcome";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
export default {
  components: {
    JetResponsiveNavLink,
    ProductLayout,
    Welcome,
  },
  props: {
    productlist: Object,
  },
};
</script>