import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/api/api'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(localStorage.getItem('token') || null)
  const isAuthenticated = ref(!!token.value)

  if (token.value) {
    fetchUser()
  }

  function setToken(newToken) {
    token.value = newToken
    isAuthenticated.value = true
    localStorage.setItem('token', newToken)
  }

  function clearAuth() {
    user.value = null
    token.value = null
    isAuthenticated.value = false
    localStorage.removeItem('token')
  }

  async function login(credentials) {
    try {
      const response = await api.login(credentials)
      if (response.data.token) {
        setToken(response.data.token)
        await fetchUser()
        return { success: true }
      } else {
        return { success: false, error: 'Нет токена в ответе' }
      }
    } catch (error) {
      return {
        success: false,
        error: error.response?.data?.message || 'Ошибка входа'
      }
    }
  }

  async function fetchUser() {
    if (!token.value) return
    try {
      const response = await api.getUser(token.value)
      user.value = response.data
    } catch (error) {
      console.error('Ошибка загрузки пользователя', error)
      clearAuth()
    }
  }

  async function logout() {
    if (!token.value) return
    try {
      await api.logout(token.value)
    } catch (e) {
      console.warn('Ошибка выхода (игнорируется)', e)
    }
    clearAuth()
  }

  return {
    user,
    token,
    isAuthenticated,
    login,
    logout,
    fetchUser,
    setToken
  }
})
