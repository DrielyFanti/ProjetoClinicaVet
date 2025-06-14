<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold">Serviços</h1>
      <div class="flex gap-4">
        <div class="relative">
          <input
            type="text"
            v-model="search"
            placeholder="Buscar serviços..."
            class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
          <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>
        <router-link
          to="/servicos/novo"
          class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center gap-2"
        >
          <i class="fas fa-plus"></i>
          Novo Serviço
        </router-link>
      </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Nome
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Preço
            </th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
              Descrição
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
          <tr v-for="service in filteredServices" :key="service.id">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">{{ service.name }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900">R$ {{ formatPrice(service.price) }}</div>
            </td>
            <td class="px-6 py-4">
              <div class="text-sm text-gray-900">{{ service.description || '-' }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span
                :class="[
                  'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                  service.is_active
                    ? 'bg-green-100 text-green-800'
                    : 'bg-red-100 text-red-800'
                ]"
              >
                {{ service.is_active ? 'Ativo' : 'Inativo' }}
              </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <router-link
                :to="'/servicos/editar/' + service.id"
                class="text-blue-600 hover:text-blue-900 mr-4"
              >
                <i class="fas fa-edit"></i>
              </router-link>
              <button
                @click="confirmDelete(service)"
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
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from '@/plugins/axios'

const services = ref([])
const search = ref('')

const filteredServices = computed(() => {
  const searchTerm = search.value.toLowerCase()
  return services.value.filter(service => 
    service.name.toLowerCase().includes(searchTerm) ||
    (service.description && service.description.toLowerCase().includes(searchTerm))
  )
})

const formatPrice = (price) => {
  return Number(price).toFixed(2)
}

const loadServices = async () => {
  try {
    const response = await axios.get('/services')
    services.value = response.data
  } catch (error) {
    console.error('Erro ao carregar serviços:', error)
  }
}

const confirmDelete = async (service) => {
  if (confirm(`Tem certeza que deseja excluir o serviço "${service.name}"?`)) {
    try {
      await axios.delete(`/services/${service.id}`)
      await loadServices()
    } catch (error) {
      console.error('Erro ao excluir serviço:', error)
      alert('Erro ao excluir serviço')
    }
  }
}

onMounted(loadServices)
</script> 