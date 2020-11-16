function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('welcome.vue') },
  { path: '/subtitles', name: 'subtitles', component: page('subtitles.vue') },
  { path: '/api', name: 'api', component: page('api.vue') },
  { path: '/most-downloaded', name: 'most-downloaded', component: page('most-downloaded.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  { path: '/home', name: 'home', component: page('home.vue') },
  { path: '/add-movie', name: 'add-movie', component: page('dashboard/add-movie.vue') },
  { path: '/add-subtitle', name: 'add-subtitle', component: page('dashboard/add-subtitle.vue') },
  { path: '/add-genre', name: 'add-genre', component: page('dashboard/add-genre.vue') },
  { path: '/add-language', name: 'add-language', component: page('dashboard/add-language.vue') },

  { path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ] },

  { path: '*', component: page('errors/404.vue') }
]
