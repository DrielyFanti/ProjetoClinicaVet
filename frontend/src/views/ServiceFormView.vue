<template>
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">
        {{ isEditing ? 'Editar Serviço' : 'Novo Serviço' }}
      </h1>
      <router-link 
        to="/servicos" 
        class="btn-secondary"
      >
        <i class="fas fa-arrow-left mr-2"></i>
        Voltar
      </router-link>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
      <form @submit.prevent="saveService" class="space-y-6">
        <!-- Nome -->
        <div class="form-group">
          <label class="form-label">Nome</label>
          <input
            type="text"
            v-model="service.name"
            class="form-input"
            :class="{ 'border-red-500': erros.name }"
            placeholder="Nome do serviço"
            required
          />
          <p v-if="erros.name" class="form-error">{{ erros.name }}</p>
        </div>

        <!-- Preço -->
        <div class="form-group">
          <label class="form-label">Preço</label>
          <input
            type="number"
            v-model="service.price"
            class="form-input"
            :class="{ 'border-red-500': erros.price }"
            placeholder="0.00"
            step="0.01"
            min="0"
            required
          />
          <p v-if="erros.price" class="form-error">{{ erros.price }}</p>
        </div>

        <!-- Descrição -->
        <div class="form-group">
          <label class="form-label">Descrição</label>
          <textarea
            v-model="service.description"
            class="form-input"
            :class="{ 'border-red-500': erros.description }"
            placeholder="Descrição do serviço"
            rows="3"
          ></textarea>
          <p v-if="erros.description" class="form-error">{{ erros.description }}</p>
        </div>

        <!-- Status -->
        <div class="form-group">
          <label class="form-label">Status</label>
          <div class="flex items-center space-x-4">
            <label class="inline-flex items-center">
              <input
                type="radio"
                v-model="service.is_active"
                :value="true"
                class="form-radio"
              />
              <span class="ml-2">Ativo</span>
            </label>
            <label class="inline-flex items-center">
              <input
                type="radio"
                v-model="service.is_active"
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
            to="/servicos" 
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
            {{ isEditing ? 'Salvar Alterações' : 'Cadastrar Serviço' }}
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

const service = ref({
  name: '',
  price: '',
  description: '',
  is_active: true
})

const loadService = async (id) => {
  try {
    const response = await axios.get(`/services/${id}`)
    service.value = response.data
  } catch (error) {
    console.error('Erro ao carregar serviço:', error)
    alert('Erro ao carregar serviço')
  }
}

const saveService = async () => {
  try {
    salvando.value = true
    erros.value = {}

    if (isEditing.value) {
      await axios.put(`/services/${route.params.id}`, service.value)
    } else {
      await axios.post('/services', service.value)
    }
    router.push('/servicos')
  } catch (error) {
    console.error('Erro ao salvar serviço:', error)
    if (error.response?.data?.errors) {
      erros.value = error.response.data.errors
    } else {
      alert('Erro ao salvar serviço')
    }
  } finally {
    salvando.value = false
  }
}

onMounted(() => {
  if (isEditing.value) {
    loadService(route.params.id)
  }
})
</script> 