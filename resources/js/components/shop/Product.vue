<template>
  <div>
    <b-card
      :overlay="true"
      :img-src="`/storage/images/products/${product.photo}`"
      border-variant="light"
      text-variant="light"
      bg-variant="info"
    >
      <b-card-title>
        <span :class="full ? '' : 'pointer black-bkg'" @click="viewProduct">{{
          product.name
        }}</span>
      </b-card-title>
      <b-card-sub-title v-if="admin">
        <b-button
          variant="info"
          @click="$router.push({ name: 'edit-product', params: { slug: product.slug } })"
          size="sm"
          ><i class="fa fa-pen text-white"></i
        ></b-button>
        <b-button size="sm" variant="danger" @click="deleteProduct"
          ><i class="fa fa-trash"></i
        ></b-button>
      </b-card-sub-title>
      <b-card-text class="py-2">
        <b-button href="#" size="sm" variant="dark"
          ><i class="fa fa-shopping-cart"></i> Add to Cart</b-button
        >
        <span class="black-bkg float-right"> {{ product.price | kes }} </span>
      </b-card-text>

      <b-card-text v-if="full">
        <p>
          <span class="black-bkg">{{ product.description }}</span>
        </p>
      </b-card-text>
    </b-card>
    <div v-if="full">
      {{ product.long_description }}
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex';
  export default {
    props: {
      product: {
        required: true,
      },
      full: {
        default: true,
        required: false,
      },
    },
    computed: {
      ...mapState({
        shop: state => state.shop,
      }),
      user() {
        return this.$store.getters.user;
      },
      admin() {
        return this.user && this.user.admin;
      },
      price() {
        return this.product.price;
      },
    },
    methods: {
      viewProduct() {
        if (!this.full) {
          this.$store.commit('shop/updateProduct', this.product);
          this.$router.push({ name: 'view-product', params: { slug: this.product.slug } });
        }
      },
      deleteProduct() {
        axios
          .delete(`/api/v1/products/${this.product.id}`)
          .then(results => {
            this.$root.$emit('sendMessage', 'Product Deleted', 'success');
            setTimeout(() => {
              this.$router.push({ name: 'shop' });
            }, 3000);
          })
          .catch(error => {
            this.$root.$emit('sendMessage', 'Failed to delete product');
          });
      },
    },
  };
</script>
