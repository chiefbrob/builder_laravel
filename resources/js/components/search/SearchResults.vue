<template>
  <div>
    <div class="mb-5 mt-2 pb-5 mt-2 row">
      <div class="col-md-10 offset-md-1">
        <h4>Search '{{ form.query }}'</h4>
        <div v-if="loading">
          <p><i class="fa fa-spinner"></i> Loading...</p>
        </div>
        <div v-if="!loading && results.length === 0">
          <p><i class="fa fa-warning"></i> No results</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        form: {
          query: this.$route.query.query,
        },
        loading: true,
        results: [],
      };
    },
    created() {
      this.search();
      this.$root.$on('search', data => {
        this.form.query = data;
        this.search();
      });
    },
    methods: {
      search() {
        axios
          .post(`/api/v1/search/`, this.form)
          .then(results => {
            this.results = results.data;
          })
          .catch(error => {
            // this.$root.$emit('sendMessage', `Search for '${this.form.query}' Failed!`, 'danger');
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
