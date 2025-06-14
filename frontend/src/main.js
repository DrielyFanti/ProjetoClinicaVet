import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import axios from './plugins/axios'
import { VueMaskDirective } from 'v-mask'
import '@fortawesome/fontawesome-free/css/all.min.css'
import './assets/main.css'
import './assets/styles.css'
import './index.css'

const app = createApp(App)

app.directive('mask', VueMaskDirective)
app.use(router)

// Configurar o axios globalmente
app.config.globalProperties.$axios = axios

app.mount('#app')
