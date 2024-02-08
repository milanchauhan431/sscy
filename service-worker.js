//--------------------------------------------------------------------------
// You can find dozens of practical, detailed, and working examples of 
// service worker usage on https://github.com/mozilla/serviceworker-cookbook
//--------------------------------------------------------------------------

// Version
var VERSION = 1.3;

// Cache name
var CACHE_NAME = 'cache-version-' + VERSION;

// Files
var REQUIRED_FILES = [
  'index.php'
];

caches.keys().then(function(names) {
  for (let name of names)
    if(CACHE_NAME != name){caches.delete(name);}
});

caches.keys().then(function(names) {
  for (let name of names)
    console.log(name);
});

self.addEventListener('install', function (event) {
  // Perform install step:  loading each required file into cache
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function (cache) {
        // Add all offline dependencies to the cache
        return cache.addAll(REQUIRED_FILES);
      })
      .then(function () {
        return self.skipWaiting();
      })
  );
});

self.addEventListener('fetch', function (event) {
  event.respondWith(
    caches.match(event.request)
      .then(function (response) {
        // Cache hit - return the response from the cached version
        if (response) {
          return response;
        }
        // Not in cache - return the result from the live server
        // `fetch` is essentially a "fallback"
        return fetch(event.request);
      }
      )
  );
});

self.addEventListener('activate', function (event) {
  // Calling claim() to force a "controllerchange" event on navigator.serviceWorker
  //event.waitUntil(self.clients.claim());
  var cacheKeeplist = [CACHE_NAME];
  event.waitUntil(
    caches.keys().then( keyList => {
        return Promise.all(keyList.map( key => {
            if (cacheKeeplist.indexOf(key) === -1) {
                return caches.delete(key);
            }
        }));
    })
  .then(self.clients.claim())); 
});