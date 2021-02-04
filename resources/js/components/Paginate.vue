<template>
  <div>
    <vue-ads-pagination
      :total-items="laravelPaginate.Api.total"
      :items-per-page="laravelPaginate.Api.per_page"
      :max-visible-pages="5"
      :page="laravelPaginate.Api.current_page - 1"
      :loading="loading"
      @page-change="pageChange"
      @range-change="rangeChange"
    >
      <template slot-scope="props">
        <div class="vue-ads-pr-2 vue-ads-leading-loose">
          Items {{ props.start }} tot {{ props.end }} van de {{ props.total }}
        </div>
      </template>
      <template slot="buttons" slot-scope="props">
        <vue-ads-page-button
          v-for="(button, key) in props.buttons"
          :key="key"
          v-bind="button"
          @page-change="pageChange(button.page + 1)"
        />
      </template>
    </vue-ads-pagination>

    <productOffer
      v-for="(item, key) in products"
      v-bind:key="key"
      :product="item"
    >
    </productOffer>
    <vue-ads-pagination
      :total-items="laravelPaginate.Api.total"
      :items-per-page="laravelPaginate.Api.per_page"
      :max-visible-pages="5"
      :page="laravelPaginate.Api.current_page - 1"
      :loading="loading"
      @page-change="pageChange"
      @range-change="rangeChange"
    >
      <template slot-scope="props">
        <div class="vue-ads-pr-2 vue-ads-leading-loose">
          Items {{ props.start }} tot {{ props.end }} van de {{ props.total }}
        </div>
      </template>
      <template slot="buttons" slot-scope="props">
        <vue-ads-page-button
          v-for="(button, key) in props.buttons"
          :key="key"
          v-bind="button"
          @page-change="pageChange(button.page + 1)"
        />
      </template>
    </vue-ads-pagination>
  </div>
</template>

<script>
import "/node_modules/vue-ads-pagination/dist/vue-ads-pagination.css";

import VueAdsPagination, { VueAdsPageButton } from "vue-ads-pagination";
import productOffer from "/resources/js/components/productOffer.vue";

export default {
  name: "Paginate",

  components: {
    VueAdsPagination,
    productOffer,
    VueAdsPageButton,
  },

  props: {
    Component: {
      default: "div",
    },
    laravelPaginateStoreKey: {
      Type: String,
      required: true,
    },
  },
  data() {
    return {
      promise: null,
      page: 5,
    };
  },
  computed: {
    laravelPaginate() {
      return this.$store.state[this.laravelPaginateStoreKey];
    },
    loading() {
      return this.$store.state.sendingRequest;
    },
    products() {
      return this.laravelPaginate.Api.data;
    },
  },

  methods: {
    pageChange(page) {
      console.log("pageChange", page);
      this.promise = this.$store.dispatch("load", {
        key: "PublishedProduct",
        page: page,
      });
    },

    rangeChange(start, end) {
      if (start == 0) {
        this.pageChange(0);
      } else {
        console.log("rangeChange", start, end);
      }
    },
  },
};
</script>