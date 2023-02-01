<template>
  <div>
    <nav-root></nav-root>
    <div class="row py-5 mb-5">
      <div class="col-md-10 offset-md-1">
        <div class="jumbotron">
          <h1 class="display-4">Hello, world!</h1>
          <p class="lead">
            This is a simple hero unit, a simple jumbotron-style component for calling extra
            attention to featured content or information.
          </p>
          <hr class="my-4" />
          <p>
            It uses utility classes for typography and spacing to space content out within the
            larger container.
          </p>
          <p class="lead">
            <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            <button class="btn btn-danger">Action</button>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import NavRoot from './nav/NavRoot';
  export default {
    components: {
      NavRoot,
    },
  };
</script>
