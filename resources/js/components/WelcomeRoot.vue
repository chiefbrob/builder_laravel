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
            Welcome to your app. Edit this file named <b>WelcomeRoot.vue</b> in components folder.
            See <b>deploy</b> folder on instructions of how to setup for testing or production.
          </template>

          <hr class="my-4" />

          <p>
            Head over to <b>/admin/feature_flags</b> to enable features on your installation.
            Features include <b>shop</b>, <b>teams</b>, <b>languages</b>
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
