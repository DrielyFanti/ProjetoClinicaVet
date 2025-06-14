import { createRouter, createWebHistory } from 'vue-router'

import HomeView from '@/views/homeView.vue'
import DashboardView from '@/views/DashboardView.vue'
import ConsultasView from '@/views/ConsultasView.vue'
import NovaConsultaView from '@/views/NovaConsultaView.vue'
import EditarConsultaView from '@/views/EditarConsultaView.vue'
import AnimaisView from '@/views/AnimaisView.vue'
import NovoAnimalView from '@/views/NovoAnimalView.vue'
import EditarAnimalView from '@/views/EditarAnimalView.vue'
import TutoresView from '@/views/TutoresView.vue'
import NovoTutorView from '@/views/NovoTutorView.vue'
import EditarTutorView from '@/views/EditarTutorView.vue'
import ServicesView from '@/views/ServicesView.vue'
import ServiceFormView from '@/views/ServiceFormView.vue'
import NotFound from '@/views/NotFound.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/dashboard',
    name: 'dashboard',
    component: DashboardView
  },
  {
    path: '/consultas',
    name: 'consultas',
    component: ConsultasView
  },
  {
    path: '/consultas/nova',
    name: 'nova-consulta',
    component: NovaConsultaView
  },
  {
    path: '/consultas/editar/:id',
    name: 'editar-consulta',
    component: EditarConsultaView
  },
  {
    path: '/animais',
    name: 'animais',
    component: AnimaisView
  },
  {
    path: '/animais/novo',
    name: 'novo-animal',
    component: NovoAnimalView
  },
  {
    path: '/animais/editar/:id',
    name: 'editar-animal',
    component: EditarAnimalView
  },
  {
    path: '/tutores',
    name: 'tutores',
    component: TutoresView
  },
  {
    path: '/tutores/novo',
    name: 'novo-tutor',
    component: NovoTutorView
  },
  {
    path: '/tutores/editar/:id',
    name: 'editar-tutor',
    component: EditarTutorView
  },
  {
    path: '/servicos',
    name: 'services',
    component: ServicesView
  },
  {
    path: '/servicos/novo',
    name: 'new-service',
    component: ServiceFormView
  },
  {
    path: '/servicos/editar/:id',
    name: 'edit-service',
    component: ServiceFormView
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'not-found',
    component: NotFound
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
