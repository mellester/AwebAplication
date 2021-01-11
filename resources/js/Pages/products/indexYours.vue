<template>
  <ProductLayout>

  </ProductLayout>
</template>

<script>
import ProductLayout from "@/Layouts/ProductLayout";
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            ProductLayout,
            Welcome,
        },
        props: {
            productinfo: Object,
        }
    }
</script>