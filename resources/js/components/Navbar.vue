<template>
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #601911;">
    <div class="container">
      <router-link :to="{ name: user ? 'home' : 'welcome' }" class="navbar-brand">
        {{ appName }}
      </router-link>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
        <span class="navbar-toggler-icon" />
      </button>

      <div id="navbarToggler" class="collapse navbar-collapse">
        <ul class="navbar-nav">
          <locale-dropdown />
          <!-- <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li> -->
        </ul>

        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <router-link :to="{ name: 'welcome' }" class="nav-link">
              {{ $t('search') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'subtitles' }" class="nav-link" active-class="active">
              {{ $t('new-subtitles') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'most-downloaded' }" class="nav-link" active-class="active">
              {{ $t('most-downloaded') }}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link :to="{ name: 'api' }" class="nav-link" active-class="active">
              {{ $t('apis') }}
            </router-link>
          </li>
          <!-- Authenticated -->
          <li v-if="user" class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-light"
               href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            >
              <img :src="user.photo_url" class="rounded-circle profile-photo mr-1">
              {{ user.name }}
            </a>
            <div class="dropdown-menu">
              <router-link :to="{ name: 'home' }" class="dropdown-item pl-3">
                <fa icon="desktop" fixed-width />
                {{ $t('dashboard') }}
              </router-link>
              <div class="dropdown-divider" />
              <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
                <fa icon="cog" fixed-width />
                {{ $t('settings') }}
              </router-link>
              <div class="dropdown-divider" />
              <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
                <fa icon="sign-out-alt" fixed-width />
                {{ $t('logout') }}
              </a>
            </div>
          </li>
          <!-- Guest -->
<!--          <template v-else>-->
<!--            <li class="nav-item">-->
<!--              <router-link :to="{ name: 'login' }" class="nav-link" active-class="active">-->
<!--                {{ $t('login') }}-->
<!--              </router-link>-->
<!--            </li>-->
<!--            <li class="nav-item">-->
<!--              <router-link :to="{ name: 'register' }" class="nav-link" active-class="active">-->
<!--                {{ $t('register') }}-->
<!--              </router-link>-->
<!--            </li>-->
<!--          </template>-->
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
import { mapGetters } from 'vuex'
import LocaleDropdown from './LocaleDropdown'

export default {
  components: {
    LocaleDropdown
  },

  data: () => ({
    appName: window.config.appName,
    navbarToggler: false
  }),
  watch: {
    '$route' () {
      this.navbarToggler = false
    }
  },
  // eslint-disable-next-line vue/order-in-components
  computed: mapGetters({
    user: 'auth/user'
  }),

  methods: {
    async logout () {
      // Log out the user.
      await this.$store.dispatch('auth/logout')

      // Redirect to login.
      this.$router.push({ name: 'login' })
    }
  }
}
</script>

<style scoped>
.profile-photo {
  width: 2rem;
  height: 2rem;
  margin: -.375rem 0;
}
</style>
