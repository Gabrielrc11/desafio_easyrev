<template>
  <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
    <div class="flex justify-between items-start mb-4">
      <div>
        <h3 class="text-lg font-semibold text-gray-800">{{ room.name }}</h3>
        <span class="inline-block px-2 py-1 text-xs font-medium rounded-full"
              :class="typeColor">
          {{ room.type }}
        </span>
      </div>
      <div class="text-right">
        <p class="text-2xl font-bold text-green-600">
          R$ {{ currentPrice }}
        </p>
        <p class="text-sm text-gray-500">Preço atual</p>
      </div>
    </div>
    
    <div class="space-y-2">
      <h4 class="font-medium text-gray-700">Histórico de Preços:</h4>
      <div class="max-h-32 overflow-y-auto">
        <div v-for="price in room.prices" :key="price.id" 
             class="flex justify-between text-sm py-1 border-b border-gray-100">
          <span>{{ formatDate(price.effective_date) }}</span>
          <span class="font-medium">R$ {{ price.price }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  room: {
    type: Object,
    required: true
  }
})

const typeColor = computed(() => {
  const colors = {
    'Standard': 'bg-blue-100 text-blue-800',
    'Deluxe': 'bg-purple-100 text-purple-800',
    'Suite': 'bg-gold-100 text-gold-800 bg-yellow-100 text-yellow-800'
  }
  return colors[props.room.type] || 'bg-gray-100 text-gray-800'
})

const currentPrice = computed(() => {
  if (!props.room.prices || props.room.prices.length === 0) return '0,00'
  const latest = props.room.prices[props.room.prices.length - 1]
  return latest.price
})

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('pt-BR')
}
</script>