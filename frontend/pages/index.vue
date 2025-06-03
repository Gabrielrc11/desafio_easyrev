<template>
  <div class="min-h-screen bg-gray-50">
    <div class="container mx-auto px-4 py-8">
      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
          Sistema de Previsão de Preços - Hotelaria
        </h1>
        <p class="text-gray-600">
          Gerencie e preveja os preços das diárias do seu hotel
        </p>
      </div>

      <!-- Loading -->
      <div v-if="loading && (!rooms || rooms.length === 0)" class="text-center py-8">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
        <p class="mt-2 text-gray-600">Carregando dados...</p>
      </div>

      <!-- Error -->
      <div v-if="error && (!rooms || rooms.length === 0)" class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
        <p class="text-red-700">{{ error }}</p>
        <button @click="fetchRooms" class="mt-2 text-red-600 hover:text-red-800 underline">
          Tentar novamente
        </button>
      </div>

      <!-- Content -->
      <div v-if="rooms && rooms.length > 0" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Calculadora de Previsão -->
        <div class="lg:col-span-1">
          <PricePredictor />
        </div>

        <!-- Lista de Quartos -->
        <div class="lg:col-span-2">
          <h2 class="text-xl font-semibold text-gray-800 mb-4">Quartos e Histórico</h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <RoomCard v-for="room in rooms" :key="room.id" :room="room" />
          </div>
        </div>
      </div>

      <!-- Estado inicial sem dados -->
      <div v-if="!loading && (!rooms || rooms.length === 0) && !error" class="text-center py-12">
        <div class="text-gray-400 mb-4">
          <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
          </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhum quarto encontrado</h3>
        <p class="text-gray-600 mb-4">Verifique se o backend está funcionando corretamente</p>
        <button @click="fetchRooms" 
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
          Recarregar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
const hotelStore = useHotelStore()
const { rooms, loading, error } = storeToRefs(hotelStore)

// Buscar dados ao montar o componente
onMounted(() => {
  hotelStore.fetchRooms()
})

// Método para tentar buscar dados novamente
const fetchRooms = () => {
  hotelStore.fetchRooms()
}

// Meta tags
useHead({
  title: 'Sistema de Previsão de Preços'
})
</script>