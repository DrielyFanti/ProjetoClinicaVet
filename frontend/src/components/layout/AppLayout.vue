<template>
  <div class="min-h-screen bg-gray-50">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out"
           :class="{ '-translate-x-full': !isSidebarOpen, 'translate-x-0': isSidebarOpen }">
      <div class="flex items-center justify-center h-16 border-b">
        <img src="@/assets/logo.png" alt="Logo" class="h-8" />
      </div>
      
      <nav class="mt-6">
        <div class="px-4 mb-4">
          <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
            Principal
          </h3>
        </div>
        
        <router-link to="/" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
          <i class="fas fa-home w-5"></i>
          <span class="mx-3">Início</span>
        </router-link>

        <router-link to="/dashboard" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
          <i class="fas fa-chart-line w-5"></i>
          <span class="mx-3">Dashboard</span>
        </router-link>

        <div class="px-4 mt-6 mb-4">
          <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
            Gestão
          </h3>
        </div>

        <router-link to="/consultas" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
          <i class="fas fa-calendar-check w-5"></i>
          <span class="mx-3">Consultas</span>
        </router-link>

        <router-link to="/animais" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
          <i class="fas fa-paw w-5"></i>
          <span class="mx-3">Animais</span>
        </router-link>

        <router-link to="/tutores" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
          <i class="fas fa-users w-5"></i>
          <span class="mx-3">Tutores</span>
        </router-link>

        <router-link to="/servicos" class="flex items-center px-6 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-600">
          <i class="fas fa-clipboard-list w-5"></i>
          <span class="mx-3">Serviços</span>
        </router-link>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="ml-0 lg:ml-64 transition-all duration-300">
      <!-- Top Navigation -->
      <header class="bg-white shadow-sm">
        <div class="flex items-center justify-between h-16 px-4">
          <button @click="toggleSidebar" class="text-gray-500 hover:text-gray-600 lg:hidden">
            <i class="fas fa-bars text-xl"></i>
          </button>
          
          <div class="flex items-center">
            <div class="relative">
              <button class="flex items-center text-gray-500 hover:text-gray-600">
                <img class="h-8 w-8 rounded-full object-cover" src="https://ui-avatars.com/api/?name=Admin" alt="User" />
                <span class="ml-2">Admin</span>
                <i class="fas fa-chevron-down ml-2"></i>
              </button>
            </div>
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="p-6">
        <slot></slot>
      </main>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AppLayout',
  data() {
    return {
      isSidebarOpen: true
    }
  },
  methods: {
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen
    }
  }
}
</script>

<style scoped>
.router-link-active {
  @apply bg-blue-50 text-blue-600;
}
</style> 