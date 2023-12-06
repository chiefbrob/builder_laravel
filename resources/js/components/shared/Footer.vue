<template>
  <!-- Footer -->
  <footer id="footer" class="page-footer font-small cyan darken-3" style="z-index: 150">
    <!-- Footer Elements -->
    <div class="container" v-if="false">
      <!-- Grid row-->
      <div class="row">
        <!-- Grid column -->
        <div class="col-md-12 py-2">
          <div class="mb-1 flex-center text-center">
            <!-- Facebook -->
            <a class="fb-ic">
              <i class="fab fa-facebook-f fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
            </a>
            <!-- Twitter -->
            <a class="tw-ic">
              <i class="fab fa-twitter fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
            </a>
            <!-- Google +-->
            <a class="gplus-ic">
              <i class="fab fa-whatsapp fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
            </a>
            <!--Linkedin -->
            <a class="li-ic">
              <i class="fab fa-linkedin-in fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
            </a>
            <!--Instagram-->
            <a class="ins-ic">
              <i class="fab fa-instagram fa-lg white-text mr-md-5 mr-3 fa-2x"> </i>
            </a>
          </div>
        </div>
        <!-- Grid column -->
      </div>
      <!-- Grid row-->
    </div>
    <!-- Footer Elements -->

    <!-- Copyright -->
    <div class="footer-copyright text-center pb-2">
      © {{ today.getFullYear() }} {{ $store.getters.config.name }}
    </div>
    <!-- Copyright -->
  </footer>
  <!-- Footer -->
</template>

<script>
  export default {
    data() {
      return {
        today: new Date(),
      };
    },
  };
</script>

<style scoped>
  #footer {
    position: fixed;
    bottom: 0;
    width: 100%;
    padding: 0;
    background-color: white;
  }
</style>
