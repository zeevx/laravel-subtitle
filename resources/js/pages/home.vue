<template>
  <div>
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div style="text-align: center;">
              <h4 class="card-title" style="color: #601a11">
                <fa :icon="['fas', 'video']" size="4x" />
              </h4>
              <h6 class="card-subtitle mb-2 text-muted">
                Movies Uploaded
              </h6>
              <h2 class="card-text">
                22
              </h2>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div style="text-align: center;">
              <h4 class="card-title" style="color: #601a11">
                <fa :icon="['fas', 'upload']" size="4x" />
              </h4>
              <h6 class="card-subtitle mb-2 text-muted">
                Subtitles Uploaded
              </h6>
              <h2 class="card-text">
                220
              </h2>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div style="text-align: center;">
              <h4 class="card-title" style="color: #601a11">
                <fa :icon="['fas', 'download']" size="4x" />
              </h4>
              <h6 class="card-subtitle mb-2 text-muted">
                Downloads
              </h6>
              <h2 class="card-text">
                26000
              </h2>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
    <card :title="$t('Recently Uploaded Movies')">
      <router-link :to="{ name: 'add-movie' }">
        <button class="btn-lg btn-outline-dark mb-3" style="border-radius: 10px">
          <fa :icon="['fa', 'film']" /> Movies
        </button>
      </router-link>
      <router-link :to="{ name: 'add-genre' }">
        <button class="btn-lg btn-outline-dark mb-3" style="border-radius: 10px">
          <fa :icon="['fa', 'star']" /> Genres
        </button>
      </router-link>
      <table class="table table-responsive-lg">
        <thead class="text-light" style="background-color: #601a11;">
          <tr>
            <th>Movie Name</th>
            <th>IMDB Rating</th>
            <th>Genre</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="movie in movies" :key="movie.id">
            <th scope="row">
              {{ movie.movie_name }}
            </th>
            <td>{{ movie.IMDB_rating }}</td>
            <td>
              <ul class="list-inline">
                <li v-for="genre in movie.genres" :key="genre.id" class="list-inline-item font-weight-bold">
                  {{ genre.genre_name }}*
                </li>
              </ul>
            </td>
            <td>
              <button class="btn-sm btn-outline-dark m-1">
                <fa :icon="['fa', 'eye']" /> View
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </card>
    <br>
    <card :title="$t('Recently Uploaded Subtitles')">
      <router-link :to="{ name: 'add-subtitle' }">
        <button class="btn-lg btn-outline-dark mb-3" style="border-radius: 10px">
          <fa :icon="['fa', 'book']" /> Subtitles
        </button>
      </router-link>
      <router-link :to="{ name: 'add-language' }">
        <button class="btn-lg btn-outline-dark mb-3" style="border-radius: 10px">
          <fa :icon="['fa', 'flag']" /> Languages
        </button>
      </router-link>
      <table class="table table-responsive-lg">
        <thead class="text-light" style="background-color: #601a11;">
          <tr>
            <th>Subtitle Name</th>
            <th>Movie</th>
            <th>Language</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="subtitle in subtitles" :key="subtitle.id">
            <th scope="row">
              {{ subtitle.name }}
            </th>
            <td>{{ subtitle.movie.movie_name }}</td>
            <td>{{ subtitle.language }}</td>
            <td>
              <button class="btn-sm btn-outline-dark m-1">
                <fa :icon="['fa', 'download']" /> Download
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </card>
  </div>
</template>

<script>
import Card from '../components/Card'

export default {
  middleware: 'auth',
  components: { Card },

  metaInfo () {
    return { title: this.$t('dashboard') }
  },
  data: () => ({
    movies: [],
    subtitles: []
  }),
  created () {
    this.fetch()
  },
  methods: {
    async fetch () {
      // eslint-disable-next-line no-unused-expressions
      this.axios
        .get('/api/movies')
        .then(response => {
          this.movies = response.data.data
          // eslint-disable-next-line no-sequences
        }),
      this.axios
        .get('/api/subtitles')
        .then(response => {
          this.subtitles = response.data.data
          // eslint-disable-next-line no-sequences
        })
    }
  }
}
</script>
