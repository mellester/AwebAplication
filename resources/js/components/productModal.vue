<template>
  <tbody>
    <tr class="">
      <td id="expandButton">
        <button @click="isExpanded = !isExpanded">
          {{ !isExpanded ? "expand" : "unexpand" }}
        </button>
      </td>
      <td id="name">
        {{ product.name }}
      </td>
      <td id="Cost">
        {{ product.price }}
      </td>
      <td id="Weight">
        {{ Data.weight }}
      </td>
      <td id="Source">
        {{ Data.source }}
      </td>
      <td id="Owner">
        <a class="text-sm text-blue-800"
        :href="route().has('user.show') ? route('user.show', product.user_id): ' ' ">
        {{ product.user_id == this.$inertia.page.props.user.id ? 
        "You" : product.owner.name }}
        </a>
      </td>
        <td id="Show">
            <JetResponsiveNavLink :href="route('product.show', this.product.id)" class="mbtn">
              Show
            </JetResponsiveNavLink>
      </td>
    </tr>
    <tr  :class="isExpanded ? '' : 'hidden'">
      <td>
        <form @submit.prevent="submit"  v-if="product.status == 'notPublished'"> 
           <Button type="submit" class="mbtn">Publish</Button>
        </form>
           <Button class="mbtn" v-else>unPublish</Button>
       </td>
      <td colspan="6" class="mdes">
        {{ product.description }}
      </td>
    </tr>
  </tbody>
</template>

<script>
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";

import * as Status from '/resources/js/enums/productStatus.js'
export default {
    components: {
    JetResponsiveNavLink,
  },
  data() {
    return {
      isExpanded: false,
      form: {
          id: this.product.id,
          status: this.product.status,
      },
    };
  },
  props: {
    product: {
      type: Object,
      required: true,
    },
  },
  computed: {
    Data: function () {
      return JSON.parse(this.product.data);
    },
  },
    methods: {
      submit() {
       this.form.status = Status.Published;
       this.$inertia.patch(route('product.update', this.product.id), this.form).then( () => {
       this.isExpanded = false;
         this.$inertia.reload({ only: ['products'] })
       });
    },
  },
    filters: {
    pretty: function(value) {
      return JSON.stringify(JSON.parse(value), null, 2);
    }
  },
};
</script>

<style scoped>
.btn-default {
  color: #333;
  background-color: #fff;
  border-color: #ccc;
}

</style>