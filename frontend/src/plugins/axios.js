import axios from 'axios'

const instance = axios.create({
  baseURL: '/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

// Request interceptor
instance.interceptors.request.use(
  config => {
    console.log('Requisição sendo enviada:', config)
    return config
  },
  error => {
    console.error('Erro na requisição:', error)
    return Promise.reject(error)
  }
)

// Response interceptor
instance.interceptors.response.use(
  response => {
    console.log('Resposta recebida:', response)
    return response
  },
  error => {
    console.error('Erro na resposta:', error)
    if (error.response) {
      console.error('Dados do erro:', error.response.data)
      console.error('Status do erro:', error.response.status)
    }
    return Promise.reject(error)
  }
)

export default instance 