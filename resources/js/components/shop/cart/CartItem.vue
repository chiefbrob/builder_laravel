<template>
  <b-card style="padding: 0;">
    <b-card-text class="pointer" @click="showVariant" style="margin: 0; padding: 0">
      {{ item.product_variant.name.substr(0, 15)
      }}{{ item.product_variant.name.length > 15 ? '...' : '' }}
    </b-card-text>

    <b-card-img
      style=""
      class="pointer"
      @click="showVariant"
      :src="
        item.product_variant.photo
          ? `/storage/images/product-variants/${item.product_variant.photo}`
          : `/storage/images/products/${item.product.photo}`
      "
    ></b-card-img>

    <b-card-text class="pt-1">
      <p>
        <b-button
          @click="removeSingleItem"
          :disabled="loading || item.quantity === 1"
          size="sm"
          variant="info"
          class="text-white py-0"
          >-
        </b-button>
        {{ item.quantity }}
        <b-button
          size="sm"
          variant="info"
          class="text-white py-0"
          @click="addItemToCart"
          :disabled="
            item.quantity === item.product_variant.quantity ||
              item.product_variant.quantity === 0 ||
              loading ||
              item.product_variant.quantity === 1
          "
          >+
        </b-button>
        <b-badge :variant="badgeVariant" class="text-white">{{ badgeText }}</b-badge>
        <b-button
          :disabled="loading"
          @click="removeAllItem"
          class="float-right py-0"
          variant="danger"
          size="sm"
          ><i class="fa fa-trash-can"></i
        ></b-button></p
    ></b-card-text>
    <b-card-text class="pointer" @click="showProduct">{{ item.product.name }}</b-card-text>
    <b-card-footer>{{ (item.product.price * item.quantity) | kes }}</b-card-footer>
  </b-card>
</template>

<script>
  export default {
    props: {
      item: {
        required: true,
      },
      full: {
        required: false,
        default: true,
      },
    },
    data() {
      return {
        loading: false,
      };
    },
    computed: {
      badgeVariant() {
        switch (this.item.product_variant.quantity) {
          case 0:
            return 'default';
            break;
          case 1:
          case 2:
          case 3:
            return 'danger';

          default:
            return `info`;
            break;
        }
      },
      badgeText() {
        const quantity = this.item.product_variant.quantity;
        if (quantity === 0) {
          return 'out of stock';
        }
        if (quantity === 1) {
          return 'last one!';
        }
        if (quantity <= 3) {
          return 'almost 3 left';
        }
        if (quantity >= 20) {
          return 'over 19 in stock';
        }
        return `over ${quantity - 1} in stock`;
      },
    },
    methods: {
      showProduct() {
        this.$router.push({
          name: 'view-product',
          params: {
            slug: this.item.product.slug,
          },
        });
      },
      showVariant() {
        this.$router.push({
          name: 'view-product-variant',
          params: {
            slug: this.item.product.slug,
            variant_id: this.item.id,
          },
        });
      },
      removeItem(count = 1) {
        this.loading = true;
        const name = this.item.product_variant.name;
        const id = this.item.id;
        axios
          .delete(`/api/v1/cart/`, { params: { product_variant_id: id, quantity: count } })
          .then(results => {
            const msg = `${count} of ${name} removed from cart`;
            this.$store.commit('shop/updateCart', results.data.cart);
            this.$root.$emit('sendMessage', msg, 'success');
          })
          .catch(error => {
            this.$root.$emit('sendMessage', `Failed to remove ${name} from cart`);
          })
          .finally(f => {
            this.loading = false;
          });
      },
      removeSingleItem() {
        this.removeItem();
      },
      removeAllItem() {
        this.removeItem(this.item.quantity);
      },
      addItemToCart() {
        const id = this.item.id;
        const quantity = 1;
        const name = this.item.product_variant.name;
        this.loading = true;
        axios
          .post(`/api/v1/cart`, {
            product_variant_id: id,
            quantity: quantity,
          })
          .then(results => {
            this.$root.$emit('sendMessage', `Added ${name} to Cart`, 'success');
            this.$store.commit('shop/updateCart', results.data.cart);
          })
          .catch(error => {
            let dm = `Failed to add ${name} to Cart`;
            this.$root.$emit('sendMessage', dm);
          })
          .finally(f => {
            this.loading = false;
          });
      },
    },
  };
</script>
