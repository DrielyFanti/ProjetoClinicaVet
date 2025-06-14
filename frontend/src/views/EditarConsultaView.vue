<template>
    <div class="p-6 max-w-2xl mx-auto">
      <h1 class="text-2xl font-bold mb-6">Editar Consulta</h1>
  
      <form @submit.prevent="atualizarConsulta" class="space-y-4" v-if="consulta">
        <div>
          <label class="block mb-1 font-medium">Animal</label>
          <select v-model="consulta.animal_id" class="w-full border rounded px-3 py-2">
            <option value="">Selecione</option>
            <option v-for="animal in animais" :key="animal.id" :value="animal.id">
              {{ animal.name }} ({{ animal.tutor.name }})
            </option>
          </select>
        </div>
  
        <div>
          <label class="block mb-1 font-medium">Serviço</label>
          <select v-model="consulta.service_type_id" class="w-full border rounded px-3 py-2">
            <option value="">Selecione</option>
            <option v-for="servico in servicos" :key="servico.id" :value="servico.id">
              {{ servico.name }}
            </option>
          </select>
        </div>
  
        <div>
          <label class="block mb-1 font-medium">Data</label>
          <input type="date" v-model="consulta.date" class="w-full border rounded px-3 py-2" />
        </div>
  
        <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600">
          Atualizar
        </button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute, useRouter } from 'vue-router'
  import axios from 'axios'
  
  const route = useRoute()
  const router = useRouter()
  
  const consulta = ref(null)
  const animais = ref([])
  const servicos = ref([])
  
  const carregarDados = async () => {
    const id = route.params.id
  
    const [resConsulta, resAnimais, resServicos] = await Promise.all([
      axios.get(`http://localhost:8000/api/appointments/${id}`),
      axios.get('http://localhost:8000/api/animals?_expand=tutor'),
      axios.get('http://localhost:8000/api/service-types')
    ])
  
    consulta.value = resConsulta.data
    animais.value = resAnimais.data
    servicos.value = resServicos.data
  }
  
  const atualizarConsulta = async () => {
    await axios.put(`http://localhost:8000/api/appointments/${consulta.value.id}`, consulta.value)
    router.push('/consultas')
  }
  
  onMounted(() => {
    carregarDados()
  })
  </script>
  