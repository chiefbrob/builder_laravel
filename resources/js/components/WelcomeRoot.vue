<template>
  <div>
    <div class="row mt-1">
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
            <b-button variant="light" href="https://github.com/chiefbrob/builder_laravel">
              <i class="fa-brands fa-github"></i> Edit on GitHub</b-button
            >
            <clipboard content="copy me" variant="dark"></clipboard>
          </p>
          <p>Login as Admin using <u>test</u> and password <u>password</u></p>
        </b-jumbotron>
      </div>
    </div>
  </div>
</template>

<script></script>
