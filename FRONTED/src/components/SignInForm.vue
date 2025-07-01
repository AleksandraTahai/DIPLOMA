<!-- src/components/SignInForm.vue -->
<template>
  <form @submit.prevent="submitLogin" class="form">
    <h2>Вход</h2>

    <div class="form-group">
      <label>Email</label>
      <input v-model="email" type="email" required />
    </div>

    <div class="form-group">
      <label>Пароль</label>
      <input v-model="password" type="password" required />
    </div>

    <button type="submit">Войти</button>

    <p class="switch" @click="$emit('toggle')">
      Нет аккаунта? <span>Зарегистрируйтесь</span>
    </p>
  </form>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const router = useRouter()

const email = ref('')
const password = ref('')

async function submitLogin() {
  const credentials = {
    email: email.value,
    password: password.value
  }

  const result = await auth.login(credentials)

  if (result.success) {
    alert('Вход выполнен успешно!')
     router.push('/')
  } else {
    alert(result.error)
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
