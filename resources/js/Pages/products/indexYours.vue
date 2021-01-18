<template>
  <ProductLayout>
    <div>
      <div class="flex flex-col flex-grow p-3" v-if="productlist1.length > 0">
        <h1>Pubilshed items</h1>
        <product-list :productlist="productlist1" dusk="vue-product" />
      </div>

      <div class="flex flex-col flex-grow p-3" v-if="productlist2.length > 0">
        <h1>Unpibishled items</h1>
        <product-list :productlist="productlist2" dusk="vue-product" />
      </div>
    </div>
  </ProductLayout>
</template>

<script>
import ProductLayout from "@/Layouts/ProductLayout";

import * as Status from "/resources/js/enums/productStatus.js";

export default {
  components: {
    ProductLayout,
  },
  props: {
    productlist: Object,
  },
  computed: {
    productlist1: function () {
      return this.productlist["data"].filter(function (object) {
        return object.status !== Status.notPublished;
      });
    },
    productlist2: function () {
      return this.productlist["data"].filter(function (object) {
        return object.status === Status.notPublished;
      });
    },
  },
};
</script>