import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/api/api'
import router from '@/router'

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

  async function register(data) {
    try {
      const response = await api.register(data)
      const receivedToken = response.data.token

      if (receivedToken) {
        setToken(receivedToken)
        await fetchUser()
        router.push('/habits')
        return { success: true }
      } else {
        return { success: false, error: 'Нет токена в ответе' }
      }
    } catch (error) {
      return {
        success: false,
        error: error.response?.data?.message || 'Ошибка регистрации'
      }
    }
  }

  async function login(credentials) {
    try {
      const response = await api.login(credentials)
      if (response.data.token) {
        setToken(response.data.token)
        await fetchUser()
        router.push('/habits')
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
      router.push('/auth')
    }
  }

  async function logout() {
    try {
      if (token.value) {
        await api.logout(token.value)
      }
    } catch (e) {
      console.warn('Ошибка выхода (игнорируется)', e)
    } finally {
      clearAuth()
      router.push('/auth')
    }
  }

  return {
    user,
    token,
    isAuthenticated,
    login,
    register,
    logout,
    fetchUser,
    setToken,
    clearAuth
  }
})
