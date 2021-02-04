<template>
  <ProductLayout>
    <h1>You are about to publish a product for sale on our webiste.</h1>
    <product-list
      :productlist="[this.$page.props.product]"
      dusk="vue-product"
    />
    <div class="container grid">
      <h3>Options</h3>

      <form
        @submit.prevent="submitForm"
        :action="route('product.update', product.id, false)"
        method="patch"
        class="Options p-3"
      >
        <Label class="lcontainer"
          >Limited time offer
          <input
            type="checkbox"
            :checked="options.timeOffer"
            v-on:input="options.timeOffer = !options.timeOffer"
          />
          <span class="checkmark"></span>
        </Label>
        <div class="m-l-4" v-if="options.timeOffer">
          For:
          <input
            class="w-10"
            v-model="options.timeData[0]"
            type="number"
            min="1"
          />
          <label>
            <select
              v-model="options.timeData[1]"
              type="select"
              name="cars"
              id="cars"
            >
              <option
                v-for="DurationOption in DurationOptions"
                :key="DurationOption"
                :value="DurationOption"
              >
                {{ DurationOption }}
              </option>
            </select>
          </label>
        </div>

        <Label class="lcontainer">
          Use Price information
          <input
            type="checkbox"
            :checked="options.priceOffer"
            v-on:input="options.priceOffer = !options.priceOffer"
          />
          <span class="checkmark"></span>
        </Label>

        <div v-if="options.priceOffer">
          AS
          <label>
            <select
              v-model="options.priceData"
              type="select"
              name="priceData"
              id="cars"
            >
              <option
                v-for="PriceEnum in PriceEnums"
                :key="PriceEnum"
                :value="PriceEnum"
              >
                {{ PriceEnum }}
              </option>
            </select>
          </label>
        </div>

        <Label
          class="lcontainer"
          :checked="options.PremOffer"
          v-on:input="options.PremOffer = !options.PremOffer"
          >Boost this Offer to the top of the list
          <input type="checkbox" />
          <span class="checkmark"></span>
        </Label>

        <div class="m-l-4" v-if="options.PremOffer">
          This will be billed to your acount
        </div>

        <Label class="lcontainer">
          DO not send me Emails about this product
          <input type="checkbox" />
          <span class="checkmark"></span>
        </Label>
        <Button class="Submit"> Submit </Button>
      </form>
    </div>
    <div class="Previeuw">Previeuw</div>
    <product-offer :product="this.$page.props.product" :options="options" />
  </ProductLayout>
</template>

<script>
import ProductLayout from "@/Layouts/ProductLayout";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import ProductEdit from "/resources/js/components/ProductEdit";
import Input from "../../Jetstream/Input.vue";
import Dropdown from "../../Jetstream/Dropdown.vue";
import * as Status from "/resources/js/enums/productStatus.js";
import * as Duration from "/resources/js/enums/Duration.js";
import * as PriceOptions from "/resources/js/enums/PriceOptions.js";
import Button from "../../Jetstream/Button.vue";
import productOffer from "@/components/productOffer";
import sendRequest from "@/Mixins/sendRequest";

export default {
  mixins: [sendRequest],
  components: {
    JetResponsiveNavLink,
    ProductLayout,
    ProductEdit,
    Dropdown,
    Button,
    productOffer,
  },
  data: function () {
    return {
      options: {
        timeOffer: false,
        timeData: [0, Duration.Hour],
        priceOffer: false,
        priceData: PriceOptions.SuggestPrice,
        PremOffer: false,
      },
      DurationOptions: Object.keys(Duration).map((key) => Duration[key]),
      PriceEnums: Object.keys(PriceOptions).map((key) => PriceOptions[key]),
    };
  },
  methods: {
    submitForm: function (event) {
      return this.submit(event, {
        ...this.product,
        offer: JSON.stringify(this.options),
      });
    },
  },
  computed: {
    product: function () {
      return this.$page.props.product;
    },
  },
  Inputprops: {
    product: Object,
  },
  mounted() {
    let s = Object.keys(Duration);
  },
};
</script>

<style  scoped>
.Options {
  display: grid;
  font-size: 130%;
  grid-template-columns: 14rem 1fr;
}
/* Hide the browser's default checkbox */
.lcontainer input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

.lcontainer {
  @apply border;
  grid-column: 1;
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Create a custom checkbox */
.checkmark {
  display: inline-block;
  @apply border;
  position: absolute;
  top: 0;
  left: 0;
  height: 2rem;
  width: 2rem;
  background-color: rgb(255, 255, 255);
}

/* On mouse-over, add a grey background color */
.lcontainer:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.lcontainer input:checked ~ .checkmark {
  background-color: #2196f3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.lcontainer input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.lcontainer .checkmark:after {
  left: 30%;
  top: 10%;
  width: 0.8rem;
  height: 1.2rem;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
.Submit,
.Previeuw {
  grid-column: 1 / span 2;
}
</style>
