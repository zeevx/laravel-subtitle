<template>
  <div>
    <div class="row">
      <div class="col-md-8 mb-5">
        <h1>New Subtitles</h1>
        <div class="list-group mb-2" v-for="movie in movies.data" :key="movie.id">
          <a href="#!" class="list-group-item list-group-item-action flex-column align-items-start">
            <div class="row">
              <div class="col-md-2 col-4">
                <img class="d-flex mr-3 img-thumbnail" :src="/storage/ + movie.image" alt="movie thumbnail">
              </div>
              <div class="col-md-10 col-8">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ movie.movie_name }}</h5>
                  <small>{{ movie.created_at }}</small>
                </div>
                <p class="mb-1" style="color: #601a11;">{{ movie.description }}</p>
                <small>IMDB Rating: {{ movie.IMDB_rating }}</small> | <small v-for="genre in movie.genres" :key="genre.id" class="font-weight-bold">{{ genre.genre_name }},</small>
              </div>
            </div>
          </a>
        </div>
        <pagination :data="movies">
          <span slot="prev-nav">&lt; Previous</span>
          <span slot="next-nav">Next &gt;</span>
        </pagination>
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
    return { title: this.$t('subtitles') }
  },

  data: () => ({
    title: window.config.appName,
    genres: {},
    movies: {}
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  }),
  created () {
    this.fetch()
  },
  methods: {
    async fetch (page = 1) {
      // eslint-disable-next-line no-unused-expressions
      this.axios
        .get('/api/genres')
        .then(response => {
          this.genres = response.data
          // eslint-disable-next-line no-sequences
        }),
      this.axios
        .get('/api/movies?page=' + page)
        .then(response => {
          this.movies = response.data
        })
    }
  }
}
</script>
<style>
  .img-thumbnail {
    width: 100px;
    height: 100px;
  }
</style>
