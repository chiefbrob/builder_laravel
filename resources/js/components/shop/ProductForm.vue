<template>
  <div>
    <form class="py-3 row" enctype="multipart/form-data" @submit.prevent="submitForm" method="POST">
      <div class="col-md-12">
        <b-form-group
          id="input-group-1"
          label="Name: *"
          label-for="name"
          description="Product name in full."
        >
          <b-form-input
            id="name"
            v-model="form.name"
            type="text"
            required
            :placeholder="`e.g. Green Fancy Dress`"
          ></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="name"></field-error>

        <b-form-group
          id="input-group-2"
          label="Slug: *"
          label-for="slug"
          description="Lowercase, No spaces SKU"
        >
          <b-form-input
            id="slug"
            v-model="form.slug"
            type="text"
            required
            :placeholder="`e.g. green-fancy-dress`"
          ></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="slug"></field-error>

        <b-form-group
          id="input-group-3"
          label="Price: *"
          label-for="price"
          description="Amount in KES (Kenyan Shilling)"
        >
          <b-form-input
            id="price"
            v-model="form.price"
            type="number"
            step="0"
            required
            :placeholder="`e.g. 500`"
          ></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="price"></field-error>

        <b-form-group label="Photo:" label-cols-sm="2">
          <b-form-file
            @change="imageUpdated"
            id="photo"
            size="sm"
            accept=".jpg, .jpeg"
          ></b-form-file>
        </b-form-group>

        <field-error :solid="false" :errors="errors" field="photo"></field-error>

        <b-form-group label="Description:">
          <b-form-textarea
            id="description"
            v-model="form.description"
            placeholder="Describe product completely..."
            rows="5"
          ></b-form-textarea>
        </b-form-group>

        <field-error :solid="false" :errors="errors" field="description"></field-error>

        <p class="py-3">
          <input type="submit" class="btn btn-success btn-sm" text="Submit" />
        </p>
      </div>
    </form>
  </div>
</template>

<script>
  export default {
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
        },
        errors: [],
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
    },
  };
</script>
