<template>
  <ProductLayout>
    <product-show class="m-3"
    :product="product"/>
  </ProductLayout>
</template>

<script>
import ProductLayout from "@/Layouts/ProductLayout";
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
  props: {
    product: Object,
  },
};
</script>