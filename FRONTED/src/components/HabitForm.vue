<template>
  <div class="habit-form-container">
    <button v-if="!isOpen" class="open-form-btn" @click="isOpen = true">
      + Новая привычка
    </button>

    <form v-else class="habit-form" @submit.prevent="handleSubmit">
      <input
        v-model="newHabit.name"
        type="text"
        placeholder="Название привычки"
        class="habit-input"
        required
      />

      <textarea
        v-model="newHabit.description"
        placeholder="Описание (необязательно)"
        class="habit-description"
        rows="2"
      ></textarea>

      <div class="days-selector">
        <label
          v-for="(day, index) in daysOfWeek"
          :key="index"
          class="day-checkbox"
        >
          <input
            type="checkbox"
            :value="index"
            v-model="newHabit.days"
          />
          {{ day }}
        </label>
      </div>

      <div class="reminder-time">
        <label>Напоминание:</label>
        <input
          v-model="newHabit.reminder"
          type="time"
          class="time-input"
        />
      </div>

      <div class="form-actions">
        <button type="submit" class="submit-btn">Добавить</button>
        <button type="button" class="cancel-btn" @click="cancel">Отмена</button>
      </div>

      <p v-if="errorMessage" class="error-msg">{{ errorMessage }}</p>
    </form>
  </div>
</template>

<script setup>
import {ref} from 'vue'
import api from '@/api/api'
import {useAuthStore} from '@/stores/auth'

const auth = useAuthStore()
const isOpen = ref(false)
const daysOfWeek = ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']
const newHabit = ref({
  name: '',
  description: '',
  days: [],
  reminder: ''
})
const emit = defineEmits(['created'])
const errorMessage = ref('')

function resetForm() {
  newHabit.value = {
    name: '',
    description: '',
    days: [],
    reminder: ''
  }
  isOpen.value = false
  errorMessage.value = ''
}

async function handleSubmit() {
  if (!newHabit.value.name.trim()) return

  try {
    const payload = {
      title: newHabit.value.name,
      description: newHabit.value.description,
      reminder_time: newHabit.value.reminder,
      day_ids: newHabit.value.days
    }

    const response = await api.addHabit(payload, auth.token)

    emit('created', response.data)

    resetForm()
  } catch (err) {
    console.error('Ошибка при добавлении привычки:', err)
    errorMessage.value = err.response?.data?.message || 'Не удалось добавить привычку'
  }
}

function cancel() {
  resetForm()
}
</script>


<style scoped>

.habit-form-container {
  margin-top: 1rem;
}

.open-form-btn {
  padding: 0.75rem 1.5rem;
  font-size: 16px;
  background-color: #2a6d92;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}


.habit-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  background-color: #f5f9fb;
  padding: 1rem;
  border-radius: 8px;
  border: 1px solid #ccc;
  margin-top: 0.5rem;
}

.habit-input,
.habit-description,
.time-input {
  padding: 0.5rem;
  font-size: 16px;
  border-radius: 6px;
  border: 1px solid #ccc;
}

.days-selector {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.day-checkbox {
  font-size: 14px;
  display: flex;
  align-items: center;
  gap: 4px;
}

.reminder-time {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.form-actions {
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
}

.submit-btn {
  background-color: #28a745;
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.cancel-btn {
  background-color: #dc3545;
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}
</style>
