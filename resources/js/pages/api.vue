<template>
  <div>
    APIs Page
  </div>
</template>

<script>
import { mapGetters } from 'vuex'

export default {

  metaInfo () {
    return { title: this.$t('api') }
  },

  data: () => ({
    title: window.config.appName
  }),

  computed: mapGetters({
    authenticated: 'auth/check'
  })
}
</script>
