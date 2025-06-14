<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white">
      <div class="absolute inset-0 bg-black opacity-20"></div>
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
        <div class="text-center">
          <h1 class="text-4xl md:text-6xl font-bold mb-6">
            Clínica Veterinária
          </h1>
          <p class="text-xl md:text-2xl mb-8">
            Cuidando com amor e dedicação do seu melhor amigo
          </p>
          <div class="flex justify-center space-x-4">
            <router-link 
              to="/consultas/nova" 
              class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition duration-300"
            >
              Agendar Consulta
            </router-link>
            <router-link 
              to="/animais/novo" 
              class="bg-transparent border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300"
            >
              Cadastrar Animal
            </router-link>
          </div>
        </div>
      </div>
    </div>

    <!-- Serviços Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <h2 class="text-3xl font-bold text-center mb-12">Nossos Serviços</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300">
          <div class="text-blue-600 text-4xl mb-4">
            <i class="fas fa-stethoscope"></i>
          </div>
          <h3 class="text-xl font-semibold mb-2">Consultas</h3>
          <p class="text-gray-600">
            Atendimento veterinário completo para seu pet, com profissionais altamente qualificados.
          </p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300">
          <div class="text-blue-600 text-4xl mb-4">
            <i class="fas fa-syringe"></i>
          </div>
          <h3 class="text-xl font-semibold mb-2">Vacinação</h3>
          <p class="text-gray-600">
            Mantenha seu pet protegido com nosso serviço completo de vacinação.
          </p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300">
          <div class="text-blue-600 text-4xl mb-4">
            <i class="fas fa-cut"></i>
          </div>
          <h3 class="text-xl font-semibold mb-2">Banho e Tosa</h3>
          <p class="text-gray-600">
            Cuidados estéticos e higiênicos para deixar seu pet ainda mais bonito.
          </p>
        </div>
      </div>
    </div>

    <!-- Estatísticas Section -->
    <div class="bg-blue-600 text-white py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
          <div>
            <div class="text-4xl font-bold mb-2">{{ estatisticas.animais }}</div>
            <div class="text-blue-100">Animais Atendidos</div>
          </div>
          <div>
            <div class="text-4xl font-bold mb-2">{{ estatisticas.tutores }}</div>
            <div class="text-blue-100">Tutores Cadastrados</div>
          </div>
          <div>
            <div class="text-4xl font-bold mb-2">{{ estatisticas.consultas }}</div>
            <div class="text-blue-100">Consultas Realizadas</div>
          </div>
          <div>
            <div class="text-4xl font-bold mb-2">{{ estatisticas.servicos }}</div>
            <div class="text-blue-100">Serviços Disponíveis</div>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
      <div class="bg-gradient-to-r from-blue-500 to-blue-700 rounded-2xl p-8 md:p-12 text-white text-center">
        <h2 class="text-3xl font-bold mb-4">Precisa de ajuda?</h2>
        <p class="text-xl mb-8">
          Nossa equipe está pronta para atender você e seu pet com todo carinho e dedicação.
        </p>
        <router-link 
          to="/tutores/novo" 
          class="inline-block bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition duration-300"
        >
          Cadastre-se Agora
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../services/api'

const estatisticas = ref({
  animais: 0,
  tutores: 0,
  consultas: 0,
  servicos: 0
})

const carregarEstatisticas = async () => {
  try {
    const [animais, tutores, consultas, servicos] = await Promise.all([
      api.get('/animals'),
      api.get('/tutors'),
      api.get('/appointments'),
      api.get('/service-types')
    ])

    estatisticas.value = {
      animais: animais.data.length,
      tutores: tutores.data.length,
      consultas: consultas.data.length,
      servicos: servicos.data.length
    }
  } catch (error) {
    console.error('Erro ao carregar estatísticas:', error)
  }
}

onMounted(() => {
  carregarEstatisticas()
})
</script>

<style>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css');
</style> 