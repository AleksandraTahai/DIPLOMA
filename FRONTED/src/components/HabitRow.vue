<template>
  <div class="habit-row">
    <div class="habit-name-cell">
      <span :title="habit.description || ''">{{ habit.title }}</span>
      <div class="habit-actions">
        <button @click="isModalOpen = true" title="Редактировать" class="habit-actions_btn_f">✏️</button>
        <button @click="confirmDelete" title="Удалить" class="habit-actions_btn_s">🗑️</button>
      </div>
    </div>

    <div class="habit-days-grid">
      <div
          v-for="date in weekDates"
          :key="date.toDateString()"
          class="icon-cell"
      >
        <HabitIcon
            :status="getStatus(date)"
            :disabled="!canChangeStatus(date)"
            :habit-id="habit.id"
            :date="formatDate(date)"
            :token="token"
            @updated="(newStatus) => updateStatus(date, newStatus)"
        />
      </div>
    </div>

    <HabitEditModal
        v-if="isModalOpen"
        :initialHabit="habit"
        @close="isModalOpen = false"
        @save="saveEdit"
    />
  </div>
</template>

<script setup>
import { ref } from 'vue'
import HabitIcon from './HabitIcon.vue'
import HabitEditModal from './HabitEditModal.vue'
import api from '@/api/api'
import { useAuthStore } from '@/stores/auth'

const props = defineProps({
  habit: Object,
  weekDates: Array,
  token: String
})

const emit = defineEmits(['update', 'delete'])

const isModalOpen = ref(false)
const auth = useAuthStore()

function confirmDelete() {
  if (confirm(`Вы уверены, что хотите удалить привычку "${props.habit.title}"?`)) {
    emit('delete', props.habit.id)
  }
}

function formatDate(date) {
  return date.toISOString().split('T')[0]
}

function isPast(date) {
  const today = new Date()
  return date < new Date(today.getFullYear(), today.getMonth(), today.getDate())
}

function isActiveDay(date) {
  const dayNames = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота']
  const dayName = dayNames[date.getDay()]
  return props.habit.days?.some(d => d.day === dayName)
}


function getStatus(date) {
  const key = formatDate(date)
  const log = props.habit.logs?.[key]

  const currentDay = new Date(date.getFullYear(), date.getMonth(), date.getDate())

  const createdAtRaw = props.habit.createdAt || props.habit.create_time
  const createdAtDate = new Date(createdAtRaw)
  const createdAt = new Date(createdAtDate.getFullYear(), createdAtDate.getMonth(), createdAtDate.getDate())

  const now = new Date()
  const today = new Date(now.getFullYear(), now.getMonth(), now.getDate())

  const active = isActiveDay(date)

  if (!active) return -1
  if (currentDay < createdAt) return -1
  if (log === 1) return 1
  if (log === 0) return 0
  if (log === undefined && currentDay < today) return 2
  return 0
}

function canChangeStatus(date) {
  const today = new Date()
  return (
      isActiveDay(date) &&
      date.getFullYear() === today.getFullYear() &&
      date.getMonth() === today.getMonth() &&
      date.getDate() === today.getDate()
  )
}

async function updateStatus(date, newStatus) {
  if (!canChangeStatus(date)) return

  const key = formatDate(date)
  if (!props.habit.logs) props.habit.logs = {}
  props.habit.logs[key] = newStatus

  try {
    await api.updateHabitStatus(props.habit.id, key, newStatus, auth.token)
  } catch (err) {
    console.error('Ошибка при обновлении статуса:', err.response?.data || err.message)
    alert('Не удалось сохранить статус. Проверьте соединение или авторизацию.')
  }
}

function saveEdit(updatedHabit) {
  emit('update', {
    ...props.habit,
    title: updatedHabit.title,
    description: updatedHabit.description,
    days: [...updatedHabit.days].sort((a, b) => a.id - b.id)
  })
  isModalOpen.value = false
}
</script>

<style scoped>
.habit-row {
  display: flex;
  border-top: 1px solid #eee;
  align-items: center;
}

.habit-name-cell {
  width: 200px;
  padding: 0.5rem;
  display: flex;
  flex-direction: column;
  font-size: 19px;
  font-weight: 500;
}

.habit-actions {
  margin-top: 0.5rem;
  display: flex;
  gap: 8px;
}

.habit-days-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  flex: 1;
}

.icon-cell {
  text-align: center;
  padding: 4px;
}

.habit-actions_btn_f, .habit-actions_btn_s {
  border: none;
  padding: 3px 11px;
  border-radius: 6px;
  transition: all 0.2s;
  cursor: pointer;
}

.habit-actions_btn_f:hover, .habit-actions_btn_s:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.habit-actions_btn_f:active, .habit-actions_btn_s:active {
  transform: translateY(-1px);
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
}
</style>
