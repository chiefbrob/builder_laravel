<template>
  <div>
    <nav-root></nav-root>
    <div class="mb-5 pb-5 row" v-if="!submitted">
      <div class="col-md-8 offset-md-2 py-4">
        <b-progress :max="max" show-progress animated>
          <b-progress-bar
            :value="value"
            :label="`${((value / max) * 100).toFixed(0)}%`"
          ></b-progress-bar>
        </b-progress>
        <h4>Contact</h4>
        <b-form-group
          class="pt-3"
          id="input-group-1"
          label="Name: *"
          label-for="name"
          description="Full Name"
        >
          <b-form-input
            id="name"
            v-model="form.name"
            type="text"
            required
            :placeholder="`Enter all three names`"
          ></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="name"></field-error>

        <b-form-group
          id="input-group-2"
          label="Email: *"
          label-for="email"
          description="Email address"
        >
          <b-form-input
            id="email"
            v-model="form.email"
            type="email"
            required
            :placeholder="`someone@somewhere.something`"
          ></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="email"></field-error>

        <b-form-group
          id="input-group-4"
          label="Phone Number: *"
          label-for="phone_number"
          description="Complete phone number with country code e.g. 254722222222"
        >
          <b-form-input
            id="phone_number"
            v-model="form.phone_number"
            type="text"
            required
            placeholder="254722222222"
          ></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="phone_number"></field-error>

        <b-form-group
          id="input-group-5"
          label="Title: *"
          label-for="title"
          description="Subject message"
        >
          <b-form-input
            id="title"
            v-model="form.title"
            type="text"
            required
            :placeholder="`Briefly`"
          ></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="title"></field-error>

        <b-form-group
          id="input-group-3"
          label="Message: *"
          label-for="message"
          description="Write something complete"
        >
          <b-form-textarea
            id="message"
            v-model="form.contents"
            required
            placeholder="..."
          ></b-form-textarea>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="contents"></field-error>
        <p class="py-2">
          <b-button v-if="!loading" variant="info" @click="submit" class="text-white"
            >Send</b-button
          >
          <i v-else class="fa fa-spinner"></i>
        </p>
      </div>
    </div>
    <div v-else class="mb-5 pb-5 row">
      <div class="col-md-6 offset-md-3 py-4">
        <h4>Contact Received <i class="fa fa-check"></i></h4>
        <p>
          We have received your message and will get back to you shortly. Thank you for your
          patience.
        </p>
        <p><b-button variant="success" @click="submitted = false"> Send New Message</b-button></p>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>

<script>
  export default {
    props: [],
    data() {
      return {
        form: {
          title: null,
          name: null,
          email: null,
          phone_number: null,
          contents: null,
        },
        errors: [],
        loading: false,
        max: 100,
        submitted: false,
      };
    },
    computed: {
      value() {
        let total = 0;
        if (this.form.name) {
          total += 20;
        }
        if (this.form.email) {
          total += 20;
        }
        if (this.form.phone_number && this.form.phone_number.length > 10) {
          total += 20;
        }

        if (this.form.title) {
          total += 20;
        }

        if (this.form.contents && this.form.contents.length > 5) {
          total += 20;
        }

        return total;
      },
    },
    methods: {
      submit() {
        this.loading = true;
        this.errors = [];
        axios
          .post('/api/v1/contact', this.form)
          .then(results => {
            this.$root.$emit(
              'sendMessage',
              `I have received your message and will respond accordingly. ID ${results.data.id}`,
              'success',
            );
            this.submitted = results;
            this.form.email = this.form.name = this.form.title = this.form.phone_number = this.form.contents = null;
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to send contact !');
          })
          .finally(() => {
            this.loading = false;
          });
      },
    },
    created() {},
  };
</script>
