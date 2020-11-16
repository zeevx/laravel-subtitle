<template>
  <div>
    <h1>
      <router-link :to="{ name: 'home' }">
        <fa :icon="['fa', 'home']" />
      </router-link> / Add Movie
    </h1>
    <card>
      <form enctype="multipart/form-data" @submit.prevent="add_movie" @keydown="form.onKeydown($event)">
        <alert-success :form="form" :message="$t('movie_added')" />

        <!-- Movie Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('movie_name') }}</label>
          <div class="col-md-7">
            <input v-model="form.movie_name" :class="{ 'is-invalid': form.errors.has('movie_name') }" class="form-control" type="text" name="movie_name" placeholder="Enter Movie Name" required>
            <has-error :form="form" field="movie_name" />
          </div>
        </div>

        <!-- IMDB Rating -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('IMDB_rating') }}</label>
          <div class="col-md-7">
            <input v-model="form.IMDB_rating" :class="{ 'is-invalid': form.errors.has('IMDB_rating') }" class="form-control" type="number" name="IMDB_rating" placeholder="Enter IMDB Rating" required>
            <has-error :form="form" field="IMDB_rating" />
          </div>
        </div>

        <!-- Youtube -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('youtube') }}</label>
          <div class="col-md-7">
            <input v-model="form.youtube" :class="{ 'is-invalid': form.errors.has('youtube') }" class="form-control" type="url" name="youtube" placeholder="Youtube Trailer Link" required>
            <has-error :form="form" field="youtube" />
          </div>
        </div>

        <!-- Images -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('image') }}</label>
          <div class="col-md-7">
            <div v-if="!imagex">
              <input id="image" ref="image" type="file" name="image" :class="{ 'is-invalid': form.errors.has('image') }" class="form-control-file" @change="selectFile">
              <has-error :form="form" field="image" />
            </div>
            <div v-else>
              <img :src="imagex" class="img-thumbnail">
              <button class="btn-sm btn-outline-primary" @click="removeImage">
                Remove Thumbnail
              </button>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('description') }}</label>
          <div class="col-md-7">
            <textarea v-model="form.description" :class="{ 'is-invalid': form.errors.has('description') }"
                      class="form-control" name="description" placeholder="Enter Description" required cols="30"
                      rows="10"
            />
            <has-error :form="form" field="description" />
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('genre') }}</label>
          <div class="col-md-7">
            <div v-for="genre in genres" :key="genre.id">
              <input :id="genre.id" v-model="form.genre_id" type="checkbox" :value="genre.id" name="genre_id"> {{ genre.genre_name }}
            </div>
            <has-error :form="form" field="genre_id" />
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-7 offset-md-3 d-flex">
            <!-- Submit Button -->
            <v-button :loading="form.busy">
              <fa :icon="['fas', 'check']" /> {{ $t('add_movie') }}
            </v-button>
          </div>
        </div>
      </form>
    </card>
    <br>
    <card :title="$t('movies_added')">
      <alert-success :form="formx" :message="$t('movie_deleted')" />
      <input id="myInput" type="text" class="form-control mb-2" placeholder="Search for movies.." title="Type in a name" @keyup="searchFunction">
      <table id="myTable" class="table table-responsive-lg">
        <thead class="text-light" style="background-color: #601a11;">
          <tr>
            <th>Movie Name</th>
            <th>IMDB Rating</th>
            <th>Genre</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="movie in movies.data" :key="movie.id">
            <td scope="row">
              {{ movie.movie_name }}
            </td>
            <td>{{ movie.IMDB_rating }}</td>
            <td>
              <ul class="list-inline">
                <li v-for="genre in movie.genres" :key="genre.id" class="list-inline-item font-weight-bold">
                  {{ genre.genre_name }}*
                </li>
              </ul>
            </td>
            <td>
              <form @submit.prevent="delete_movie(movie.id)">
                <button class="btn-sm btn-outline-dark m-1">
                  <fa :icon="['fas', 'dumpster']" /> Delete
                </button>
              </form>
              <button class="btn-sm btn-outline-dark m-1">
                <fa :icon="['fa', 'eye']" /> View
              </button>
              <button class="btn-sm btn-outline-dark m-1">
                <fa :icon="['fa', 'pen']" /> Edit
              </button>
            </td>
          </tr>
          <pagination :data="movies" @pagination-change-page="fetch"></pagination>
        </tbody>
      </table>
    </card>
  </div>
</template>

<script>

import Card from '../../components/Card'
import Form from 'vform'

export default {
  components: { Card },
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('add-movie') }
  },
  data: () => ({
    form: new Form({
      movie_name: '',
      IMDB_rating: '',
      genre_id: [],
      image: null,
      description: ''
    }),
    formx: new Form(),
    movies: {},
    genres: [],
    youtube: '',
    imagex: '',
    myInput: ''
  }),
  created () {
    this.fetch()
  },
  methods: {
    async fetch (page = 1) {
      // eslint-disable-next-line no-unused-expressions
      this.axios
        .get('/api/movies?page=' + page)
        .then(response => {
          this.movies = response.data
          // eslint-disable-next-lsine no-sequences
        }),
      this.axios
        .get('/api/genres')
        .then(response => {
          this.genres = response.data.data
        })
    },
    selectFile (e) {
      // this.form.image = event.target.files[0] || event.dataTransfer.files[0]
      let files = e.target.files || e.dataTransfer.files
      this.form.image = files[0]
      if (!files.length) { return }
      this.createImage(files[0])
    },
    createImage (file) {
      let imagex = new Image()
      let reader = new FileReader()

      reader.onload = (e) => {
        // this.form.image = e.target.result
        this.imagex = e.target.result
      }
      reader.readAsDataURL(file)
    },
    removeImage: function (e) {
      this.imagex = ''
    },
    searchFunction () {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue
      input = document.getElementById('myInput')
      filter = input.value.toUpperCase()
      table = document.getElementById('myTable')
      tr = table.getElementsByTagName('tr')

      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName('td')[0]
        if (td) {
          txtValue = td.textContent || td.innerText
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = ''
          } else {
            tr[i].style.display = 'none'
          }
        }
      }
    },
    async add_movie () {
      await this.form.submit('post', '/api/movie/add', {

        // Transform form data to FormData
        transformRequest: [function (data, headers) {
        // eslint-disable-next-line no-undef
          return objectToFormData(data)
        }]
      })
      this.form.reset()
      this.removeImage()
      this.fetch()
    },
    async delete_movie (id) {
      await this.formx.delete('/api/movie/delete/' + id)
      this.fetch()
    }
  }
}
</script>
