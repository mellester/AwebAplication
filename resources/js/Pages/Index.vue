<template>
<body>
    <nav class="section new-nav text-4xl bg-blue-700"> 
        <div class="sticky border-b top-0 z-40 w-full mx-auto bg-white flex flex-row">
            <a href="/" class="flex-auto pl-4 w-10 ">
            <span class="sr-only">home page</span>
            {{ $inertia.page.props.appName}}
            </a>
            <div class="flex justify-self-right">
            <a href="/login" class="flex-auto p-4 justify-self-right tw-text-white">Sign in</a>
            </div>
        </div>
    </nav>
    <div class="container">
    
    </div>
 </body>
</template>

<script>
    import Welcome from '@/Jetstream/Welcome'
import AppLayout from '../Layouts/AppLayout.vue'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
    }
</script>

                AppLayout