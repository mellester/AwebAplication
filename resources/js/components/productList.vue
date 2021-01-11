<template>
<div class="flex flex-col flex-grow p-3">
    <div class="product-list">   
        <button>Name</button>
        <button>Cost</button>
        <button>Weight</button>
        <button>Source</button>
    </div>
    <div class="product-list min-w-3 p-1"  v-for="product in productlist['data']" :key="product['data'].key">
      <product-modal :product="product"/>
    </div>
  </div>
</template>

<script>
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
export default {
  components: {
    JetResponsiveNavLink,
  },
  props: {
    productlist: { 
        type: Object,
        required: true },
  },
};
</script>

<style scoped>

table {
  max-width: 100em;
}
td:nth-child(1) {
  min-width: 10em;
}
td:nth-child(2) {
  text-align: end;
}
</style>