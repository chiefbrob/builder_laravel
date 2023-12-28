<template>
  <div class="container">
    <div class="row">
      <div class="col-md-4 offset-md-4">
        <b-card
          title="Snap, We Could't find it!"
          img-src="/images/pages/404.webp"
          img-alt="404 Error"
          img-top
          tag="article"
          class="mb-2"
        >
          <b-card-text>
            We're pretty sure this is an error on your side so check domain for typos or search
            different keywords
          </b-card-text>

          <b-card-text>
            <b-button
              size="sm"
              class="text-white"
              @click="$router.push({ name: 'home' })"
              variant="info"
              >Go Home</b-button
            >
            <b-button size="sm" @click="$router.push({ name: 'contact' })" variant="link"
              >Contact us</b-button
            >
          </b-card-text>
        </b-card>
      </div>
    </div>
  </div>
</template>

<script>
  export default {};
</script>
