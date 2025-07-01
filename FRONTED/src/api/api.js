import axios from 'axios'

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api', 
  withCredentials: true,
})

export default {
  register(data) {
    return api.post('/register', data)
  },
  login(data) {
    return api.post('/login', data)
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

  addHabit(habit, token) {
    return api.post('/habits', habit, {
      headers: { Authorization: `Bearer ${token}` }
    })
  },

  updateHabit(id, habit, token) {
    return api.put(`/habits/${id}`, habit, {
      headers: { Authorization: `Bearer ${token}` }
    })
  },

  deleteHabit(id, token) {
    return api.delete(`/habits/${id}`, {
      headers: { Authorization: `Bearer ${token}` }
    })
  },

  updateHabit(id, habitData, token) {
    return api.put(`/habits/${id}`, habitData, {
      headers: { Authorization: `Bearer ${token}` }
    })
}
}
