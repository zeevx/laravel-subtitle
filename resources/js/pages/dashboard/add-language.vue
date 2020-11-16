<template>
  <div>
    <h1>
      <router-link :to="{ name: 'home' }">
        <fa :icon="['fa', 'home']" />
      </router-link> / Add Language
    </h1>
    <card>
      <form @submit.prevent="add_language" @keydown="form.onKeydown($event)">
        <alert-success :form="form" :message="$t('language_added')" />
        <!-- Language Name -->
        <div class="form-group row">
          <label class="col-md-3 col-form-label text-md-right">{{ $t('language_name') }}</label>
          <div class="col-md-7">
            <input v-model="form.language_name" :class="{ 'is-invalid': form.errors.has('language_name') }" class="form-control" type="text" name="language_name" placeholder="Enter Language Name" required>
            <has-error :form="form" field="language_name" />
          </div>
        </div>

        <div class="form-group row">
          <div class="col-md-7 offset-md-3 d-flex">
            <!-- Submit Button -->
            <v-button :loading="form.busy">
              <fa :icon="['fas', 'check']" /> {{ $t('add_language') }}
            </v-button>
          </div>
        </div>
      </form>
    </card>
    <br>
    <card :title="$t('languages_added')">
      <alert-success :form="formx" :message="$t('language_deleted')" />
      <table class="table table-responsive-lg">
        <thead class="text-light" style="background-color: #601a11;">
          <tr>
            <th>ID</th>
            <th>Language Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="language in languages.data" :key="language.id">
            <th scope="row">
              {{ language.id }}
            </th>
            <td>{{ language.language_name }}</td>
            <td>
              <form @submit.prevent="delete_language(language.id)">
                <button class="btn-sm btn-outline-dark">
                  <fa :icon="['fas', 'dumpster']" /> Delete
                </button>
              </form>
            </td>
          </tr>
        </tbody>
        <pagination :data="languages" @pagination-change-page="fetch"></pagination>
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
    return { title: this.$t('add-language') }
  },
  data: () => ({
    form: new Form({
      language_name: ''
    }),
    formx: new Form(),
    languages: {}
  }),
  created () {
    this.fetch()
  },
  methods: {
    async fetch (page = 1) {
      this.axios
        .get('/api/languages?page=' + page)
        .then(response => {
          this.languages = response.data
        })
    },
    async add_language () {
      await this.form.post('/api/language/add')
      this.form.reset()
      this.fetch()
    },
    async delete_language (id) {
      await this.formx.delete('/api/language/delete/' + id)
      this.fetch()
    }
  }
}
</script>
