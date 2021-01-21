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
      <span v-if="this.optionsC.timeOffer">
        Offer valid until
        <time>
          {{ offerValid(optionsC) }}
        </time>
      </span>
    </div>
    <div class="des">
      {{ product.description }}
    </div>
    <div class="buyNow justify-self-center">
      <JetResponsiveNavLink
        :href="route('product.userOffers.index', product.id, false)"
        class="text-center justify-self-center jet-button"
        >Make A offer
      </JetResponsiveNavLink>
      <div v-if="optionsC.priceOffer && product.price >= 0">
        Price: {{ product.price }}. <br />
        This is a {{ optionsC.priceData }}.
      </div>
    </div>
    <ul class="dat p-1 border border-gray-400" ref="data">
      <li v-for="(item, key, i) in data" v-bind:key="i">
        {{ key }}
        <span class="float-right justify-self-end">{{ item }} </span>
      </li>
      <div class="overlfow" v-if="isOverflown">
        <JetResponsiveNavLink
          :href="route('product.show', this.product.id, false)"
          class="mbtn"
        >
          Show more
        </JetResponsiveNavLink>
      </div>
    </ul>
  </div>
</template>

<script>
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import * as Status from "/resources/js/enums/productStatus.js";
import * as Duration from "/resources/js/enums/Duration.js";
import ErrorBagInteracter from "/resources/js/Mixins/InteractsWithErrorBags.js";

import Button from "../Jetstream/Button.vue";

export default {
  mixins: [ErrorBagInteracter],
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
    },
  },
  computed: {
    optionsC() {
      return this.options ? this.options : JSON.parse(this.product.offer) ?? [];
    },
    data() {
      return JSON.parse(this.product.data) ?? [];
    },
    isOverflown() {
      if (this.isMounted) {
        const {
          clientWidth,
          clientHeight,
          scrollWidth,
          scrollHeight,
        } = this.$refs.data;
        return scrollHeight > clientHeight || scrollWidth > clientWidth;
      }
      return false;
    },
  },
  data() {
    return {
      isMounted: false,
    };
  },
  mounted() {
    this.isMounted = true;
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
  font-size: initial;
}
.picture,
.name,
.des,
.buyNow {
  font-size: initial;
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
  overflow: hidden;
  position: relative;
}
.buyNow {
  grid-area: buy;
}
.owner {
  grid-area: owner;
}
.overlfow {
  position: absolute;
  text-align: center;
  align-self: center;
  min-width: 100%;
  opacity: 0.8;
  @apply m-1;
  background-color: beige;
  bottom: 0;
}

.mbtn {
  background-color: rgba(35, 56, 118);
  color: #000 !important;
}
</style>