<template>
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">
        {{ isEditing ? 'Editar Animal' : 'Novo Animal' }}
      </h1>
      <router-link 
        to="/animais" 
        class="btn-secondary"
      >
        <i class="fas fa-arrow-left mr-2"></i>
        Voltar
      </router-link>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
      <form @submit.prevent="salvarAnimal" class="space-y-6">
        <!-- Nome -->
        <div class="form-group">
          <label class="form-label">Nome</label>
          <input
            type="text"
            v-model="animal.name"
            class="form-input"
            :class="{ 'border-red-500': erros.name }"
            placeholder="Nome do animal"
            required
          />
          <p v-if="erros.name" class="form-error">{{ erros.name }}</p>
        </div>

        <!-- Tutor -->
        <div class="form-group">
          <label class="form-label">Tutor</label>
          <select
            v-model="animal.tutor_id"
            class="form-select"
            :class="{ 'border-red-500': erros.tutor_id }"
            required
          >
            <option value="">Selecione um tutor</option>
            <option v-for="tutor in tutores" :key="tutor.id" :value="tutor.id">
              {{ tutor.name }}
            </option>
          </select>
          <p v-if="erros.tutor_id" class="form-error">{{ erros.tutor_id }}</p>
        </div>

        <!-- Espécie -->
        <div class="form-group">
          <label class="form-label">Espécie</label>
          <select
            v-model="animal.species_id"
            class="form-select"
            :class="{ 'border-red-500': erros.species_id }"
            required
          >
            <option value="">Selecione uma espécie</option>
            <option v-for="species in especies" :key="species.id" :value="species.id">
              {{ species.name }}
            </option>
          </select>
          <p v-if="erros.species_id" class="form-error">{{ erros.species_id }}</p>
        </div>

        <!-- Raça -->
        <div class="form-group">
          <label class="form-label">Raça</label>
          <select
            v-model="animal.breed_id"
            class="form-select"
            :class="{ 'border-red-500': erros.breed_id }"
            required
          >
            <option value="">Selecione uma raça</option>
            <option v-for="breed in racas" :key="breed.id" :value="breed.id">
              {{ breed.name }}
            </option>
          </select>
          <p v-if="erros.breed_id" class="form-error">{{ erros.breed_id }}</p>
        </div>

        <!-- Data de Nascimento -->
        <div class="form-group">
          <label class="form-label">Data de Nascimento</label>
          <input
            type="date"
            v-model="animal.birth_date"
            class="form-input"
            :class="{ 'border-red-500': erros.birth_date }"
          />
          <p v-if="erros.birth_date" class="form-error">{{ erros.birth_date }}</p>
        </div>

        <!-- Peso -->
        <div class="form-group">
          <label class="form-label">Peso (kg)</label>
          <input
            type="number"
            v-model="animal.weight"
            class="form-input"
            :class="{ 'border-red-500': erros.weight }"
            step="0.1"
            min="0"
          />
          <p v-if="erros.weight" class="form-error">{{ erros.weight }}</p>
        </div>

        <!-- Gênero -->
        <div class="form-group">
          <label class="form-label">Gênero</label>
          <div class="flex items-center space-x-4">
            <label class="inline-flex items-center">
              <input
                type="radio"
                v-model="animal.gender"
                value="male"
                class="form-radio"
                :class="{ 'border-red-500': erros.gender }"
              />
              <span class="ml-2">Macho</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                v-model="animal.gender"
                value="female"
                class="form-radio"
                :class="{ 'border-red-500': erros.gender }"
              />
              <span class="ml-2">Fêmea</span>
            </label>
          </div>
          <p v-if="erros.gender" class="form-error">{{ erros.gender }}</p>
        </div>

        <!-- Status -->
        <div class="form-group">
          <label class="form-label">Status</label>
          <div class="flex items-center space-x-4">
            <label class="inline-flex items-center">
              <input
                type="radio"
                v-model="animal.is_active"
                :value="true"
                class="form-radio"
              />
              <span class="ml-2">Ativo</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                v-model="animal.is_active"
                :value="false"
                class="form-radio"
              />
              <span class="ml-2">Inativo</span>
            </label>
          </div>
        </div>

        <!-- Botões -->
        <div class="flex justify-end space-x-4">
          <router-link 
            to="/animais" 
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
            {{ isEditing ? 'Salvar Alterações' : 'Cadastrar Animal' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from '@/plugins/axios'

const route = useRoute()
const router = useRouter()
const isEditing = computed(() => !!route.params.id)
const salvando = ref(false)
const erros = ref({})

const animal = ref({
  name: '',
  tutor_id: '',
  species_id: '',
  breed_id: '',
  birth_date: '',
  weight: '',
  is_active: true,
  gender: 'male'
})

const tutores = ref([])
const especies = ref([])
const racas = ref([])

const carregarTutores = async () => {
  try {
    console.log('Carregando tutores...')
    const response = await axios.get('/tutors')
    console.log('Resposta da API (tutores):', response.data)
    tutores.value = response.data.data || response.data
    console.log('Tutores carregados:', tutores.value)
  } catch (error) {
    console.error('Erro ao carregar tutores:', error)
    if (error.response) {
      console.error('Detalhes do erro:', error.response.data)
    }
  }
}

const carregarEspecies = async () => {
  try {
    console.log('Carregando espécies...')
    const response = await axios.get('/species')
    console.log('Resposta da API (espécies):', response.data)
    especies.value = response.data.data || response.data
    console.log('Espécies carregadas:', especies.value)
  } catch (error) {
    console.error('Erro ao carregar espécies:', error)
    if (error.response) {
      console.error('Detalhes do erro:', error.response.data)
    }
  }
}

const carregarRacas = async (speciesId) => {
  try {
    console.log('Carregando raças para espécie:', speciesId)
    const response = await axios.get(`/breeds?species_id=${speciesId}`)
    console.log('Resposta da API (raças):', response.data)
    racas.value = response.data.data || response.data
    console.log('Raças carregadas:', racas.value)
  } catch (error) {
    console.error('Erro ao carregar raças:', error)
    if (error.response) {
      console.error('Detalhes do erro:', error.response.data)
    }
  }
}

const carregarAnimal = async (id) => {
  try {
    console.log('Carregando animal:', id)
    const response = await axios.get(`/animals/${id}`)
    console.log('Resposta da API (animal):', response.data)
    animal.value = response.data.data || response.data
    if (animal.value.species_id) {
      await carregarRacas(animal.value.species_id)
    }
  } catch (error) {
    console.error('Erro ao carregar animal:', error)
    if (error.response) {
      console.error('Detalhes do erro:', error.response.data)
    }
    alert('Erro ao carregar animal')
  }
}

const validarFormulario = () => {
  const dados = animal.value
  console.log('Validando dados do animal:', dados)
  
  if (!dados.gender) {
    erros.value.gender = ['O gênero é obrigatório']
    return false
  }
  
  if (!['male', 'female'].includes(dados.gender)) {
    erros.value.gender = ['Gênero inválido. Use "male" ou "female"']
    return false
  }
  
  return true
}

const salvarAnimal = async () => {
  try {
    salvando.value = true
    erros.value = {}

    if (!validarFormulario()) {
      return
    }

    console.log('Dados do animal antes de salvar:', JSON.stringify(animal.value, null, 2))
    if (isEditing.value) {
      const response = await axios.put(`/animals/${route.params.id}`, animal.value)
      console.log('Resposta da API (atualização):', response.data)
    } else {
      const response = await axios.post('/animals', animal.value)
      console.log('Resposta da API (criação):', response.data)
    }
    router.push('/animais')
  } catch (error) {
    console.error('Erro ao salvar animal:', error)
    if (error.response?.data?.errors) {
      erros.value = error.response.data.errors
      console.error('Erros de validação:', erros.value)
    } else {
      alert('Erro ao salvar animal')
    }
  } finally {
    salvando.value = false
  }
}

watch(() => animal.value.species_id, async (newValue) => {
  if (newValue) {
    await carregarRacas(newValue)
    animal.value.breed_id = ''
  } else {
    racas.value = []
    animal.value.breed_id = ''
  }
})

onMounted(async () => {
  console.log('Componente montado')
  await carregarTutores()
  await carregarEspecies()
  if (isEditing.value) {
    await carregarAnimal(route.params.id)
  }
})
</script>
  