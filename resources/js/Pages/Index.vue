<template>
<body>
    <div class="site">
    <header class="topbar header">
        <a href="/" :active="true">
            <span class="sr-only">home page</span>
            {{ $inertia.page.props.appName }}
        </a>
        <button @click="isOpen = !isOpen" id="menuBttn"
         class="items-center block text-gray-500 hover:text-white">
            <svg v-if="!isOpen" viewBox="0 0 100 80" width="30" height="30">
                <rect width="100" height="20" rx="15"></rect>
                <rect y="30" width="100" height="20" rx="15"></rect>
                <rect y="60" width="100" height="20" rx="15"></rect>
            </svg>
            <svg v-else viewBox="0 0 20 20" width="30" height="30">
			<path fill="black" d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>
            </svg>
            
        </button>
        <nav :class="isOpen  ? 'block' : 'hidden'" class="nav flex items-begin justify-end">
        <a class="nav route" :href="route('register')" :active="route().current('register')">
                            Register
        </a>
        <a as="button" class="nav route" :href="route('login')" :active="route().current('login')">
                            Sign in
        </a>
        </nav>
    </header>
      
      <body class="mBody"> </body>
      
    </div>
 </body>
</template>


<script>
    import Welcome from '@/Jetstream/Welcome'

     import BasicLayout from '../Layouts/BasicLayout.vue'

    export default {
        data() {
            return {
                isOpen: false,
            }
        },
        //layout: (h, page) => h(BasicLayout, [page]),
        // layout: BasicLayout,
        components: {

        },
    }
</script>

<style scoped>
.header {
    display: grid;
    grid-template-areas:
    "logo menuBttn "
    "links links"
    ;
}
.nav {
    @apply shadow-md;
    @apply rounded;
    @apply rounded-md;
    @apply mt-1;
    gap: 0.5rem;
    padding-left: 0.5rem;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    grid-area: links;
    border-width: 0.1rem;
    flex-direction: column;
}

#menuBttn {
    margin: 1rem;
    display: inline-block;
        align-self: center;
    justify-self: right;
      align-self: center;
      right: 0;
}

  .mBody {
    grid-area: body;
    
  }
.site {
    @apply bg-gray-100;
  font-size: 2rem ;
    display: grid;
    grid-template-areas:
    "topbar topbar topbar topbar "
    "body body body sidebar"
    ;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    grid-template-rows: 1fr 1fr;
}
  
.topbar {
    @apply bg-gray-900;
    grid-area: topbar;
}
  
.logo {
    margin: 1rem;

    grid-area: logo;
    max-width: 300px;

}
.routes {
    grid-area: nav;
    text-align: right;
    padding: 0.1rem;
    }
 .route {
    padding: 0.1rem;
   
}

</style>