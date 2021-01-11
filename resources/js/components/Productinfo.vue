<template>
  <div>
    <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
      <div class="mt-8 text-xl">Your product information</div>
      <div class="mt-6 text-gray-500">
        <table class="table-auto">
          <tbody class="table-auto">
            <tr>
              <td>productsPublished</td>
              <td>{{ productinfo["productsPublished"] }}</td>
            </tr>
            <tr>
              <td>productsTotal</td>
              <td>{{ productinfo["productsTotal"] }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="p-1">
        <jet-responsive-nav-link
          :href="route('product.index')"
          :active="route().current('product.index')"
        >
          <button class="border border-fuchsia-600 rounded">
            YourProductPage
          </button>
        </jet-responsive-nav-link>
      </div>
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
    productinfo: { 
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