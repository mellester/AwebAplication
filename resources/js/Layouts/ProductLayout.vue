<template>
  <app-layout>
    <template #header>
      <div class="flex flex-row">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          <JetResponsiveNavLink
            :href="route('product.index', [], false)"
            :active="route().current('product.index')"
          >
            All Products
          </JetResponsiveNavLink>
        </h2>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          <JetResponsiveNavLink
            :href="route('product.indexYours', [], false)"
            :active="route().current('product.indexYours')"
          >
            Your Products
          </JetResponsiveNavLink>
        </h2>
      </div>
    </template>

    <div class="py-1">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div>
          <slot />
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
export default {
  components: {
    JetResponsiveNavLink,
    AppLayout,
    Welcome,
  },
  props: {},
};
</script>