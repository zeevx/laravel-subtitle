<template>
  <div>
    <div class="row">
      <div class="col-md-8 mb-5">
        <h1>Most Downloaded</h1>
        <div class="list-group mb-2">
          <a href="#!" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="row">
              <div class="col-md-2 col-4">
                <img class="d-flex mr-3 img-thumbnail" src="/storage/thumbnails/test.jpg" alt="movie thumbnail">
              </div>
              <div class="col-md-10 col-8">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">Avengers: End Game</h5>
                  <small>3 days ago</small>
                </div>
                <p class="mb-1" style="color: #601a11;">Some quick example text to build on the card title
                  and make up the bulk of the card's content.</p>
                <small>IMDB Rating: 9.0</small> | <small class="font-weight-bold">Action, Romance, Comedy</small>
              </div>
            </div>
          </a>
        </div>
        <div class="list-group mb-2">
          <a href="#!" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="row">
              <div class="col-md-2 col-4">
                <img class="d-flex mr-3 img-thumbnail" src="/storage/thumbnails/test.jpg" alt="movie thumbnail">
              </div>
              <div class="col-md-10 col-8">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">Avengers: End Game</h5>
                  <small>3 days ago</small>
                </div>
                <p class="mb-1" style="color: #601a11;">Some quick example text to build on the card title
                  and make up the bulk of the card's content.</p>
                <small>IMDB Rating: 9.0</small> | <small class="font-weight-bold">Action, Romance, Comedy</small>
              </div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="border p-2 mb-3">
          <h1>Genres</h1>
          <hr>
          <ul class="list-inline">
            <li v-for="genre in genres.data" :key="genre.id" class="list-inline-item font-weight-bold">
              <a href="#" style="color: #601a11;">{{ genre.genre_name }}</a> |
            </li>
          </ul>
        </div>
        <div class="card mb-3">
          <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">
              Ads Title
            </h6>
            <p class="card-text">
              Some quick example text to build on the card title
              and make up the bulk of the card's content.
            </p>
          </div>
        </div>
        <div class="border p-2 mb-2">
          <h1>Donate</h1>
          <hr>
          <button class="btn-sm shadow m-2" style="border: none; color: white;background-color: #00BCD4; border-radius: 10px;">
            <fa :icon="['fab', 'paypal']" /> Donate on PayPal
          </button>
          <button class="btn-sm shadow m-2" style="border: none; color: white;background-color: #0c5460; border-radius: 10px;">
            <fa :icon="['fab', 'patreon']" /> Donate on Patreon
          </button>
          <button class="btn-sm shadow m-2" style="border: none; color: white;background-color: #a71d2a; border-radius: 10px;">
            <fa :icon="['fab', 'bitcoin']" /> Donate  Bitcoin
          </button>
        </div>
        <div class="card mb-3">
          <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">
              Ads Title
            </h6>
            <p class="card-text">
              Some quick example text to build on the card title
              and make up the bulk of the card's content.
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

  metaInfo () {
    return { title: this.$t('most-downloaded') }
  },

  data: () => ({
    title: window.config.appName,
    genres: {}
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  }),
  created () {
    this.fetch()
  },
  methods: {
    async fetch () {
      this.axios
        .get('/api/genres')
        .then(response => {
          this.genres = response.data
        })
    }
  }
}
</script>
