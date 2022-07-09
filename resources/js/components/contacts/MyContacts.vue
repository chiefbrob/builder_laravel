<template>
  <div>
    <h4>My Contacts</h4>
    <div>
      <p v-if="loading"><i class="fa fa-spinner"></i> Loading</p>
      <div v-else>
        <b-list-group>
          <b-list-group-item
            v-for="(item, i) in items"
            v-bind:key="item.id"
            href="#"
            :variant="i % 2 === 0 ? 'light' : 'dark'"
          >
            <h5>
              {{ item.title }}
              <small v-if="admin">
                <a :href="`tel:+${item.phone_number}`"><i class="fa fa-phone"></i></a>
                <a :href="`mailto:+${item.email}`"><i class="fa fa-envelope"></i></a>
              </small>
              <span class="float-right">
                <b-badge :variant="variantFor(item.status)" v-text="item.status"></b-badge>
              </span>
            </h5>
            <p>{{ item.contents }}</p>
            <p>
              Created: {{ item.created_at | relative }} | Last Update:
              {{ item.updated_at | relative }}
            </p>
          </b-list-group-item>
          <b-list-group-item v-if="items.length == 0">No Contacts Sent</b-list-group-item>
        </b-list-group>
        <b-pagination
          @input="pageChanged"
          v-model="meta.currentPage"
          v-if="meta.lastPage > 1"
          :total-rows="meta.total"
          :per-page="meta.perPage"
          aria-controls="admin-users"
        ></b-pagination>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        variants: ['light', 'dark'],
        items: [],
        loading: true,
        meta: {
          currentPage: 1,
          total: 0,
          perPage: 15,
          lastPage: 1,
        },
        admin: this.$store.getters.user.admin,
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
      loadContacts() {
        axios
          .get(`/api/v1/contacts/?page=${this.meta.currentPage}`)
          .then(results => {
            this.items = results.data.data;
            this.meta.currentPage = results.data.current_page;
            this.meta.total = results.data.total;
            this.meta.perPage = results.data.per_page;
            this.meta.lastPage = results.data.last_page;
          })
          .catch(error => {
            console.log(error);
            this.$root.$emit('sendMessage', 'Failed to load contacts');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
