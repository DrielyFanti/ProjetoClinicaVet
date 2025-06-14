<template>
  <div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">
        {{ isEditing ? 'Editar Tutor' : 'Novo Tutor' }}
      </h1>
      <router-link 
        to="/tutores" 
        class="btn-secondary"
      >
        <i class="fas fa-arrow-left mr-2"></i>
        Voltar
      </router-link>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
      <form @submit.prevent="salvarTutor" class="space-y-6">
        <!-- Nome -->
        <div class="form-group">
          <label class="form-label">Nome</label>
          <input 
            type="text" 
            v-model="tutor.name" 
            class="form-input"
            :class="{ 'border-red-500': erros.name }"
            placeholder="Nome completo"
          >
          <p v-if="erros.name" class="form-error">{{ erros.name }}</p>
        </div>

        <!-- CPF -->
        <div class="form-group">
          <label class="form-label">CPF</label>
          <input 
            type="text" 
            v-model="tutor.cpf" 
            class="form-input"
            :class="{ 'border-red-500': erros.cpf }"
            placeholder="000.000.000-00"
            v-mask="'###.###.###-##'"
          >
          <p v-if="erros.cpf" class="form-error">{{ erros.cpf }}</p>
        </div>

        <!-- Email -->
        <div class="form-group">
          <label class="form-label">Email</label>
          <input 
            type="email" 
            v-model="tutor.email" 
            class="form-input"
            :class="{ 'border-red-500': erros.email }"
            placeholder="email@exemplo.com"
          >
          <p v-if="erros.email" class="form-error">{{ erros.email }}</p>
        </div>

        <!-- Telefone -->
        <div class="form-group">
          <label class="form-label">Telefone</label>
          <input 
            type="text" 
            v-model="tutor.phone" 
            class="form-input"
            :class="{ 'border-red-500': erros.phone }"
            placeholder="(00) 0000-0000"
            v-mask="'(##) ####-####'"
          >
          <p v-if="erros.phone" class="form-error">{{ erros.phone }}</p>
        </div>

        <!-- WhatsApp -->
        <div class="form-group">
          <label class="form-label">WhatsApp</label>
          <input 
            type="text" 
            v-model="tutor.whatsapp" 
            class="form-input"
            :class="{ 'border-red-500': erros.whatsapp }"
            placeholder="(00) 00000-0000"
            v-mask="'(##) #####-####'"
          >
          <p v-if="erros.whatsapp" class="form-error">{{ erros.whatsapp }}</p>
        </div>

        <!-- Endereço -->
        <div class="form-group">
          <label class="form-label">Endereço</label>
          <input 
            type="text" 
            v-model="tutor.address" 
            class="form-input"
            :class="{ 'border-red-500': erros.address }"
            placeholder="Rua, número, complemento"
          >
          <p v-if="erros.address" class="form-error">{{ erros.address }}</p>
        </div>

        <!-- Cidade e Estado -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-group">
            <label class="form-label">Cidade</label>
            <input 
              type="text" 
              v-model="tutor.city" 
              class="form-input"
              :class="{ 'border-red-500': erros.city }"
              placeholder="Cidade"
            >
            <p v-if="erros.city" class="form-error">{{ erros.city }}</p>
          </div>

          <div class="form-group">
            <label class="form-label">Estado</label>
            <select 
              v-model="tutor.state" 
              class="form-select"
              :class="{ 'border-red-500': erros.state }"
            >
              <option value="">Selecione</option>
              <option v-for="uf in estados" :key="uf" :value="uf">
                {{ uf }}
              </option>
            </select>
            <p v-if="erros.state" class="form-error">{{ erros.state }}</p>
          </div>
        </div>

        <!-- CEP -->
        <div class="form-group">
          <label class="form-label">CEP</label>
          <input 
            type="text" 
            v-model="tutor.zip_code" 
            class="form-input"
            :class="{ 'border-red-500': erros.zip_code }"
            placeholder="00000-000"
            v-mask="'#####-###'"
          >
          <p v-if="erros.zip_code" class="form-error">{{ erros.zip_code }}</p>
        </div>

        <!-- Status -->
        <div class="form-group">
          <label class="form-label">Status</label>
          <div class="flex items-center space-x-4">
            <label class="inline-flex items-center">
              <input 
                type="radio" 
                v-model="tutor.is_active" 
                :value="true"
                class="form-radio"
              >
              <span class="ml-2">Ativo</span>
            </label>
            <label class="inline-flex items-center">
              <input 
                type="radio" 
                v-model="tutor.is_active" 
                :value="false"
                class="form-radio"
              >
              <span class="ml-2">Inativo</span>
            </label>
          </div>
        </div>

        <!-- Botões -->
        <div class="flex justify-end space-x-4">
          <router-link 
            to="/tutores" 
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
            {{ isEditing ? 'Salvar Alterações' : 'Cadastrar Tutor' }}
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

const tutor = ref({
  name: '',
  cpf: '',
  email: '',
  phone: '',
  whatsapp: '',
  address: '',
  city: '',
  state: '',
  zip_code: '',
  is_active: true
})

const erros = ref({})
const salvando = ref(false)

const estados = [
  'AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 
  'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 
  'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'
]

const validarFormulario = () => {
  erros.value = {}
  
  if (!tutor.value.name) {
    erros.value.name = 'O nome é obrigatório'
  }
  
  if (!tutor.value.cpf) {
    erros.value.cpf = 'O CPF é obrigatório'
  } else {
    const cpfNumeros = tutor.value.cpf.replace(/\D/g, '')
    if (cpfNumeros.length !== 11) {
      erros.value.cpf = 'CPF inválido'
    }
  }
  
  if (!tutor.value.email) {
    erros.value.email = 'O email é obrigatório'
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(tutor.value.email)) {
    erros.value.email = 'Email inválido'
  }
  
  if (!tutor.value.phone) {
    erros.value.phone = 'O telefone é obrigatório'
  } else {
    const phoneNumeros = tutor.value.phone.replace(/\D/g, '')
    if (phoneNumeros.length !== 10) {
      erros.value.phone = 'Telefone inválido'
    }
  }

  if (tutor.value.whatsapp) {
    const whatsappNumeros = tutor.value.whatsapp.replace(/\D/g, '')
    if (whatsappNumeros.length !== 11) {
      erros.value.whatsapp = 'WhatsApp inválido'
    }
  }

  if (tutor.value.state && tutor.value.state.length !== 2) {
    erros.value.state = 'Estado inválido'
  }

  if (tutor.value.zip_code) {
    const cepNumeros = tutor.value.zip_code.replace(/\D/g, '')
    if (cepNumeros.length !== 8) {
      erros.value.zip_code = 'CEP inválido'
    }
  }

  return Object.keys(erros.value).length === 0
}

const salvarTutor = async () => {
  if (!validarFormulario()) {
    return
  }

  try {
    salvando.value = true
    
    if (isEditing.value) {
      await axios.put(`/tutors/${route.params.id}`, tutor.value)
    } else {
      await axios.post('/tutors', tutor.value)
    }
    
    router.push('/tutores')
  } catch (err) {
    if (err.response?.data?.errors) {
      erros.value = err.response.data.errors
    } else {
      alert('Erro ao salvar tutor. Por favor, tente novamente.')
    }
    console.error('Erro ao salvar tutor:', err)
  } finally {
    salvando.value = false
  }
}

const carregarTutor = async () => {
  if (!isEditing.value) return

  try {
    const response = await axios.get(`/tutors/${route.params.id}`)
    tutor.value = response.data.data || response.data
  } catch (err) {
    alert('Erro ao carregar tutor. Por favor, tente novamente.')
    console.error('Erro ao carregar tutor:', err)
    router.push('/tutores')
  }
}

onMounted(carregarTutor)
</script>
  