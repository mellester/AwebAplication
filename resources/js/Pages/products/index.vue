<template>
  <ProductLayout>

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
    productinfo: Object,
  },
};
</script>