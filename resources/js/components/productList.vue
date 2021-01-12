<template>
  <div>
    <div class="flex flex-col flex-grow p-3" v-if="productlist1.length > 0">
      <h1>Pubilshed items</h1>
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
          v-for="product in productlist1"
          :key="product['data'].key"
          :product="product"
        />
      </table>
    </div>

    <div class="flex flex-col flex-grow p-3" v-if="productlist2.length > 0">
      <h1>Unpibishled items</h1>
      <table class="mtable">
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
          v-for="product in productlist2"
          :key="product['data'].key"
          :product="product"
        />
      </table>
    </div>
  </div>
</template>

<script>
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import * as Status from '/resources/js/enums/productStatus.js'

export default {
  components: {
    JetResponsiveNavLink,
  },
  props: {
    productlist: {
      type: Object,
      required: true,
    },
  },
  computed: {
    productlist1: function () {
      return this.productlist['data'].filter(function (object) {
        return object.status !== Status.notPublished;
      });
    },
    productlist2: function () {
      return this.productlist['data'].filter(function (object) {
        return object.status === Status.notPublished;
      });
    },    
  },
};
</script>

<style   scoped>
.mtable  {
  @apply min-w-full;
}
.mgrid {
  display: grid;
  grid-template-columns: 1fr 4fr 1fr;
  grid-template-rows: auto;
}
.mdes {
  grid-column: 1 / span 3;
  grid-row: 2;
}

.mgrid > div {
  height: 100%;
}
th {
  text-align: left;
}
td {
  @apply border;
}
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