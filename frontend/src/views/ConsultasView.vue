<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Consultas</h1>
      <router-link to="/consultas/nova" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Nova Consulta
      </router-link>
    </div>

    <table class="min-w-full bg-white rounded shadow overflow-hidden">
      <thead class="bg-gray-200">
        <tr>
          <th class="text-left py-2 px-4">Animal</th>
          <th class="text-left py-2 px-4">Tutor</th>
          <th class="text-left py-2 px-4">Serviço</th>
          <th class="text-left py-2 px-4">Data</th>
          <th class="text-left py-2 px-4">Status</th>
          <th class="text-left py-2 px-4">Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="consulta in consultas" :key="consulta.id" class="border-t">
          <td class="py-2 px-4">{{ consulta.animal?.name }}</td>
          <td class="py-2 px-4">{{ consulta.tutor?.name }}</td>
          <td class="py-2 px-4">{{ consulta.service }}</td>
          <td class="py-2 px-4">{{ formatarData(consulta.date) }}</td>
          <td class="py-2 px-4">{{ consulta.status }}</td>
          <td class="py-2 px-4 space-x-2">
            <router-link :to="`/consultas/editar/${consulta.id}`" class="text-blue-600 hover:underline">Editar</router-link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue'
import axios from '@/plugins/axios.js'

const consultas = ref([])

const carregarConsultas = async () => {
  const response = await axios.get('/appointments')
  consultas.value = response.data.data || response.data
}

const formatarData = (data) => {
  return new Date(data).toLocaleString('pt-BR', { dateStyle: 'short', timeStyle: 'short' })
}

onMounted(() => {
  carregarConsultas()
})
</script>
