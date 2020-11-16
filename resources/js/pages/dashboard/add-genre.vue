<template>
  <div>
    <h1><router-link :to="{ name:  'home' }"><fa :icon="['fa', 'home']"/></router-link> / Add Genre</h1>
    <card>
      <form @submit.prevent="add_genre" @keydown="form.onKeydown($event)">
        <alert-success :form="form" :message="$t('genre_added')" />
        <!-- Genre Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('genre_name') }}</label>
          <div class="col-md-7">
            <input v-model="form.genre_name" :class="{ 'is-invalid': form.errors.has('genre_name') }" class="form-control" type="text" name="genre_name" placeholder="Enter Genre Name" required>
            <has-error :form="form" field="genre_name" />
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-7 offset-md-3 d-flex">
            <!-- Submit Button -->
            <v-button :loading="form.busy">
              <fa :icon="['fas', 'check']"/> {{ $t('add_genre') }}
            </v-button>
          </div>
        </div>
      </form>
    </card>
 <br>
    <card :title="$t('genres_added')">
        <alert-success :form="formx" :message="$t('genre_deleted')" />
      <table class="table table-responsive-lg">
        <thead class="text-light" style="background-color: #601a11;">
        <tr>
          <th>Genre Name</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="genre in genres.data" :key="genre.id">
          <th scope="row">{{ genre.genre_name }}</th>
           <td>
               <form v-on:submit.prevent="delete_genre(genre.id)">
                  <button class="btn-sm btn-outline-dark">
                    <fa :icon="['fas', 'dumpster']"/> Delete
                  </button>
              </form>
            </td>
        </tr>
        <pagination :data="genres" @pagination-change-page="fetch"></pagination>
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
    return { title: this.$t('add-genre') }
  },
  data: () => ({
    form: new Form({
      genre_name: ''
    }),
    formx: new Form(),
    genres: {}
  }),
  created () {
    this.fetch()
  },
  methods: {
    async fetch (page = 1) {
      this.axios
        .get('/api/genres?page=' + page)
        .then(response => {
          this.genres = response.data
        })
    },
    async add_genre () {
      await this.form.post('/api/genre/add')
      this.form.reset()
      this.fetch()
      // Redirect home.
      // this.$router.push({ name: 'home' })
    },
    async delete_genre(id) {
      await this.formx.delete('/api/genre/delete/'+id)
      this.fetch()

    }
  }
}
</script>
