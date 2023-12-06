<template>
  <div>
    <div class="mb-5 mt-2 pb-5 mt-2 row">
      <div class="col-md-10 offset-md-1">
        <h4>Search '{{ form.query }}'</h4>
        <div v-if="loading">
          <p><i class="fa fa-spinner"></i> Loading...</p>
        </div>
        <div v-if="results" class="row">
          <product
            v-for="product in results.products"
            v-bind:key="`product` + product.id"
            :full="false"
            :product="product"
            class="col-md-4"
          ></product>
          <blog
            v-for="blog in results.blogs"
            :blog="blog"
            :full="false"
            class="col-md-4"
            v-bind:key="`blog` + blog.id"
          ></blog>

          <team
            v-if="results.teams"
            v-for="team in results.teams"
            v-bind:key="`team` + team.id"
            class="col-md-4"
            :full="false"
            :team="team"
          ></team>
          <task
            class="col-md-4"
            v-for="task in results.tasks"
            :task="task"
            :full="false"
            v-bind:key="`task` + task.id"
          ></task>
        </div>
        <div v-if="nothingToShow">
          <p><i class="fa fa-warning"></i> No results</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import Blog from '../blog/Blog.vue';
  import Product from '../shop/products/Product.vue';
  import Team from '../projects/teams/Team.vue';
  import Task from '../projects/tasks/Task.vue';
  export default {
    components: { Blog, Product, Task, Team },
    data() {
      return {
        form: {
          query: this.$route.query.query,
        },
        loading: true,
        results: [],
      };
    },
    computed: {
      nothingToShow() {
        //
      },
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
