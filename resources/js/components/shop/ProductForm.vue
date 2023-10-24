<template>
  <div>
    <form class="py-3 row" enctype="multipart/form-data" @submit.prevent="submitForm" method="POST">
      <div class="col-md-12">
        <b-form-group id="input-group-1" label="Name: *" label-for="name">
          <b-form-input
            id="name"
            v-model="form.name"
            type="text"
            @keyup="createSlug"
            required
          ></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="name"></field-error>

        <b-form-group id="input-group-2" label="Slug: *" label-for="slug">
          <b-form-input id="slug" v-model="form.slug" type="text" required></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="slug"></field-error>

        <div class="row">
          <div class="col-md-6">
            <b-form-group id="input-group-3" label="Price: *" label-for="price">
              <b-form-input
                id="price"
                v-model="form.price"
                type="number"
                step="0"
                required
              ></b-form-input>
            </b-form-group>
            <field-error :solid="false" :errors="errors" field="price"></field-error>
          </div>
          <div class="col-md-6">
            <b-form-group id="input-group-6" label="Quantity: *" label-for="quantity">
              <b-form-input
                id="quantity"
                v-model="form.quantity"
                type="number"
                step="0"
                required
              ></b-form-input>
            </b-form-group>
            <field-error :solid="false" :errors="errors" field="quantity"></field-error>
          </div>
        </div>

        <b-form-group label="Photo: *" label-cols-sm="2">
          <b-form-file
            @change="imageUpdated"
            id="photo"
            size="sm"
            accept=".jpg, .jpeg"
          ></b-form-file>
        </b-form-group>

        <field-error :solid="false" :errors="errors" field="photo"></field-error>

        <b-form-group label="Brief: *">
          <b-form-textarea
            id="description"
            maxlength="200"
            v-model="form.description"
            rows="2"
          ></b-form-textarea>
        </b-form-group>

        <field-error :solid="false" :errors="errors" field="description"></field-error>

        <text-editor
          :contents="product ? product.long_description : ''"
          @contentsUpdated="longDescriptionUpdated"
        ></text-editor>

        <field-error :solid="false" :errors="errors" field="long_description"></field-error>

        <p class="py-3">
          <input type="submit" class="btn btn-success btn-sm" text="Submit" />
          <b-button
            v-if="product"
            v-b-modal.add-product-variant
            variant="link"
            size="sm"
            class=" float-right"
            >Add Variant</b-button
          >
        </p>

        <b-modal
          no-close-on-backdrop
          no-close-on-esc
          hide-footer
          id="add-product-variant"
          title="Add Variation"
          v-if="product"
        >
          <product-variant-form :product="product"></product-variant-form>
        </b-modal>
      </div>
    </form>
  </div>
</template>

<script>
  import TextEditor from '../shared/TextEditor';
  import ProductVariantForm from './products/ProductVariantForm';
  export default {
    components: { ProductVariantForm, TextEditor },
    props: {
      url: {
        type: String,
        required: true,
      },
      product: {
        required: false,
      },
    },
    data() {
      return {
        form: {
          name: null,
          slug: null,
          price: null,
          description: null,
          photo: null,
          long_description: null,
          quantity: 1,
        },
        errors: [],
        editor: null,
      };
    },
    created() {
      this.loadProduct();
    },
    methods: {
      loadProduct() {
        if (this.product) {
          delete this.product.photo;
          this.form = { ...this.product };
          if (this.product.product_variants.length === 1) {
            this.form.quantity = this.product.product_variants[0].quantity;
          }
        }
      },
      imageUpdated(img) {
        this.form.photo = img.target.files[0];
      },
      submitForm() {
        let form = new FormData();
        if (this.form.photo) {
          form.append('photo', this.form.photo);
        }
        form.append('name', this.form.name);
        form.append('slug', this.form.slug);
        form.append('price', this.form.price);
        form.append('description', this.form.description);

        form.append('long_description', this.form.long_description);
        axios
          .post(this.url, form, {
            headers: { 'Content-Type': 'multipart/form-data' },
          })
          .then(results => {
            this.$root.$emit('sendMessage', 'Blog updated', 'success');
            setTimeout(() => {
              this.$router.push({
                name: 'view-product',
                params: {
                  slug: results.data.slug,
                },
              });
            }, 2000);
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to update blog!');
          });
      },
      createSlug() {
        this.form.slug = this.form.name
          .toLowerCase()
          .split(' ')
          .join('-');
      },
      longDescriptionUpdated(html) {
        this.form.long_description = html;
      },
    },
  };
</script>
