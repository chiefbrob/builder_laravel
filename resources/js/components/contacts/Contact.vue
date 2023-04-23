<template>
  <b-card>
    <b-card-title
      >{{ contact.title }}
      <b-badge class="float-right" :variant="variantFor(contact.status)">
        {{ contact.status }}</b-badge
      >
    </b-card-title>
    <b-card-sub-title v-if="admin">
      <a v-if="contact.phone_number" :href="`tel:+${contact.phone_number}`"
        ><i class="fa fa-phone"> +{{ contact.phone_number }}</i></a
      >
      <br />
      <a :href="`mailto:${contact.email}`"><i class="fa fa-envelope"></i> {{ contact.email }} </a>
      <div v-if="!loading">
        <b-input-group prepend="New Status" class="mt-3">
          <b-form-select
            @input="statusSelected"
            :options="contactStatuses(contact.status)"
          ></b-form-select>
        </b-input-group>
      </div>
      <div v-else><i class="fa fa-spinner"></i> Loading</div>
    </b-card-sub-title>
    <b-card-text>
      {{ contact.contents }}
    </b-card-text>
    <b-card-text class="small text-muted">
      Created: {{ contact.created_at | relative }}

      <div v-if="contact.created_at !== contact.updated_at">
        Last updated <span> {{ contact.updated_at | relative }} </span>
      </div>
    </b-card-text>
  </b-card>
</template>

<script>
  export default {
    props: ['contact'],
    data() {
      return {
        loading: false,
        admin: this.$store.getters.user.admin,
      };
    },
    methods: {
      variantFor(status) {
        if (status === 'PENDING') {
          return 'danger';
        }

        if (status === 'QUEUED') {
          return 'warning';
        }

        if (status === 'IN_PROGRESS') {
          return 'info';
        }

        if (status === 'COMPLETE') {
          return 'success';
        }
      },
      contactStatuses(currentstatus) {
        let statuses = ['PENDING', 'QUEUED', 'IN_PROGRESS', 'COMPLETE'];
        statuses = statuses.map(status => {
          let s = {
            value: status,
            text: status,
          };
          if (status === currentstatus) {
            s.disabled = true;
          }
          return s;
        });
        statuses.unshift({ value: null, text: 'Select new Status', disabled: true });
        return statuses;
      },
      statusSelected(status) {
        this.loading = true;
        axios
          .put(`/api/v1/contacts/`, {
            contact_id: this.contact.id,
            status: status,
          })
          .then(results => {
            this.$root.$emit('sendMessage', 'Contact Updated', 'success');
            this.$emit('reloadContacts');
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to update contact');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
