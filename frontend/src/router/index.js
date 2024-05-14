import Vue from 'vue'
import Router from 'vue-router'
import Notely from '@/components/Notely'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Notely',
      component: Notely
    }
  ]
})