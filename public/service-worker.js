importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js');

if (workbox) {
  workbox.setConfig({ debug: false });

  workbox.routing.registerRoute(
    // Cache image files.
    /\.(?:png|jpg|jpeg|svg|gif)$/,
    // Use the cache if it's available.
    new workbox.strategies.CacheFirst({
      // Use a custom cache name.
      cacheName: 'image-cache',
      plugins: [
        new workbox.expiration.Plugin({
          // Cache only 20 images.
          maxEntries: 200,
          // Cache for a maximum of 30 days.
          maxAgeSeconds: 30 * 24 * 60 * 60,
        }),
      ],
    }),
  );
} else {
  console.log(`Workbox didn't load 😬`);
}
