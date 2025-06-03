import { defineStore } from 'pinia'

export const useHotelStore = defineStore('hotel', {
  state: () => ({
    rooms: [], // Inicializar como array vazio
    loading: false,
    error: null,
    prediction: null
  }),

  actions: {
    async fetchRooms() {
      this.loading = true
      this.error = null
      
      try {
        const config = useRuntimeConfig()
        
        // Fazer a requisição para a API
        const response = await $fetch(`${config.public.apiBase}/rooms`)
        
        // Verificar se a resposta tem a estrutura esperada
        if (response && Array.isArray(response)) {
          this.rooms = response
        } else if (response && response.data && Array.isArray(response.data)) {
          this.rooms = response.data
        } else {
          console.warn('Formato de resposta inesperado:', response)
          this.rooms = []
        }
        
      } catch (error) {
        this.error = 'Erro ao carregar quartos. Verifique se o backend está funcionando.'
        this.rooms = [] // Garantir que rooms seja sempre um array
        console.error('Erro na API:', error)
      } finally {
        this.loading = false
      }
    },

    async updateRoomPrice(roomId, priceData) {
      this.loading = true
      this.error = null
      
      try {
        const config = useRuntimeConfig()
        const response = await $fetch(`${config.public.apiBase}/rooms/${roomId}/price`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: priceData
        })
        
        // Verificar se há uma previsão na resposta
        if (response && response.predicted_price) {
          this.prediction = response.predicted_price
        } else if (response && response.data && response.data.predicted_price) {
          this.prediction = response.data.predicted_price
        }
        
        // Recarregar dados após atualização
        await this.fetchRooms()
        
        return response
      } catch (error) {
        this.error = 'Erro ao calcular previsão. Verifique os dados informados.'
        console.error('Erro ao calcular previsão:', error)
        throw error
      } finally {
        this.loading = false
      }
    },

    clearError() {
      this.error = null
    },

    clearPrediction() {
      this.prediction = null
    }
  }
})