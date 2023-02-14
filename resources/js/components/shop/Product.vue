<template>
  <div>
    <b-card>
      <b-card-title>
        <div>
          <span :class="full ? '' : 'pointer'" @click="viewProduct">{{ product.name }}</span>
          <span v-if="admin" class="float-right ">
            <b-button
              variant="info"
              @click="$router.push({ name: 'edit-product', params: { slug: product.slug } })"
              size="sm"
              ><i class="fa fa-pen text-white"></i
            ></b-button>
            <b-button size="sm" variant="danger" v-if="full" @click="deleteProduct"
              ><i class="fa fa-trash"></i
            ></b-button>
          </span>
          <br />
          <small v-if="full"> {{ product.created_at | relative }}</small>
        </div>
      </b-card-title>

      <b-card-text v-if="full">
        <p>{{ product.description }}</p>
      </b-card-text>

      <div class="row">
        <img
          :class="full ? 'col-md-3' : 'col-md-12'"
          v-if="product.photo"
          @click="viewProduct"
          :style="full ? '' : 'cursor: pointer'"
          :src="`/storage/images/products/${product.photo}`"
          :alt="product.name"
        />
      </div>

      <b-card-text
        ><p class="my-3">
          <span class="float-right">{{ price }}</span>
          <b-button href="#" size="sm" variant="dark"
            ><i class="fa fa-shopping-cart"></i> Add to Cart</b-button
          >
        </p></b-card-text
      >
    </b-card>
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
        return 'Ksh ' + this.product.price;
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
