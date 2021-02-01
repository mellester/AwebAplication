
<template>
  <div>
    <input type="text" ref="input" v-model="text" @input="doSearch" />
    <!-- <ul v-if="text.length > 0 && isLoading == false && this.firstTry">
      <li v-for="(id, key) in resultIds" v-bind:key="key">
        <span v-html="replace(PublishedProduct.find((o) => o.id == id).name)" />
        <span v-html="replace(PublishedProduct.find((o) => o.id == id).data)" />
        <span
          v-html="replace(PublishedProduct.find((o) => o.id == id).description)"
        />
      </li>
    </ul> -->
  </div>
</template>

<script>
import {
  mapActions as mapSearchActions,
  mapGetters as mapSearchGetters,
  getterTypes,
  actionTypes,
} from "vuex-search";

export default {
  data() {
    return {
      text: "",
      firstTry: false,
      loading: false,
    };
  },
  props: {
    searchText: {
      type: String,
    },
  },
  computed: {
    PublishedProduct() {
      return this.$store.state.PublishedProduct;
    },
    foundProducts() {
      return this.$store.state.PublishedProduct.filter((o) => {
        return this.resultIds.includes(o.id);
      });
    },
    result() {
      return this.$refs.input.valid()
        ? this.$store.vuexSearch.Products.result
        : [];
    },
    ...mapSearchGetters("Products", {
      resultIds: getterTypes.result,
      isLoading: getterTypes.isSearching,
    }),
  },

  methods: {
    ...mapSearchActions("Products", {
      searchProducts: actionTypes.search,
    }),
    replace(text) {
      if (this.searchText) {
        return text.replace(new RegExp(this.text, "gi"), (match) => {
          return '<span class="highlightText">' + match + "</span>";
        });
      } else return text;
    },
    doSearch() {
      //   debugger;
      if (this.loading) return;
      this.loading = true;
      return this.$store
        .dispatch("loadAll", "PublishedProductApi")
        .then(() => {
          this.firstTry = true;
          this.$emit("searching", this.text);
          return this.searchProducts(this.text);
        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>

<style>
.highlightText {
  color: red;
}
</style>