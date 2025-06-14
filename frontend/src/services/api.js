import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
});

// Interceptor para tratamento de erros
api.interceptors.response.use(
  response => response,
  error => {
    if (error.response) {
      // Erro do servidor
      console.error('Erro na API:', error.response.data)
    } else if (error.request) {
      // Erro de rede
      console.error('Erro de rede:', error.request)
    } else {
      // Erro na configuração da requisição
      console.error('Erro:', error.message)
    }
    return Promise.reject(error)
  }
)

export default api;
