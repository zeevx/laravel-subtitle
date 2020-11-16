import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// import { } from '@fortawesome/free-regular-svg-icons'

import {
  faUser,
  faLock,
  faSignOutAlt,
  faCog,
  faDesktop,
  faVideo,
  faUpload,
  faDownload,
  faDumpster,
  faPen,
  faPlus,
  faCheck,
  faHome,
  faBook,
  faFilm,
  faStar,
  faEye,
  faFlag
} from '@fortawesome/free-solid-svg-icons'

import {
  faBitcoin,
  faGithub,
  faPatreon,
  faPaypal
} from '@fortawesome/free-brands-svg-icons'

library.add(
  faUser, faLock, faSignOutAlt, faCog, faGithub, faPaypal, faPatreon, faBitcoin, faEye,
  faDesktop, faVideo, faUpload, faDownload, faDumpster, faPen, faPlus, faCheck, faHome, faBook, faFilm, faStar, faFlag
)

Vue.component('fa', FontAwesomeIcon)
