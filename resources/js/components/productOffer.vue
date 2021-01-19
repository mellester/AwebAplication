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
      <a
        :href="
          route().has('user.show')
            ? route('user.show', product.owner.id, false)
            : null
        "
      >
        {{ product.owner.name }}
      </a>
      <br />
      <span v-if="this.options.timeOffer">
        Offer valid until
        <time>
          {{ offerValid.toLocaleString("en-gb") }}
        </time>
      </span>
    </div>
    <div class="des">
      {{ product.description }}
    </div>
    <div class="buyNow justify-self-center">
      <Button class="text-center justify-self-center">Make A offer</Button>
      <div v-if="options.priceOffer && product.price >= 0">
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
      const toAdd = parseInt(this.options.timeData[0]);
      // console.log(date, this.options.timeData[1], date.getHours());
      switch (this.options.timeData[1]) {
        case Duration.Hour:
          date.setHours(parseInt(date.getHours()) + toAdd);
          break;
        case Duration.Month:
          date.setMonth(date.getMonth() + toAdd);
          break;
        case Duration.Week:
          date.setDate(date.getDate() + toAdd * 7);
          break;
        case Duration.Days:
          date.setDate(date.getDate() + toAdd);
          break;
      }
      return date.toLocaleString("en-gb");
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
  grid-template-rows: repeat(2, 1fr) 0.8fr 1.2fr 1fr 30%;
  grid-template-areas:
    "pic pic pic name"
    "pic pic pic owner"
    "pic pic pic buy"
    "pic pic pic dat"
    "pic pic pic dat"
    "des des des dat";
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