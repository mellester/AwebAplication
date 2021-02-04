<template>
  <BasicLayout>
    <Paginate
      :Component="'productOffer'"
      laravelPaginateStoreKey="PublishedProduct"
      class="m-2"
    />
  </BasicLayout>
</template>




<script>
import BasicLayout from "../Layouts/BasicLayout.vue";
import productOffer from "/resources/js/components/productOffer.vue";
import searchBar from "/resources/js/components/searchbar.vue";
import Paginate from "/resources/js/components/Paginate.vue";
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
  components: { Paginate, BasicLayout, productOffer, searchBar },
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
  },
  mounted() {},
};
</script>

