<template>
  <div class="site">
    <header class="topbar header">
      <nav>
        <a href="/" :active="true">
          <span class="sr-only">home page</span>
          {{ $inertia.page.props.appName }}
        </a>
        <a href="/Paginate" :active="true">
          <span class="sr-only">Paginate</span>
          Paginate
        </a>
        <a href="/chat" :active="true">
          <span class="sr-only">Paginate</span>
          chat
        </a>
      </nav>
      <button
        @click="isOpen = !isOpen"
        id="menuBttn"
        class="items-center block text-gray-500 hover:text-white"
      >
        <svg v-if="!isOpen" viewBox="0 0 100 80" width="30" height="30">
          <rect width="100" height="20" rx="15"></rect>
          <rect y="30" width="100" height="20" rx="15"></rect>
          <rect y="60" width="100" height="20" rx="15"></rect>
        </svg>
        <svg v-else viewBox="0 0 20 20" width="30" height="30">
          <path
            fill="black"
            d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"
          ></path>
        </svg>
      </button>
      <nav
        :class="isOpen ? 'block' : 'hidden'"
        class="nav flex items-begin justify-end"
      >
        <a
          v-if="$page.props.user == null"
          class="nav route"
          :href="route('register', [], false)"
          :active="route().current('register')"
        >
          Register
        </a>
        <a
          v-if="$page.props.user == null"
          as="button"
          class="nav route"
          :href="route('login', [], false)"
          :active="route().current('login')"
        >
          Sign in
        </a>
        <a
          v-else
          as="button"
          class="nav route"
          :href="route('dashboard', [], false)"
          :active="route().current('login')"
        >
          dashboard
        </a>
      </nav>
      <slot name="header"></slot>
    </header>
    <main class="body">
      <slot />
    </main>
    <footer class="foot">
      <slot name="footer"></slot>
    </footer>
  </div>
</template>

<script>
import layoutMixin from "/resources/js/Mixins/layoutMixin.js";

export default {
  mixins: [layoutMixin],
  props: {
    title: String,
  },
  data() {
    return {
      isOpen: false,
    };
  },
  watch: {
    title: {
      immediate: true,
      handler(title) {
        document.title = title;
      },
    },
  },
};
</script>

<style lang="css" scoped>
.header {
  display: grid;
  grid-template-areas:
    "logo menuBttn "
    "links links";
}

.site {
  @apply bg-gray-100;
  font-size: 2rem;
  display: grid;
  grid-template-areas:
    "topbar topbar topbar topbar "
    "body body body body"
    "footer footer footer footer";
  grid-template-columns: 1fr 1fr 1fr 1fr;
  /* grid-template-rows: 1fr 1fr; */
}

.body {
  grid-area: body;
  min-height: 50vh;
}

.foot {
  grid-area: footer;
  min-height: 10vh;
}

.topbar {
  @apply bg-gray-900;
  grid-area: topbar;
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