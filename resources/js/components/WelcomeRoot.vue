<template>
  <div>
    <nav-root></nav-root>
    <div class="row py-5 mb-5">
      <div
        class="col-md-10 offset-md-1
      "
      >
        <b-jumbotron bg-variant="info" text-variant="white" border-variant="dark">
          <template #header>{{ $root.$store.state.config.name }}</template>

          <template #lead>
            This is a simple hero unit, a simple jumbotron-style component for calling extra
            attention to featured content or information.
          </template>

          <hr class="my-4" />

          <p>
            It uses utility classes for typography and spacing to space content out within the
            larger container.
          </p>
          <p>
            <clipboard content="copy me" variant="dark"></clipboard>
          </p>
          <p>
            <phone-number></phone-number>
          </p>
        </b-jumbotron>
      </div>
    </div>
    <page-footer></page-footer>
  </div>
</template>
