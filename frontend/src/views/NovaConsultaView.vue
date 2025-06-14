<template>
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">
        {{ isEditing ? 'Editar Consulta' : 'Nova Consulta' }}
      </h1>
      <router-link 
        to="/consultas" 
        class="btn-secondary"
      >
        <i class="fas fa-arrow-left mr-2"></i>
        Voltar
      </router-link>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
      <form @submit.prevent="salvarConsulta" class="space-y-6">
        <!-- Animal -->
        <div class="form-group">
          <label class="form-label">Animal</label>
          <select
            v-model="consulta.animal_id"
            class="form-select"
            :class="{ 'border-red-500': erros.animal_id }"
            required
            @change="atualizarTutor"
          >
            <option value="">Selecione um animal</option>
            <option v-for="animal in animais" :key="animal.id" :value="animal.id">
              {{ animal.name }} ({{ animal.tutor.name }})
            </option>
          </select>
          <p v-if="erros.animal_id" class="form-error">{{ erros.animal_id }}</p>
        </div>

        <!-- Serviço -->
        <div class="form-group">
          <label class="form-label">Serviço</label>
          <select
            v-model="consulta.service"
            class="form-select"
            :class="{ 'border-red-500': erros.service }"
            required
          >
            <option value="">Selecione um serviço</option>
            <option v-for="service in services" :key="service.id" :value="service.name">
              {{ service.name }} - R$ {{ formatPrice(service.price) }}
            </option>
          </select>
          <p v-if="erros.service" class="form-error">{{ erros.service }}</p>
        </div>

        <!-- Data e Hora -->
        <div class="form-group">
          <label class="form-label">Data e Hora</label>
          <input
            type="datetime-local"
            v-model="consulta.date"
            class="form-input"
            :class="{ 'border-red-500': erros.date }"
            required
          />
          <p v-if="erros.date" class="form-error">{{ erros.date }}</p>
        </div>

        <!-- Status -->
        <div class="form-group">
          <label class="form-label">Status</label>
          <select
            v-model="consulta.status"
            class="form-select"
            :class="{ 'border-red-500': erros.status }"
            required
          >
            <option value="agendada">Agendada</option>
            <option value="realizada">Realizada</option>
            <option value="cancelada">Cancelada</option>
          </select>
          <p v-if="erros.status" class="form-error">{{ erros.status }}</p>
        </div>

        <!-- Observações -->
        <div class="form-group">
          <label class="form-label">Observações</label>
          <textarea
            v-model="consulta.notes"
            class="form-input"
            :class="{ 'border-red-500': erros.notes }"
            rows="3"
            placeholder="Observações sobre a consulta"
          ></textarea>
          <p v-if="erros.notes" class="form-error">{{ erros.notes }}</p>
        </div>

        <!-- Botões -->
        <div class="flex justify-end space-x-4">
          <router-link 
            to="/consultas" 
            class="btn-secondary"
          >
            Cancelar
          </router-link>
          <button 
            type="submit" 
            class="btn-primary"
            :disabled="salvando"
          >
            <i v-if="salvando" class="fas fa-spinner fa-spin mr-2"></i>
            {{ isEditing ? 'Salvar Alterações' : 'Agendar Consulta' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from '@/plugins/axios'

const route = useRoute()
const router = useRouter()
const isEditing = computed(() => !!route.params.id)
const salvando = ref(false)
const erros = ref({})

const consulta = ref({
  animal_id: '',
  tutor_id: '',
  service: '',
  date: '',
  status: 'agendada',
  notes: ''
})

const animais = ref([])
const services = ref([])

const formatPrice = (price) => {
  return Number(price).toFixed(2)
}

const carregarAnimais = async () => {
  try {
    const response = await axios.get('/animals')
    animais.value = response.data.data || response.data
  } catch (error) {
    console.error('Erro ao carregar animais:', error)
  }
}

const carregarServicos = async () => {
  try {
    const response = await axios.get('/services')
    services.value = response.data
  } catch (error) {
    console.error('Erro ao carregar serviços:', error)
  }
}

const atualizarTutor = () => {
  const animalSelecionado = animais.value.find(a => a.id === consulta.value.animal_id)
  if (animalSelecionado) {
    consulta.value.tutor_id = animalSelecionado.tutor_id
  } else {
    consulta.value.tutor_id = ''
  }
}

const carregarConsulta = async (id) => {
  try {
    const response = await axios.get(`/appointments/${id}`)
    const data = response.data.data || response.data
    consulta.value = {
      animal_id: data.animal_id,
      tutor_id: data.tutor_id,
      service: data.service,
      date: new Date(data.date).toISOString().slice(0, 16),
      status: data.status,
      notes: data.notes
    }
  } catch (error) {
    console.error('Erro ao carregar consulta:', error)
  }
}

const salvarConsulta = async () => {
  try {
    salvando.value = true
    erros.value = {}

    console.log('Dados da consulta antes de salvar:', JSON.stringify(consulta.value, null, 2))

    if (!consulta.value.animal_id) {
      erros.value.animal_id = ['Por favor, selecione um animal']
      return
    }

    if (!consulta.value.tutor_id) {
      erros.value.tutor_id = ['Por favor, selecione um animal para obter o tutor']
      return
    }

    if (isEditing.value) {
      const response = await axios.put(`/appointments/${route.params.id}`, consulta.value)
      console.log('Resposta da API (atualização):', response.data)
    } else {
      const response = await axios.post('/appointments', consulta.value)
      console.log('Resposta da API (criação):', response.data)
    }
    router.push('/consultas')
  } catch (error) {
    console.error('Erro ao salvar consulta:', error)
    if (error.response?.data?.errors) {
      erros.value = error.response.data.errors
      console.error('Erros de validação:', erros.value)
    } else {
      alert('Erro ao salvar consulta')
    }
  } finally {
    salvando.value = false
  }
}

onMounted(async () => {
  await carregarAnimais()
  await carregarServicos()
  if (isEditing.value) {
    await carregarConsulta(route.params.id)
  }
})
</script>
  