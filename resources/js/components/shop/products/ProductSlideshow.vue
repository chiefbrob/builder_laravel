<template>
  <b-carousel
    id="carousel-1"
    v-model="slide"
    :interval="4000 + Math.floor(Math.random() * 900)"
    controls
    indicators
    background="#ababab"
    img-width="1024"
    img-height="480"
    style="text-shadow: 1px 1px 2px #333;"
    @sliding-start="onSlideStart"
    @sliding-end="onSlideEnd"
  >
    <b-carousel-slide
      caption=""
      :text="full ? product.description : ''"
      :img-src="photo"
    ></b-carousel-slide>

    <!-- <b-carousel-slide
      :img-src="'/storage/images/products/' + photo"
      v-for="(photo, i) in vehicle.photos"
      :key="photo"
    >
      <h1 v-if="full">{{ i % 2 == 0 ? make : model }}</h1>
    </b-carousel-slide> -->

    <b-carousel-slide
      v-for="variant in variantWithImages"
      :key="variant.id"
      :img-src="`/storage/images/product-variants/${variant.photo}`"
    >
      <p>
        <span class="black-bkg px-2">{{ variant.name }}</span>
      </p>
    </b-carousel-slide>

    <b-carousel-slide img-src="/images/shop/for-sale-image.jpg"> </b-carousel-slide>
  </b-carousel>
</template>

<script>
  export default {
    props: {
      product: {
        required: true,
      },
      full: {
        required: false,
        default: true,
      },
    },
    data() {
      return {
        slide: 0,
        sliding: null,
      };
    },
    computed: {
      photo() {
        return this.product.photo
          ? `/storage/images/products/${this.product.photo}`
          : '/images/shop/for-sale-image.jpg';
      },
      variantWithImages() {
        return this.product.product_variants.filter(variant => {
          return variant.photo !== null;
        });
      },
    },
    methods: {
      onSlideStart(slide) {
        this.sliding = true;
      },
      onSlideEnd(slide) {
        this.sliding = false;
      },
    },
  };
</script>
