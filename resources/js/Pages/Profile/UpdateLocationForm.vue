<template>
  <jet-form-section @submitted="submitLocation">
    <template #title> Update The location of your shop </template>

    <template #description> So persons may search by distance </template>
    <template #form>
      <div class="col-span-6 sm:col-span-4">
        <div v-if="$page.props.user.location">
          Your old addres is
          {{ JSON.parse($page.props.user.location).place.formatted_address }}
        </div>
        <jet-input-error
          :message="form.errors()"
          class="mt-2"
          v-if="form.hasErrors()"
        />
        <jet-label for="location" value="new Location" />
        <Zipcode @selected="zipcodeSelected">
          <input
            @keypress.enter.prevent
            v-model="form.text"
            class="w-full"
            name="location"
            type="text"
            ref="autocomplete"
          />
        </Zipcode>
        <jet-input-error :message="form.error('UserUpdate')" class="mt-2" />
        <div class="col-span-6 sm:col-span-4" v-if="hasLocation">
          <h3 class="text-lg font-medium text-gray-900">
            Your zip code is or addres is
            <div v-if="form.location && form.location.zipcode">
              {{ form.location.zipcode }}
            </div>
            <div v-else>{{ form.location.place.toString() }}</div>
          </h3>
        </div>
        <div v-else>
          <h3 class="text-lg font-medium text-gray-900">
            You have no location yet selected
          </h3>
        </div>
      </div>
    </template>
    <template #actions>
      <jet-action-message :on="form.recentlySuccessful" class="mr-3">
        Saved.
      </jet-action-message>

      <jet-button
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Save
      </jet-button>
    </template>
  </jet-form-section>
</template>

<script>
import JetActionSection from "@/Jetstream/ActionSection";
import JetActionMessage from "@/Jetstream/ActionMessage";
import JetButton from "@/Jetstream/Button";
import JetFormSection from "@/Jetstream/FormSection";
import JetInput from "@/Jetstream/Input";
import JetInputError from "@/Jetstream/InputError";
import JetLabel from "@/Jetstream/Label";
import Zipcode from "/node_modules/vue-google-maps-zipcode-input/dist/zipcode.js";
import DialogModal from "../../Jetstream/DialogModal.vue";

export default {
  components: {
    JetActionSection,
    JetActionMessage,
    JetButton,
    JetFormSection,
    JetInput,
    JetInputError,
    Zipcode,
    JetLabel,
  },
  data() {
    return {
      form: this.$inertia.form(
        {
          location: null,
          text: "",
        },
        {
          bag: "UserUpdate",
        }
      ),
    };
  },
  methods: {
    zipcodeSelected(location) {
      this.form.location = location;
      this.form.text = location.place.formatted_address;
    },
    submitLocation() {
      this.form.patch(route("user.update", this.$page.props.user), {
        preserveScroll: true,
      });
    },
  },
  computed: {
    hasLocation() {
      return this.form.location;
    },
  },
};
</script>

<style>
</style>