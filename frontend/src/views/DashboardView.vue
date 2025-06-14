<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-6">Dashboard</h1>
  
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-blue-100 rounded p-4 text-center">
          <div class="text-xl font-bold">{{ contagem.tutores }}</div>
          <div class="text-sm">Tutores</div>
        </div>
        <div class="bg-green-100 rounded p-4 text-center">
          <div class="text-xl font-bold">{{ contagem.animais }}</div>
          <div class="text-sm">Animais</div>
        </div>
        <div class="bg-yellow-100 rounded p-4 text-center">
          <div class="text-xl font-bold">{{ contagem.consultas }}</div>
          <div class="text-sm">Consultas</div>
        </div>
        <div class="bg-purple-100 rounded p-4 text-center">
          <div class="text-xl font-bold">{{ contagem.servicos }}</div>
          <div class="text-sm">Serviços</div>
        </div>
      </div>
    </div>
  </template>
  

  <script setup>
  import { ref, onMounted } from 'vue'
  import axios from 'axios'

  const contagem = ref({
    tutores: 0,
    animais: 0,
    consultas: 0,
    servicos: 0
  })
  
  const carregarContagem = async () => {
    try {
      const [tutores, animais, consultas, servicos] = await Promise.all([
        axios.get('http://localhost:8000/api/tutors'),
        axios.get('http://localhost:8000/api/animals'),
        axios.get('http://localhost:8000/api/appointments'),
        axios.get('http://localhost:8000/api/service-types')
      ])
  
      contagem.value = {
        tutores: tutores.data.length,
        animais: animais.data.length,
        consultas: consultas.data.length,
        servicos: servicos.data.length
      }
    } catch (error) {
      console.error('Erro ao carregar dados:', error)
      // You might want to show an error message to the user here
    }
  }
  
  onMounted(() => {
    carregarContagem()
  })
  </script>
  