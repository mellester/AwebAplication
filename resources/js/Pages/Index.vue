<template>
  <BasicLayout>
    <search-bar v-on:searching="searchUpdate" class="bg-gray-100" />
    <div ref="productsOffers">
      <input
        v-model="sortByDistance"
        id="sortBy"
        type="checkbox"
        class="mr-2"
      />
      <label for="sortBy">Sort by distance</label>
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
import Input from "../Jetstream/Input.vue";
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
      sortByDistance: false,
      search: undefined,
      PublishedProduct: undefined,
    };
  },
  components: { BasicLayout, productOffer, searchBar, Input },
  computed: {
    products() {
      // debugger;
      if (this.sortByDistance) {
        if (this.PublishedProduct)
          return (
            this.$store.getters.sortByDistance(this.PublishedProduct) ?? []
          );
        return this.$store.getters.sortByDistance("PublishedProduct") ?? [];
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
    const userLocation = this.$page?.props?.user?.location;
    this.$store.commit("userLocation", userLocation);
    this.scroll();
  },
};
</script>

<style scoped>
input[type="checkbox"] {
  /* Double-sized Checkboxes */
  -ms-transform: scale(2); /* IE */
  -moz-transform: scale(2); /* FF */
  -webkit-transform: scale(2); /* Safari and Chrome */
  -o-transform: scale(2); /* Opera */
  transform: scale(2);
  padding: 10px;
}

/* Might want to wrap a span around your checkbox text */
.checkboxtext {
  /* Checkbox text */
  font-size: 110%;
  display: inline;
}
</style>
