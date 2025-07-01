
<template>
  <form @submit.prevent="submitRegister" class="form">
    <h2>Регистрация</h2>

    <div class="form-group">
      <label>Имя</label>
      <input v-model="name" type="text" required />
    </div>

    <div class="form-group">
      <label>Email</label>
      <input v-model="email" type="email" required />
    </div>

    <div class="form-group">
      <label>Пароль</label>
      <input v-model="password" type="password" required />
    </div>

    <div class="form-group">
      <label>Подтверждение пароля</label>
      <input v-model="passwordConfirm" type="password" required />
    </div>

    <button type="submit">Зарегистрироваться</button>

    <p class="switch" @click="$emit('toggle')">
      Уже есть аккаунт? <span>Войти</span>
    </p>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import api from '@/api/api'
import { useAuthStore } from '@/stores/auth'

const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirm = ref('')

const authStore = useAuthStore()

async function submitRegister() {
  if (password.value !== passwordConfirm.value) {
    alert('Пароли не совпадают')
    return
  }

  try {
    const response = await api.register({
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: passwordConfirm.value
    })

    // Проверяем токен в ответе
    const token = response.data.token
    if (token) {
      authStore.setToken(token)  // сохраняем токен
      alert('Регистрация успешна!')
    } else {
      alert('Токен не получен после регистрации')
    }

    console.log(response.data)
  } catch (error) {
    console.error(error)
    alert('Ошибка при регистрации')
  }
}



</script>



<style scoped>
.form {
  width: 100%;
  max-width: 400px;
  padding: 2rem;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
}
.form-group {
  margin-bottom: 1rem;
}
label {
  display: block;
  margin-bottom: 0.3rem;
}
input {
  width: 100%;
  padding: 0.6rem;
  border-radius: 4px;
  border: 1px solid #ccc;
}
button {
  width: 100%;
  padding: 0.8rem;
  background-color: #2a6d92;
  color: white;
  border: none;
  border-radius: 4px;
  font-weight: bold;
  margin-top: 1rem;
}
.switch {
  margin-top: 1rem;
  text-align: center;
  color: #2a6d92;
  cursor: pointer;
}
.switch span {
  text-decoration: underline;
}
</style>
