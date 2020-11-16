import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import objectToFormData from './objectToFormData'

import '~/plugins'
import '~/components'
import VueAxios from 'vue-axios'
import axios from 'axios'

Vue.use(VueAxios, axios)

Vue.config.productionTip = false

window.objectToFormData = objectToFormData

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
