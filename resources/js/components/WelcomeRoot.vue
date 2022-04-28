<template>
  <div>
    <nav-root></nav-root>
    <div class="row py-5 mb-5" v-for="i in 5" v-bind:key="i">
      <div class="col-md-3 offset-md-1">
        <b-card
          title="Card Title"
          img-src="https://picsum.photos/600/300/?image=25"
          img-alt="Image"
          img-top
          tag="article"
          class="mb-2"
        >
          <b-card-text>
            Some quick example text to build on the card title and make up the bulk of the card's
            content.
          </b-card-text>

          <b-button href="#" variant="primary">Go somewhere</b-button>
        </b-card>
      </div>
      <div class="col-md-7">
        <b-tabs content-class="mt-3" align="center">
          <b-tab title="First" active><p>I'm the first tab</p></b-tab>
          <b-tab title="Second"><p>I'm the second tab</p></b-tab>
          <b-tab title="Disabled" disabled><p>I'm a disabled tab!</p></b-tab>
        </b-tabs>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>
