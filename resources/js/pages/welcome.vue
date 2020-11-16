<template>
  <div>
    <div class="s004">
      <form>
        <fieldset>
          <legend>LaraSubTitle.Web</legend>
          <div class="inner-form">
            <div class="input-field">
              <div class="choices" data-type="text" aria-haspopup="true" aria-expanded="false" dir="ltr">
                <div class="choices__inner">
                  <input type="text" class="choices__input choices__input--cloned" autocomplete="off" autocapitalize="off" spellcheck="false" role="textbox" aria-autocomplete="list" placeholder="Search Movie Subtitle..." style="width: 163px;">
                </div>
              </div>
              <button class="btn-search" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path>
                </svg>
              </button>
            </div>
          </div>
          <div class="suggestion-wrap">
            <router-link :to="{ name: 'subtitles' }">
              <span>New Subtitles</span>
            </router-link>
            <router-link :to="{ name: 'most-downloaded' }">
              <span>Most Downloaded</span>
            </router-link>
            <router-link :to="{ name: 'api' }">
              <span>API</span>
            </router-link>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {
  layout: 'basic',

  metaInfo () {
    return { title: this.$t('home') }
  },

  data: () => ({
    title: window.config.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>

<style scoped>
.top-right {
  position: absolute;
  right: 10px;
  top: 18px;
}

.title {
  font-size: 85px;
}
</style>
