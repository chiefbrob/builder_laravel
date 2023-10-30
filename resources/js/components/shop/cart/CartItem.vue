<template>
  <b-card style="padding: 0;">
    <b-card-text class="pointer" @click="showVariant" style="margin: 0; padding: 0">
      {{ item.product_variant.name.substr(0, 15)
      }}{{ item.product_variant.name.length > 15 ? '...' : '' }}
    </b-card-text>

    <b-card-img
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
        <b-button v-if="item.quantity > 1" size="sm" variant="info" class="text-white py-0"
          >-
        </b-button>
        {{ item.quantity }}
        <b-button
          size="sm"
          variant="info"
          v-if="item.product_variant.quantity > 1"
          class="text-white py-0"
          :disabled="
            item.quantity === item.product_variant.quantity || item.product_variant.quantity === 0
          "
          >+
        </b-button>
        <b-badge :variant="badgeVariant" class="text-white">{{ badgeText }}</b-badge>
        <b-button class="float-right py-0" variant="danger" size="sm"
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
        switch (this.item.product_variant.quantity) {
          case 0:
            return 'out of stock';
            break;
          case 1:
            return 'last one!';
          case 2:
          case 3:
            return 'less than 3 left';

          default:
            return `over ${this.item.product_variant.quantity - 1} available`;
            break;
        }
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
    },
  };
</script>
