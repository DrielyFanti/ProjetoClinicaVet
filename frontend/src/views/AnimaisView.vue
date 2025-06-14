<template>
  <div class="p-6">
    <div class="flex justify-between items-center mb-6">
      <h1 class="text-2xl font-bold text-gray-800">Animais</h1>
      <router-link to="/animais/novo" class="btn btn-primary">
        <i class="fas fa-plus mr-2"></i>
        Novo Animal
      </router-link>
    </div>

    <!-- Estado de carregamento -->
    <div v-if="carregando" class="card text-center py-12">
      <div class="loading-spinner mx-auto"></div>
      <p class="mt-4 text-gray-600">Carregando animais...</p>
    </div>

    <!-- Estado de erro -->
    <div v-else-if="erro" class="card bg-red-50 border border-red-200">
      <div class="flex items-center text-red-800">
        <i class="fas fa-exclamation-circle text-xl mr-3"></i>
        <p>{{ erro }}</p>
      </div>
      <button 
        @click="carregarAnimais" 
        class="mt-4 btn btn-secondary"
      >
        <i class="fas fa-sync-alt mr-2"></i>
        Tentar novamente
      </button>
    </div>

    <!-- Lista vazia -->
    <div v-else-if="animais.length === 0" class="card text-center py-12">
      <i class="fas fa-paw text-4xl text-gray-400 mb-4"></i>
      <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum animal cadastrado</h3>
      <p class="text-gray-500 mb-6">Comece cadastrando um novo animal.</p>
      <router-link to="/animais/novo" class="btn btn-primary">
        <i class="fas fa-plus mr-2"></i>
        Cadastrar Animal
      </router-link>
    </div>

    <!-- Lista de animais -->
    <div v-else class="card">
      <div class="table-container">
        <table class="table">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Espécie</th>
              <th>Tutor</th>
              <th>Gênero</th>
              <th>Idade</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="animal in animais" :key="animal.id">
              <td>{{ animal.name }}</td>
              <td>{{ animal.species?.name || 'Não informado' }}</td>
              <td>{{ animal.tutor?.name || 'Não informado' }}</td>
              <td>{{ animal.gender === 'male' ? 'Macho' : 'Fêmea' }}</td>
              <td>{{ calcularIdade(animal.birth_date) }}</td>
              <td>
                <div class="flex space-x-2">
                  <router-link 
                    :to="'/animais/editar/' + animal.id" 
                    class="text-blue-600 hover:text-blue-800"
                    title="Editar"
                  >
                    <i class="fas fa-edit"></i>
                  </router-link>
                  <button 
                    @click="confirmarExclusao(animal)" 
                    class="text-red-600 hover:text-red-800"
                    title="Excluir"
                  >
                    <i class="fas fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Modal de confirmação -->
    <div v-if="mostrarModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
      <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Confirmar Exclusão</h3>
        <p class="text-gray-500 mb-6">
          Tem certeza que deseja excluir o animal "{{ animalParaExcluir?.name }}"? Esta ação não pode ser desfeita.
        </p>
        <div class="flex justify-end space-x-3">
          <button 
            @click="mostrarModal = false" 
            class="btn btn-secondary"
          >
            Cancelar
          </button>
          <button 
            @click="excluirAnimal" 
            class="btn btn-danger"
            :disabled="excluindo"
          >
            <i class="fas" :class="excluindo ? 'fa-spinner fa-spin' : 'fa-trash'"></i>
            <span class="ml-2">{{ excluindo ? 'Excluindo...' : 'Excluir' }}</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '@/plugins/axios'

const animais = ref([])
const carregando = ref(true)
const erro = ref(null)
const mostrarModal = ref(false)
const animalParaExcluir = ref(null)
const excluindo = ref(false)

const carregarAnimais = async () => {
  try {
    carregando.value = true
    erro.value = null
    
    const response = await axios.get('/animals')
    animais.value = response.data.data || response.data
  } catch (err) {
    console.error('Erro ao carregar animais:', err)
    erro.value = 'Erro ao carregar animais. Por favor, tente novamente.'
  } finally {
    carregando.value = false
  }
}

const calcularIdade = (dataNascimento) => {
  if (!dataNascimento) return 'Não informado'
  
  const hoje = new Date()
  const nascimento = new Date(dataNascimento)
  let idade = hoje.getFullYear() - nascimento.getFullYear()
  const mesAtual = hoje.getMonth()
  const mesNascimento = nascimento.getMonth()
  
  if (mesAtual < mesNascimento || (mesAtual === mesNascimento && hoje.getDate() < nascimento.getDate())) {
    idade--
  }
  
  return `${idade} anos`
}

const confirmarExclusao = (animal) => {
  animalParaExcluir.value = animal
  mostrarModal.value = true
}

const excluirAnimal = async () => {
  if (!animalParaExcluir.value) return

  try {
    excluindo.value = true
    await axios.delete(`/animals/${animalParaExcluir.value.id}`)
    animais.value = animais.value.filter(a => a.id !== animalParaExcluir.value.id)
    mostrarModal.value = false
    animalParaExcluir.value = null
  } catch (err) {
    console.error('Erro ao excluir animal:', err)
    alert('Erro ao excluir animal. Por favor, tente novamente.')
  } finally {
    excluindo.value = false
  }
}

onMounted(() => {
  carregarAnimais()
})
</script>
  