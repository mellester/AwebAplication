<template>
  <ProductLayout>
    <h1>You are about to offer a price for the follwin product.</h1>
    <product-list :productlist="[this.$page.product]" dusk="vue-product" />
    <div class="container grid">
      <h3>About</h3>
      <ul>
        <li>
          This product has been put on offer on
          {{ new Date(product.offer_at).toLocaleString("en-gb") }}
        </li>
        <li v-if="options.timeOffer">
          This offer is valid until {{ offerValid(options, product.offer_at) }}
        </li>
        <li v-if="options.priceOffer && product.price > 0">
          This offer has a {{ options.priceData }} with a price of
          {{ product.price }}
        </li>
      </ul>
      <form
        :action="route('product.userOffers.store', product.id, false)"
        method="post"
      >
        Please enter what you would like to offer for this product.
        <Label>
          Price <Input name="price" number v-model="this.form.price" />
        </Label>
        <Button class="jet-button">Submit</Button>
      </form>
    </div>
  </ProductLayout>
</template>

<script>
import ProductLayout from "@/Layouts/ProductLayout";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import ProductEdit from "/resources/js/components/ProductEdit";
import ErrorBagInteracter from "/resources/js/Mixins/InteractsWithErrorBags.js";
import sendRequest from "/resources/js/Mixins/sendRequest.js";

export default {
  mixins: [sendRequest, ErrorBagInteracter],
  components: {
    JetResponsiveNavLink,
    ProductLayout,
    ProductEdit,
  },
  props: {
    product: Object,
  },
  data() {
    debugger;
    return {
      form: {
        price: this.product.props,
        _token: this.$page.props.csrf_token,
      },
    };
  },
  methods: {
    submitForm: function (event) {
      return this.submit(event, this.form);
    },
  },
  computed: {
    options() {
      return JSON.parse(this.product.offer);
    },
  },
};
</script>