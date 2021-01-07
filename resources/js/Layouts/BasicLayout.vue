<template>
  <main>
    <header>
      <inertia-link href="/">Home</inertia-link>
      <inertia-link  href="/login" :active="route().current('login')">About</inertia-link>
      <inertia-link href="/register">Contact</inertia-link>
    </header>
    <article>
      <slot />
    </article>
  </main>
</template>

<script>
  export default {
    props: {
      title: String,
    },
    watch: {
      title: {
        immediate: true,
        handler(title) {
          document.title = title
        },
      },
    },
  }
</script>