<template>
  <b-card>
    <b-card-title>
      <span>Categories</span>
      <b-button class="float-right" size="sm" variant="dark" v-b-modal="'create-category-modal'"
        ><i class="fa fa-plus"></i> New</b-button
      >
      <b-modal
        ok-only
        ref="create-category-modal"
        id="create-category-modal"
        title="New Category"
        @ok="createCategory"
      >
        <b-form-group id="input-group-1" label="Name: *" label-for="name">
          <b-form-input
            name="name"
            v-model="form.name"
            type="text"
            required
            @keyup="generateSlug"
          ></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="name"></field-error>

        <b-form-group id="input-group-1" label="Slug: *" label-for="slug">
          <b-form-input name="slug" v-model="form.slug" type="text" required></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="slug"></field-error>

        <b-form-group id="input-group-1" label="Description:" label-for="description">
          <textarea
            name="description"
            class="form-control"
            v-model="form.description"
            rows="3"
          ></textarea>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="description"></field-error>
      </b-modal>
    </b-card-title>

    <b-card-text>
      <div>
        <label class="typo__label">Categories</label>
        <multiselect
          v-model="selectedCategories"
          deselect-label="Remove category"
          track-by="value"
          :custom-label="nameAndSlug"
          :multiple="true"
          placeholder="Select one"
          :options="allCategories"
          :searchable="true"
          :allow-empty="true"
          @input="selected"
        >
          <template slot="singleLabel" slot-scope="{ option }"
            ><strong>{{ option.name }}</strong></template
          >
        </multiselect>
        <field-error :solid="false" :errors="errors" field="categories"></field-error>
      </div>
    </b-card-text>
  </b-card>
</template>

<script>
  export default {
    components: {},
    props: ['product', 'errors'],
    data() {
      return {
        categories: [],
        form: {
          name: null,
          slug: null,
          description: null,
        },
        selectedCategories: [],
      };
    },
    created() {
      this.loadCategories();
      this.selectedCategories = this.product.product_categories.map(pc => {
        return { value: pc.category_id, text: pc.category.name, slug: pc.category.slug };
      });
    },
    computed: {
      allCategories() {
        return this.categories.map(c => {
          return { value: c.id, text: c.name, slug: c.slug };
        });
      },
    },
    methods: {
      loadCategories() {
        axios
          .get('/api/v1/categories')
          .then(results => {
            this.categories = results.data.data;
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to get categories!');
          });
      },
      createCategory() {
        axios
          .post('/api/v1/admin/categories', this.form)
          .then(response => {
            this.$root.$emit('sendMessage', 'Category created successfully', 'success');
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to create Category');
          })
          .finally(() => {
            this.loadCategories();
          });
      },
      generateSlug() {
        this.form.slug = this.$root.$slugify(this.form.name);
      },
      nameAndSlug({ text, slug }) {
        return `${text} — [${slug}]`;
      },
      selected() {
        this.$emit('selected', this.selectedCategories);
      },
    },
  };
</script>
