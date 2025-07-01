<template>
  <div class="habit-row">
    <div class="habit-name-cell">
      <span :title="habit.description || ''">{{ habit.name }}</span>
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

const props = defineProps({
  habit: Object,
  weekDates: Array,
  token: String 
})


const emit = defineEmits(['update', 'delete'])

const isModalOpen = ref(false)

function confirmDelete() {
  if (confirm(`Вы уверены, что хотите удалить привычку "${props.habit.name}"?`)) {
    emit('delete', props.habit.id)
  }
}

function formatDate(date) {
  return date.toISOString().split('T')[0]
}

function isActiveDay(date) {
  const dayOfWeek = date.getDay()
  return props.habit.days.includes(dayOfWeek)
}

function isPast(date) {
  const today = new Date()
  return date < new Date(today.getFullYear(), today.getMonth(), today.getDate())
}

function getStatus(date) {
  if (!isActiveDay(date)) return -1

  const key = formatDate(date)
  const log = props.habit.logs[key]

  const createdAt = new Date(props.habit.createdAt)
  const currentDay = new Date(date.getFullYear(), date.getMonth(), date.getDate())

  if (currentDay < createdAt) return -1

  if (log === 1) return 1
  if (log === 0) return 0
  if (log === undefined && isPast(date)) return 2
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

function updateStatus(date, newStatus) {
  if (!canChangeStatus(date)) return
  const key = formatDate(date)
  props.habit.logs[key] = newStatus
}

function saveEdit(updatedHabit) {
  emit('update', {
    ...props.habit,
    name: updatedHabit.name,
    description: updatedHabit.description,
    days: [...updatedHabit.days].sort()
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


.habit-actions_btn_f,.habit-actions_btn_s{
  border: none;
  padding: 3px 11px;
  border-radius: 6px;
}

.habit-actions_btn_f:link,
.habit-actions_btn_f:visited,
.habit-actions_btn_s:link,
.habit-actions_btn_s:visited{
    text-transform: uppercase;
    text-decoration: none;
    padding: 15px 40px;
    display: inline-block;
    border-radius: 100px;
    transition: all .2s;
    position: absolute;
}

.habit-actions_btn_f:hover, .habit-actions_btn_s:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.habit-actions_btn_f:active,.habit-actions_btn_s:active {
    transform: translateY(-1px);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
}
</style>
