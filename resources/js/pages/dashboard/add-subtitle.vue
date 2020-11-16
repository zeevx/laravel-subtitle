<template>
  <div>
    <h1>
      <router-link :to="{ name: 'home' }">
        <fa :icon="['fa', 'home']" />
      </router-link> / Add Subtitle
    </h1>
    <card>
      <form enctype="multipart/form-data" @submit.prevent="add_subtitle" @keydown="form.onKeydown($event)">
        <alert-success :form="form" :message="$t('subtitle_added')" />

        <!-- Subtitle Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('subtitle_name') }}</label>
          <div class="col-md-7">
            <input v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }" class="form-control" type="text" name="name" placeholder="Enter Subtitle Name" required>
            <has-error :form="form" field="name" />
          </div>
        </div>

        <!-- Files -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('file') }}</label>
          <div class="col-md-7">
            <input id="file" ref="file" type="file" name="file" :class="{ 'is-invalid': form.errors.has('file') }" class="form-control-file" required @change="selectFile">
            <has-error :form="form" field="file" />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('movie') }}</label>
          <div class="col-md-7">
            <select v-model="form.movie_id" name="movie_id" class="form-control" required>
              <option v-for="movie in movies" :id="movie.id" :key="movie.id" :value="movie.id">
                {{ movie.movie_name }}
              </option>
            </select>
            <has-error :form="form" field="movie_id" />
          </div>
        </div>

        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('language') }}</label>
          <div class="col-md-7">
            <select v-model="form.language" name="language" class="form-control selectpicker" data-live-search="true" required>
              <option v-for="language in languages" :id="language.id" :key="language.id" :value="language.language_name">
                {{ language.language_name }}
              </option>
            </select>
            <has-error :form="form" field="language_id" />
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-7 offset-md-3 d-flex">
            <!-- Submit Button -->
            <v-button :loading="form.busy">
              <fa :icon="['fas', 'check']" /> {{ $t('add_subtitle') }}
            </v-button>
          </div>
        </div>
      </form>
    </card>
    <br>
    <card :title="$t('subtitles_added')">
      <alert-success :form="formx" :message="$t('subtitle_deleted')" />
      <input id="myInput" type="text" class="form-control mb-2" placeholder="Search for subtitles.." title="Type in a name" @keyup="searchFunction">
      <table id="myTable" class="table table-responsive-lg">
        <thead class="text-light" style="background-color: #601a11;">
          <tr>
            <th>Subtitle Name</th>
            <th>Movie</th>
            <th>Language</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="subtitle in subtitles.data" :key="subtitle.id">
            <td scope="row">
              {{ subtitle.name }}
            </td>
            <td>{{ subtitle.movie.movie_name }}</td>
            <td>
              {{ subtitle.language }}
            </td>
            <td>
              <form @submit.prevent="delete_subtitle(subtitle.id)">
                <button class="btn-sm btn-outline-dark m-1">
                  <fa :icon="['fas', 'dumpster']" /> Delete
                </button>
              </form>
              <button class="btn-sm btn-outline-dark m-1">
                <fa :icon="['fa', 'pen']" /> Edit
              </button>
              <button class="btn-sm btn-outline-dark m-1">
                <fa :icon="['fa', 'download']" /> Download
              </button>
            </td>
          </tr>
          <pagination :data="subtitles" @pagination-change-page="fetch" />
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
    return { title: this.$t('add-subtitle') }
  },
  data: () => ({
    form: new Form({
      movie_id: '',
      name: '',
      file: null,
      language: ''
    }),
    formx: new Form(),
    subtitles: {},
    languages: [],
    movies: [],
    myInput: ''
  }),
  created () {
    this.fetch()
  },
  methods: {
    async fetch (page = 1) {
      // eslint-disable-next-line no-unused-expressions
      this.axios
        .get('/api/subtitles?page=' + page)
        .then(response => {
          this.subtitles = response.data
          // eslint-disable-next-line no-sequences
        }),
      this.axios
        .get('/api/languages')
        .then(response => {
          this.languages = response.data.data
        }),
      this.axios
        .get('/api/movies')
        .then(response => {
          this.movies = response.data.data
        })
    },
    selectFile (e) {
      let files = e.target.files || e.dataTransfer.files
      this.form.file = files[0]
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
    async add_subtitle () {
      await this.form.submit('post', '/api/subtitle/add', {

        // Transform form data to FormData
        transformRequest: [function (data, headers) {
          // eslint-disable-next-line no-undef
          return objectToFormData(data)
        }]
      })
      this.form.reset()
      this.fetch()
    },
    async delete_subtitle (id) {
      await this.formx.delete('/api/subtitle/delete/' + id)
      this.fetch()
    }
  }
}
</script>
