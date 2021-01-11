<template>
  <ProductLayout>
    <product-list :productlist="productlist"/>
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
            productlist: Object,
        }
    }
</script>