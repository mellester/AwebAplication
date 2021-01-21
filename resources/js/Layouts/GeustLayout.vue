<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white border-b border-gray-100">
      <!-- Primary Navigation Menu -->
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <div class="flex">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
              <inertia-link :href="route('landinpage', [], false)">
                <jet-application-mark class="block h-9 w-auto" />
              </inertia-link>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
              <jet-nav-link
                :href="route('dashboard', [], false)"
                :active="route().current('dashboard')"
              >
                Dashboard
              </jet-nav-link>
              <jet-nav-link
                :href="route('product.index', [], false)"
                :active="route().current('product.*')"
              >
                Products
              </jet-nav-link>
            </div>
          </div>

          <!-- Settings Dropdown -->
          <div class="hidden sm:flex sm:items-center sm:ml-6">
            <div class="ml-3 relative">
              <jet-dropdown align="right" width="48">
                <template #trigger> </template>

                <template #content>
                  <!-- Authentication -->
                  <jet-dropdown-link> Login </jet-dropdown-link>
                </template>
              </jet-dropdown>
            </div>
          </div>

          <!-- Hamburger -->
          <div class="-mr-2 flex items-center sm:hidden">
            <button
              @click="showingNavigationDropdown = !showingNavigationDropdown"
              class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
            >
              <svg
                class="h-6 w-6"
                stroke="currentColor"
                fill="none"
                viewBox="0 0 24 24"
              >
                <path
                  :class="{
                    hidden: showingNavigationDropdown,
                    'inline-flex': !showingNavigationDropdown,
                  }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                  :class="{
                    hidden: !showingNavigationDropdown,
                    'inline-flex': showingNavigationDropdown,
                  }"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      <!-- Responsive Navigation Menu -->
      <div
        :class="{
          block: showingNavigationDropdown,
          hidden: !showingNavigationDropdown,
        }"
        class="sm:hidden"
      >
        <div class="pt-2 pb-3 space-y-1">
          <jet-responsive-nav-link
            :href="route('dashboard', [], false)"
            :active="route().current('dashboard', [], false)"
          >
            Dashboard
          </jet-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
          <div class="flex items-center px-4">
            <div class="flex-shrink-0">
              <img
                class="h-10 w-10 rounded-full"
                :src="$page.user.profile_photo_url"
                :alt="$page.user.name"
              />
            </div>

            <div class="ml-3">
              <div class="font-medium text-base text-gray-800">
                {{ $page.user.name }}
              </div>
              <div class="font-medium text-sm text-gray-500">
                {{ $page.user.email }}
              </div>
            </div>
          </div>

          <div class="mt-3 space-y-1">
            <jet-responsive-nav-link
              :href="route('profile.show', [], false)"
              :active="route().current('profile.show', [], false)"
            >
              Profile
            </jet-responsive-nav-link>

            <jet-responsive-nav-link
              :href="route('api-tokens.index', [], false)"
              :active="route().current('api-tokens.index', [], false)"
              v-if="$page.jetstream.hasApiFeatures"
            >
              API Tokens
            </jet-responsive-nav-link>

            <!-- Authentication -->
            <form method="POST" @submit.prevent="logout">
              <jet-responsive-nav-link as="button">
                Logout
              </jet-responsive-nav-link>
            </form>

            <!-- Team Management -->
            <template v-if="$page.jetstream.hasTeamFeatures">
              <div class="border-t border-gray-200"></div>

              <div class="block px-4 py-2 text-xs text-gray-400">
                Manage Team
              </div>

              <!-- Team Settings -->
              <jet-responsive-nav-link
                :href="route('teams.show', $page.user.current_team, false)"
                :active="route().current('teams.show')"
              >
                Team Settings
              </jet-responsive-nav-link>

              <jet-responsive-nav-link
                :href="route('teams.create', [], false)"
                :active="route().current('teams.create')"
              >
                Create New Team
              </jet-responsive-nav-link>

              <div class="border-t border-gray-200"></div>

              <!-- Team Switcher -->
              <div class="block px-4 py-2 text-xs text-gray-400">
                Switch Teams
              </div>

              <template v-for="team in $page.user.all_teams">
                <form @submit.prevent="switchToTeam(team)" :key="team.id">
                  <jet-responsive-nav-link as="button">
                    <div class="flex items-center">
                      <svg
                        v-if="team.id == $page.user.current_team_id"
                        class="mr-2 h-5 w-5 text-green-400"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        ></path>
                      </svg>
                      <div>{{ team.name }}</div>
                    </div>
                  </jet-responsive-nav-link>
                </form>
              </template>
            </template>
          </div>
        </div>
      </div>
    </nav>

    <!-- Page Heading -->
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <slot name="header"></slot>
      </div>
    </header>

    <!-- Page Content -->
    <main>
      <slot></slot>
    </main>

    <!-- Modal Portal -->
    <portal-target name="modal" multiple> </portal-target>

    <!--- Error modal -->
    <Modal :show="showingErrorModal" @close="closeModal">
      <template #content>
        showingErrorModal
        <ul>
          <li v-for="items in errorbag" v-bind:key="items.key">
            {{ items }}
          </li>
        </ul>
      </template>
    </Modal>
  </div>
</template>

<script>
import JetApplicationMark from "@/Jetstream/ApplicationMark";
import JetDropdown from "@/Jetstream/Dropdown";
import JetDropdownLink from "@/Jetstream/DropdownLink";
import JetNavLink from "@/Jetstream/NavLink";
import JetResponsiveNavLink from "@/Jetstream/ResponsiveNavLink";
import ErrorBagInteracter from "../Mixins/InteractsWithErrorBags";
import Modal from "../Jetstream/DialogModal.vue";
import Vue from "vue";

export default {
  mixins: [ErrorBagInteracter],
  components: {
    JetApplicationMark,
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
    JetResponsiveNavLink,
    Modal,
  },

  data() {
    return {
      showingNavigationDropdown: false,
      showingErrorModal: false,
      ExitErrorModal: false,
    };
  },
  beforeUpdate() {
    if (this.hasErrors("default")) {
      this.showingErrorModal = true;
      console.log("showing erros");
    }
  },
  methods: {
    closeModal(bag = "default") {
      Vue.delete(this.$page.errorBags[bag], bag);
      this.showingErrorModal = false;
    },
    switchToTeam(team) {
      this.$inertia.put(
        route("current-team.update", [], false),
        {
          team_id: team.id,
        },
        {
          preserveState: false,
        }
      );
    },

    logout() {
      axios.post(route("logout", [], false)).then((response) => {
        window.location = "/";
      });
    },
  },
  computed: {
    errorbag: function () {
      return this.$page.errorBags.default;
    },
  },
};
</script>
