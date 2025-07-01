<!-- src/pages/LoginPage.vue -->
<script setup>
import { ref, computed } from 'vue'

import SignInForm from '@/components/SignInForm.vue'
import RegistrationForm from '@/components/RegistrationForm.vue'

const currentComponent = ref('SignInForm')

function toggleComponent() {
  currentComponent.value = isSignInForm.value ? 'RegistrationForm' : 'SignInForm'
}

const isSignInForm = computed(() => {
  return currentComponent.value === 'SignInForm'
})
</script>

<template>
  <div class="login-page">
    <component
      :is="isSignInForm ? SignInForm : RegistrationForm"
      @toggle="toggleComponent"
    />
  </div>
</template>

<style scoped>
.login-page {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
  background: #FFF4ED;
}
</style>
