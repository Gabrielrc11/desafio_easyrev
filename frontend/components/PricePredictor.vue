<template>
  <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
    <h2 class="text-xl font-semibold text-gray-800 mb-6">Previsão de Preço</h2>
    
    <form @submit.prevent="calculatePrediction" class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Selecionar Quarto
        </label>
        <select v-model="selectedRoom" 
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Selecione um quarto</option>
          <option v-for="room in rooms" :key="room.id" :value="room.id">
            {{ room.name }} ({{ room.type }})
          </option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Taxa de Ocupação (%)
        </label>
        <input v-model.number="occupancyRate" 
               type="number" 
               min="0" 
               max="100" 
               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
               placeholder="Ex: 85">
      </div>

      <div class="flex items-center">
        <input v-model="isHoliday" 
               type="checkbox" 
               id="holiday"
               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
        <label for="holiday" class="ml-2 block text-sm text-gray-700">
          É feriado ou fim de semana
        </label>
      </div>

      <button type="submit" 
              :disabled="!selectedRoom || loading"
              class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:bg-gray-400 disabled:cursor-not-allowed">
        <span v-if="loading">Calculando...</span>
        <span v-else>Calcular Previsão</span>
      </button>
    </form>

    <!-- Resultado da Previsão -->
    <div v-if="prediction" class="mt-6 p-4 bg-green-50 border border-green-200 rounded-md">
      <h3 class="text-lg font-semibold text-green-800 mb-2">Previsão para o próximo dia:</h3>
      <p class="text-2xl font-bold text-green-600">R$ {{ prediction }}</p>
    </div>

    <!-- Erro -->
    <div v-if="error" class="mt-4 p-4 bg-red-50 border border-red-200 rounded-md">
      <p class="text-red-700">{{ error }}</p>
    </div>
  </div>
</template>

<script setup>
const hotelStore = useHotelStore()

const selectedRoom = ref('')
const occupancyRate = ref(85)
const isHoliday = ref(false)

const { rooms, loading, error, prediction } = storeToRefs(hotelStore)

const calculatePrediction = async () => {
  if (!selectedRoom.value) return
  
  try {
    await hotelStore.updateRoomPrice(selectedRoom.value, {
      occupancy_rate: occupancyRate.value,
      is_holiday_or_weekend: isHoliday.value
    })
  } catch (err) {
    console.error('Erro ao calcular previsão:', err)
  }
}
</script>