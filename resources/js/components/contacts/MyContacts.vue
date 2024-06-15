<template>
  <div>
    <h4>
      My Contacts
    </h4>
    <div class="row pb-2">
      <contact-state-selector class="col-md-4" @updated="stateUpdated"></contact-state-selector>
    </div>
    <div>
      <p v-if="loading"><i class="fa fa-spinner"></i> Loading</p>
      <b-card-group columns v-else>
        <contact
          @reloadContacts="loadContacts"
          v-for="(item, i) in items"
          v-bind:key="i"
          :contact="item"
        />
      </b-card-group>
      <div v-if="meta.total === 0">
        No contacts to display
      </div>
      <div v-if="meta.total > 0">
        <b-pagination
          id="contact-pages"
          @input="pageChanged"
          v-model="meta.currentPage"
          v-if="meta.lastPage > 1"
          :total-rows="meta.total"
          :per-page="meta.perPage"
          aria-controls="contact-pages"
        ></b-pagination>
      </div>
    </div>
  </div>
</template>

<script>
  import Contact from './Contact.vue';
  import ContactStateSelector from './ContactStateSelector.vue';
  export default {
    components: { Contact, ContactStateSelector },
    data() {
      return {
        variants: ['light', 'dark'],
        items: [],
        loading: true,
        statuses: [],
        meta: {
          currentPage: 1,
          total: 0,
          perPage: 15,
          lastPage: 1,
        },
      };
    },

    mounted() {
      this.loadContacts();
    },
    methods: {
      pageChanged(page) {
        this.currentPage = page;
        this.loadContacts();
      },

      loadContacts() {
        this.loading = true;
        axios
          .get(`/api/v1/contacts/`, {
            params: {
              statuses: this.statuses,
              page: this.meta.currentPage,
            },
          })
          .then(results => {
            this.items = results.data.data;
            this.meta.currentPage = results.data.current_page;
            this.meta.total = results.data.total;
            this.meta.perPage = results.data.per_page;
            this.meta.lastPage = results.data.last_page;
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to load contacts');
          })
          .finally(f => {
            this.loading = false;
          });
      },
      stateUpdated(statuses) {
        this.statuses = statuses;
        this.loadContacts();
      },
    },
  };
</script>
