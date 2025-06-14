<template>
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Tutores</h1>
      <router-link 
        to="/tutores/novo" 
        class="btn-primary"
      >
        <i class="fas fa-plus mr-2"></i>
        Novo Tutor
      </router-link>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="form-group">
          <label class="form-label">Buscar</label>
          <input 
            type="text" 
            v-model="filtro" 
            placeholder="Nome, CPF ou email..."
            class="form-input"
          >
        </div>
        <div class="form-group">
          <label class="form-label">Status</label>
          <select v-model="status" class="form-select">
            <option value="">Todos</option>
            <option value="1">Ativos</option>
            <option value="0">Inativos</option>
          </select>
        </div>
      </div>
    </div>

    <!-- Lista de Tutores -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
      <div v-if="carregando" class="p-4 text-center">
        <i class="fas fa-spinner fa-spin text-2xl text-blue-500"></i>
        <p class="mt-2 text-gray-600">Carregando tutores...</p>
      </div>

      <div v-else-if="erro" class="p-4 text-center text-red-500">
        <i class="fas fa-exclamation-circle text-2xl"></i>
        <p class="mt-2">{{ erro }}</p>
      </div>

      <div v-else-if="tutores.length === 0" class="p-4 text-center text-gray-500">
        <i class="fas fa-users text-2xl"></i>
        <p class="mt-2">Nenhum tutor encontrado</p>
      </div>

      <div v-else class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Nome
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                CPF
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Contato
              </th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Status
              </th>
              <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                Ações
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="tutor in tutoresFiltrados" :key="tutor.id">
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm font-medium text-gray-900">{{ tutor.name }}</div>
                <div class="text-sm text-gray-500">{{ tutor.email }}</div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                {{ tutor.cpf }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="text-sm text-gray-900">{{ tutor.phone }}</div>
                <div v-if="tutor.whatsapp" class="text-sm text-gray-500">
                  WhatsApp: {{ tutor.whatsapp }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span 
                  :class="[
                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                    tutor.is_active 
                      ? 'bg-green-100 text-green-800' 
                      : 'bg-red-100 text-red-800'
                  ]"
                >
                  {{ tutor.is_active ? 'Ativo' : 'Inativo' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <router-link 
                  :to="'/tutores/' + tutor.id" 
                  class="text-blue-600 hover:text-blue-900 mr-3"
                >
                  <i class="fas fa-eye"></i>
                </router-link>
                <router-link 
                  :to="'/tutores/' + tutor.id + '/editar'" 
                  class="text-yellow-600 hover:text-yellow-900 mr-3"
                >
                  <i class="fas fa-edit"></i>
                </router-link>
                <button 
                  @click="confirmarExclusao(tutor)"
                  class="text-red-600 hover:text-red-900"
                >
                  <i class="fas fa-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from '@/plugins/axios'

const tutores = ref([])
const carregando = ref(true)
const erro = ref(null)
const filtro = ref('')
const status = ref('')

const tutoresFiltrados = computed(() => {
  return tutores.value.filter(tutor => {
    const matchFiltro = !filtro.value || 
      tutor.name.toLowerCase().includes(filtro.value.toLowerCase()) ||
      tutor.cpf.includes(filtro.value) ||
      tutor.email.toLowerCase().includes(filtro.value.toLowerCase())
    
    const matchStatus = !status.value || 
      tutor.is_active === (status.value === '1')
    
    return matchFiltro && matchStatus
  })
})

const carregarTutores = async () => {
  try {
    carregando.value = true
    erro.value = null
    const response = await axios.get('/tutors')
    tutores.value = response.data.data || response.data
  } catch (err) {
    erro.value = 'Erro ao carregar tutores. Por favor, tente novamente.'
    console.error('Erro ao carregar tutores:', err)
  } finally {
    carregando.value = false
  }
}

const confirmarExclusao = async (tutor) => {
  if (!confirm(`Tem certeza que deseja excluir o tutor ${tutor.name}?`)) {
    return
  }

  try {
    await axios.delete(`/tutors/${tutor.id}`)
    await carregarTutores()
  } catch (err) {
    if (err.response?.status === 409) {
      alert(err.response.data.message)
    } else {
      alert('Erro ao excluir tutor. Por favor, tente novamente.')
    }
    console.error('Erro ao excluir tutor:', err)
  }
}

onMounted(carregarTutores)
</script>
  