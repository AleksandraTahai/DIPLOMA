import axios from 'axios'

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  withCredentials: false, // JWT не требует cookies
  headers: {
    Accept: 'application/json',
    'Content-Type': 'application/json',
  }
})

export default {
  register(data) {
    return api.post('/register', {
      name: data.name,
      email: data.email,
      password: data.password
    })
  },

  login(data) {
    return api.post('/login', {
      email: data.email,
      password: data.password
    })
  },

  getUser(token) {
    return api.get('/user', {
      headers: { Authorization: `Bearer ${token}` }
    })
  },

  logout(token) {
    return api.post('/logout', null, {
      headers: { Authorization: `Bearer ${token}` }
    })
  },

  getHabits(token) {
    return api.get('/habits', {
      headers: { Authorization: `Bearer ${token}` }
    })
  },

  addHabit(habitData, token) {
    return api.post('/habits', habitData, {
      headers: { Authorization: `Bearer ${token}` }
    })
  },

  updateHabit(id, habitData, token) {
    return api.put(`/habits/${id}`, habitData, {
      headers: { Authorization: `Bearer ${token}` }
    })
  },

  deleteHabit(id, token) {
    return api.delete(`/habits/${id}`, {
      headers: { Authorization: `Bearer ${token}` }
    })
  },

  updateHabitStatus(habitId, date, status, token) {
    return api.post(`/habits/${habitId}/log`, {
      date: date,
      status: status
    }, {
      headers: { Authorization: `Bearer ${token}` }
    })
  }
}
