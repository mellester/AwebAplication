<template>
  <BasicLayout>
    <search-bar v-on:searching="searchUpdate" />
    <productOffer
      v-for="(product, key) in products"
      :key="key"
      :product="product"
      :search="search"
      class="m-2"
    />
  </BasicLayout>
</template>


<script>
import Welcome from "@/Jetstream/Welcome";

import BasicLayout from "../Layouts/BasicLayout.vue";
import productOffer from "/resources/js/components/productOffer.vue";
import searchBar from "/resources/js/components/searchbar.vue";
export default {
  data() {
    return {
      isOpen: false,
      error: null,
      loading: false,
      promise: false,
      search: undefined,
      PublishedProduct: undefined,
    };
  },
  components: { BasicLayout, productOffer, searchBar },
  computed: {
    products() {
      // debugger;
      if (this.PublishedProduct != undefined) {
        return this.PublishedProduct;
      }
      return this.$store.state.PublishedProduct ?? [];
    },
  },
  methods: {
    searchUpdate(text) {
      console.log(text);
      this.search = text;
      this.PublishedProduct = this.$store.state.PublishedProduct.filter(
        (item) => this.$store.state.vuexSearch.Products.result.includes(item.id)
      );
    },
    scroll() {
      window.onscroll = () => {
        let bottomOfWindow =
          document.documentElement.scrollTop + window.innerHeight >
          document.documentElement.offsetHeight * 0.9;
        if (bottomOfWindow && !this.promise) {
          this.promise = this.$store
            .dispatch("load", "PublishedProductApi") //returns a promise
            .then(() => (this.loading = false))
            .catch((e) => {
              // if (!this.error) {
              console.error(e);
              this.error = "Failed to load data";
              console.log(this.error);
              //}
            })
            .finally(() => {
              this.loading = false;
              this.promise = false;
            });
        }
      };
    },
  },
  mounted() {
    this.scroll();
  },
};
</script>

