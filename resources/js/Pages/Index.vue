<template>
<body>
    <div class="site">
    <header class="topbar header">
        <jet-nav-link href="/" :active="true">
            <span class="sr-only">home page</span>
            {{ $inertia.page.props.appName }}
        </jet-nav-link>
        <button @click="isOpen = !isOpen" id="menuBttn"
         class="items-center block text-gray-500 hover:text-white">
               <svg viewBox="0 0 100 80" width="30" height="30">
                <rect width="100" height="20"></rect>
                <rect y="30" width="100" height="20"></rect>
                <rect y="60" width="100" height="20"></rect>
            </svg>
        </button>
        <nav :class="isOpen  ? 'block' : 'hidden'" class="nav flex items-begin justify-end">
        <jet-responsive-nav-link class="nav route" :href="route('register')" :active="route().current('register')">
                            Register
        </jet-responsive-nav-link>
        <jet-responsive-nav-link as="button" class="nav route" :href="route('login')" :active="route().current('login')">
                            Sign in
        </jet-responsive-nav-link>
        </nav>
    </header>
      
      <body class="mBody"> </body>
      
    </div>
 </body>
</template>


<script>
    import Welcome from '@/Jetstream/Welcome'
import AppLayout from '../Layouts/AppLayout.vue'
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'

     import BasicLayout from '../Layouts/BasicLayout.vue'

    export default {
        data() {
            return {
                isOpen: false,
            }
        },
        layout: (h, page) => h(BasicLayout, [page]),
         layout: BasicLayout,
        components: {
            AppLayout,
            Welcome,
            JetResponsiveNavLink,
            JetNavLink,
            JetDropdownLink,
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