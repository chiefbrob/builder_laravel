<template>
  <div>
    <footer class="page-footer font-small blue pt-4">
      <div class="container-fluid text-center text-md-left">
        <div class="row">
          <div class="col-md-6 mt-md-0 mt-3">
            <h5 class="text-uppercase">Footer Subtitle</h5>
            <p>
              Loremp ipsum dolor sit amet
            </p>
          </div>

          <hr class="clearfix w-100 d-md-none pb-3" />

          <div class="col-md-3 mb-md-0 mb-3">
            <h5 class="text-uppercase">Explore</h5>

            <ul class="list-unstyled">
              <li>
                <a href="#!">Friends</a>
              </li>
              <li>
                <a href="#!">Chat</a>
              </li>
              <li>
                <a href="#!">Map</a>
              </li>
              <li>
                <a href="#!">Events</a>
              </li>
            </ul>
          </div>
          <div class="col-md-3 mb-md-0 mb-3">
            <!-- Links -->
            <h5 class="text-uppercase">Company</h5>

            <ul class="list-unstyled">
              <li>
                <a href="#!">About</a>
              </li>
              <li>
                <a href="#!">Contact Us</a>
              </li>
              <li>
                <a href="#!">Privacy Policy</a>
              </li>
              <li>
                <a href="#!">Terms & Conditions</a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="footer-copyright text-center py-3">
        © <span>{{ new Date().getFullYear() }}</span> Copyright:
        <a :href="url">Chief's Builder</a>
      </div>
    </footer>
  </div>
</template>

<script>
  export default {
    computed: {
      url() {
        return window.location;
      },
    },
  };
</script>
