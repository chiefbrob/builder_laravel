<template>
  <div>
    <form class="py-3 row" enctype="multipart/form-data" @submit.prevent="submitForm" method="POST">
      <div class="col-md-12">
        <b-form-group id="input-group-1" label="Title: *" label-for="title">
          <b-form-input id="title" v-model="form.title" type="text" required></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="title"></field-error>

        <b-form-group id="input-group-2" label="Subtitle: *" label-for="subtitle">
          <b-form-input id="subtitle" v-model="form.subtitle" type="text" required></b-form-input>
        </b-form-group>
        <field-error :solid="false" :errors="errors" field="subtitle"></field-error>

        <div>
          <b-button
            v-if="!removeImage && blog && blog.default_image"
            @click="removeImage = true"
            size="sm"
            variant="danger"
            ><i class="fa fa-times"></i> Remove Image</b-button
          ><b-button v-if="removeImage" @click="removeImage = false" size="sm" variant="success"
            ><i class="fa fa-check-circle"></i> Keep Current Image</b-button
          >
        </div>

        <div v-if="blog && blog.default_image && !removeImage" class="mb-2">
          Blog has image. <br />
        </div>
        <div v-else>
          <b-form-group label="Photo:" label-cols-sm="2">
            <b-form-file
              @change="imageUpdated"
              placeholder="No photo selected"
              id="default-image"
              size="sm"
              accept=".jpg, .jpeg"
            ></b-form-file>
          </b-form-group>

          <field-error :solid="false" :errors="errors" field="default_image"></field-error>
        </div>

        <text-editor
          :contents="blog ? blog.contents : ''"
          @contentsUpdated="contentsUpdated"
        ></text-editor>

        <field-error :solid="false" :errors="errors" field="contents"></field-error>

        <p class="py-3">
          <input type="submit" class="btn btn-success btn-sm" text="Submit" />
        </p>
      </div>
    </form>
  </div>
</template>

<script>
  import TextEditor from '../shared/TextEditor.vue';
  export default {
    components: { TextEditor },
    props: {
      blog: {
        required: false,
      },
      url: {
        required: true,
      },
    },
    data() {
      return {
        errors: [],
        form: {
          title: null,
          subtitle: null,
          user_id: this.$store.getters.user.id,
          contents: null,
          default_image: null,
          blog_category_id: 1,
        },
        removeImage: false,
      };
    },
    created() {
      this.setDefaults();
    },
    methods: {
      setDefaults() {
        if (this.blog) {
          this.form.title = this.blog.title;
          this.form.subtitle = this.blog.subtitle;
          this.form.contents = this.blog.contents;
        }
      },
      imageUpdated(img) {
        this.form.default_image = img.target.files[0];
      },
      submitForm() {
        let form = new FormData();
        if (this.form.default_image) {
          form.append('default_image', this.form.default_image);
        }
        form.append('title', this.form.title);
        form.append('subtitle', this.form.subtitle);
        form.append('contents', this.form.contents);
        form.append('user_id', this.form.user_id);
        form.append('blog_category_id', this.form.blog_category_id);

        axios
          .post(this.url, form, {
            headers: { 'Content-Type': 'multipart/form-data' },
          })
          .then(results => {
            this.$root.$emit('sendMessage', 'Blog updated', 'success');
            this.$router.push({
              name: 'blog-single',
              params: {
                id: results.data.id,
                long_title: this.form.title
                  .split(' ')
                  .join('-')
                  .replace(/[^a-zA-Z0-9- ]/g, '')
                  .toLowerCase(),
              },
            });
          })
          .catch(({ response }) => {
            this.errors = response.data.errors;
            this.$root.$emit('sendMessage', 'Failed to update blog!');
          });
      },
      contentsUpdated(html) {
        this.form.contents = html;
      },
    },
  };
</script>
