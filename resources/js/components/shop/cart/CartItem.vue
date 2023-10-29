<template>
  <b-card style="padding: 0;">
    <b-card-text>
      {{ item.product_variant.name.substr(0, 15)
      }}{{ item.product_variant.name.length > 15 ? '...' : '' }}
    </b-card-text>
    <b-card-img
      :src="
        item.product_variant.photo
          ? `/storage/images/product-variants/${item.product_variant.photo}`
          : `/storage/images/products/${item.product.photo}`
      "
    ></b-card-img>
    <b-card-text class="pt-1">
      <p>
        <b-button size="sm" variant="info" class="text-white">- </b-button>
        {{ item.quantity }}
        <b-button
          size="sm"
          variant="info"
          class="text-white"
          :disabled="
            item.quantity === item.product_variant.quantity || item.product_variant.quantity === 0
          "
          >+
        </b-button>
        <b-badge :variant="badgeVariant" class="text-white">{{ badgeText }}</b-badge>
        <b-button class="float-right" variant="danger" size="sm"
          ><i class="fa fa-trash-can"></i
        ></b-button></p
    ></b-card-text>
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
        return 'info';
      },
      badgeText() {
        switch (this.item.product_variant.quantity) {
          case 0:
            return 'out of stock';
            break;
          case 1:
            return 'last one';
          case 2:
          case 3:
            return 'less than 3 left';

          default:
            return `over ${this.item.product_variant.quantity - 1} available`;
            break;
        }
      },
      lastOne() {
        return this.item.product_variant.quantity === 1;
      },
      lastThree() {
        return this.item.product_variant.quantity > 1 && this.item.product_variant.quantity <= 3;
      },
      outOfStock() {
        return this.item.product_variant.quantity === 0;
      },
    },
  };
</script>
