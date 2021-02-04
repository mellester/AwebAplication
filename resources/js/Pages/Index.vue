<template>
  <BasicLayout>
    <search-bar v-on:searching="searchUpdate" class="bg-gray-100" />
    <div ref="productsOffers">
    <productOffer
      ref="productsOffer"
      v-for="(product, key) in products"
      :key="key"
      :product="product"
      :search="search"
      class="m-2"
    />
    </div>
  </BasicLayout>
</template>


<script>
import BasicLayout from "../Layouts/BasicLayout.vue";
import productOffer from "/resources/js/components/productOffer.vue";
import searchBar from "/resources/js/components/searchbar.vue";
export default {
  data() {
    return {
      isOpen: false,
      offers: [],
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
      return this.$store.state.PublishedProduct.data ?? [];
    },
  },
  methods: {
    searchUpdate(text) {
      console.log(text);
      this.search = text;
      this.PublishedProduct = this.$store.state.PublishedProduct.data.filter(
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
            .dispatch("load", { key: "PublishedProduct" }) //returns a promise
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
    this.$watch(
        () => {
          const i =  this.$refs.productsOffer;
          debugger;
            return this.$refs.productsOffers.childNodes.length
        },
      (val) => {
        alert('App $watch $refs.counter.i: ' + val)
      }
    )
  },
};
</script>

