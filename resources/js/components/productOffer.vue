<template>
  <div class="container border body">
    <img class="picture m-4" src="https://picsum.photos/400" sizes="400" />
    <div class="name mt-5 text-center text-lg">
      <h1>{{ product.name }}</h1>
      <!-- <br />
      {{ product.name }} -->
    </div>
    <div class="owner text-center">
      For sale by
      <a> {{ product.owner.name }} </a>
      <br />
      <span>
        Offer valid until
        <time :datetime="offerValid.toLocaleString()">
          {{ offerValid.toLocaleString("en-gb") }}
        </time>
      </span>
    </div>
    <div class="des">
      {{ product.description }}
    </div>
    <div class="buyNow justify-self-center">
      <Button class="text-center justify-self-center">Make A offer</Button>
      <div v-if="options.priceOffer">
        Price: {{ product.price }}. <br />
        This is a {{ options.priceData }}.
      </div>
    </div>
    <ul class="dat p-1 border border-gray-400">
      <li v-for="(item, key, i) in data" v-bind:key="i">
        {{ key }}
        <span class="float-right justify-self-end">{{ item }} </span>
      </li>
    </ul>
  </div>
</template>

<script>
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import * as Status from "/resources/js/enums/productStatus.js";
import * as Duration from "/resources/js/enums/Duration.js";

import Button from "../Jetstream/Button.vue";

export default {
  components: {
    JetResponsiveNavLink,
    Button,
  },
  props: {
    product: {
      type: Object,
      required: true,
    },
    options: {
      type: Object,
      required: true,
    },
  },
  computed: {
    data() {
      return JSON.parse(this.product.data) ?? [];
    },
    offerValid() {
      let date = new Date();
      const toAdd = this.options.timeData[0];
      switch (this.options.timeData[1]) {
        case Duration.Hour:
          return date.setHours(date.getHours() + toAdd).toLocaleString();
      }
      return date;
    },
  },
};
</script>

<style   scoped>
.body {
  display: grid;
  @apply bg-red-300;
  @apply p-4;
  width: 40rem;
  height: 40rem;
  grid-template-columns: 1fr 1fr 1fr 30%;
  grid-template-rows: 1fr 1fr 1fr 1fr 1fr 30%;
  grid-template-areas:
    "pic pic pic name"
    "pic pic pic owner"
    "pic pic pic buy"
    "pic pic pic dat"
    "pic pic pic dat"
    "des des nul dat";
}
.picture,
.name,
.des,
.buyNow {
  overflow-wrap: break-word;
}
.picture {
  grid-area: pic;
}
.null {
  grid-area: nul;
}
.name {
  grid-area: name;
}
.des {
  grid-area: des;
}
.dat {
  grid-area: dat;
}
.buyNow {
  grid-area: buy;
}
.owner {
  grid-area: owner;
}
</style>