
<template>
<div class="bg-white shadow overflow-hidden sm:rounded-lg">
  <div class="px-4 py-5 sm:px-6">
    <form v-if="route().has('product.edit')" >
    <JetResponsiveNavLink class="m-float bg-blue-500 object-right" :href="route('product.edit', product.id)">Edit </JetResponsiveNavLink>
    </form>
    <h3 class="text-lg leading-6 font-medium text-gray-900">
      Product Information
    </h3>
    <p class="mt-1 max-w-2xl text-sm text-gray-500">
      Full details.
    </p>
  </div>
  <div class="border-t border-gray-200">
    <dl>
      <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          Name
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          {{product.name}}
        </dd>
      </div>
      <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          Created on
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          {{(new Date(product.created_at).toLocaleDateString())}}
        </dd>
      </div>
      <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          Owner and creator
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  <a class="text-sm text-blue-800"
        :href="route().has('user.show') ? route('user.show', product.user_id): ' ' ">
        {{ product.user_id == this.$inertia.page.props.user.id ? 
        "You" : product.owner.name }}
        </a>
        </dd>
      </div>
      <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          Offered Price
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          {{product.price}}
        </dd>
      </div>
      <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          About
        </dt>
        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          {{product.description}}
        </dd>
      </div>
      <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
        <dt class="text-sm font-medium text-gray-500">
          <p>Data </p> <Button class="Button" type="button" @click.native="ExpandPanle = !ExpandPanle" >></Button>
        </dt>
        <dd v-if="ExpandPanle"> </dd>
        <dd v-else
        class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
          <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm" 
            v-for="(item, index) in Data" :key="index">
            >
              <div class="w-0 flex-1 flex items-center">
                <!-- Heroicon name: paper-clip -->
                <!-- <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                </svg> -->
                <span class="ml-2 flex-1 w-0 truncate">
                  {{index}}
                </span>
              </div>
              <div class="ml-4 flex-shrink-0">
                  <template v-if="(typeof item) == 'number'">
                  {{item}}
                  </template>
                <template v-else-if="(typeof item) == 'object'">
                  {{item | pretty}}
                </template>
                <template v-else>
                  {{item }}
                </template>
              </div>
            </li>
          </ul>
        </dd>
      </div>
    </dl>
  </div>
</div>
</template>

<script>
import Button from '../Jetstream/Button.vue';
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
export default {
  data() {
    return {
      ExpandPanle: false,
    };
  },
  components: { Button , JetResponsiveNavLink},
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
    filters: {
    pretty: function(value) {
      return JSON.stringify(value, null, '\n');
    }
  },

}
</script>

<style>
.m-float {
    float: right;
    margin-top: 1em;
  position: relative;
}
</style>