<template>
  <ProductLayout>
    <product-edit class="m-3" :product="product" dusk="vue-product" />
  </ProductLayout>
</template>

<script>
import ProductLayout from "@/Layouts/ProductLayout";
import Welcome from "@/Jetstream/Welcome";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import ProductEdit from "/resources/js/components/ProductEdit";

export default {
  components: {
    JetResponsiveNavLink,
    ProductLayout,
    Welcome,
    ProductEdit,
  },
  props: {
    product: Object,
  },
};
</script>