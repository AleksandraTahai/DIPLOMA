<template>
  <div>
    <div class="calendar_nav">
      <div class="arrow_left" @click="prevWeek"><div></div></div>
      <p class="dates">{{ formatDate(startOfWeek) }} - {{ formatDate(endOfWeek) }}</p>
      <div class="arrow_right" @click="nextWeek"><div></div></div>
    </div>

    <div class="habit_list">
      <div class="habit_header">
        <div class="habit-name-header">Привычка</div>
        <div class="habit-days-header">
          <div v-for="date in weekDates" :key="date.toDateString()" class="day-cell">
            <div>{{ date.toLocaleDateString('ru-RU', { weekday: 'short' }) }}</div>
            <small>{{ date.getDate() }}.{{ date.getMonth() + 1 }}</small>
          </div>
        </div>
      </div>

      <HabitRow
          v-for="habit in habits"
          :key="habit.id"
          :habit="habit"
          :weekDates="weekDates"
          :token="token"
          @delete="deleteHabit(habit.id)"
          @update="updateHabit"
      />

      <HabitForm @created="addHabit" />
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { storeToRefs } from 'pinia'
import api from '@/api/api'

import HabitRow from './HabitRow.vue'
import HabitForm from './HabitForm.vue'

const auth = useAuthStore()
const { token } = storeToRefs(auth)

const today = new Date()
const currentStart = ref(getStartOfWeek(today))
const habits = ref([])

function getStartOfWeek(date) {
  const d = new Date(date)
  const diff = d.getDate() - d.getDay()
  return new Date(d.setDate(diff))
}

const startOfWeek = computed(() => currentStart.value)

const endOfWeek = computed(() => {
  const d = new Date(startOfWeek.value)
  return new Date(d.setDate(d.getDate() + 6))
})

const weekDates = computed(() => {
  const dates = []
  for (let i = 0; i < 7; i++) {
    const d = new Date(startOfWeek.value)
    d.setDate(d.getDate() + i)
    dates.push(d)
  }
  return dates
})

function nextWeek() {
  const d = new Date(startOfWeek.value)
  d.setDate(d.getDate() + 7)
  currentStart.value = d
}

function prevWeek() {
  const d = new Date(startOfWeek.value)
  d.setDate(d.getDate() - 7)
  currentStart.value = d
}

async function fetchHabits() {
  try {
    const response = await api.getHabits(token.value)
    habits.value = response.data
  } catch (error) {
    console.error('Ошибка загрузки привычек:', error)
  }
}

function formatDate(date) {
  return date.toLocaleDateString('ru-RU')
}

function addHabit(newHabit) {
  habits.value.push(newHabit)
}

async function deleteHabit(habitId) {
  try {
    await api.deleteHabit(habitId, auth.token)
    habits.value = habits.value.filter(habit => habit.id !== habitId)
  } catch (error) {
    console.error('Ошибка удаления:', error)
    alert('Не удалось удалить привычку.')
  }
}


async function updateHabit(updated) {
  try {
    await api.updateHabit(updated.id, {
      title: updated.title,
      description: updated.description,
      days: updated.days.map(d => d.id || d)
    }, auth.token)

    const index = habits.value.findIndex(h => h.id === updated.id)
    if (index !== -1) habits.value[index] = updated
  } catch (error) {
    console.error('Ошибка обновления:', error)
    alert('Не удалось обновить привычку.')
  }
}

onMounted(fetchHabits)
</script>


<style scoped>

.calendar_nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}
.dates{
  font-size: 25px;
  font-weight: 800;
  color: #2a6d92;
}
.habit_list {
  background-color: #ffffffba;
  border-radius: 6px;
  overflow: hidden;
}
.habit_header {
  display: flex;
  background: #3ca2d954;
  font-weight: bold;
}
.habit-name-header {
  width: 200px;
  padding: 0.5rem;
}
.habit-days-header,
.habit-days-header {
  display: grid;
  grid-template-columns: repeat(7, 1fr); 
  flex: 1;
}
.day-cell,
.icon-cell {
  text-align: center;
  padding: 4px;
}
.arrow_right, .arrow_left {
    cursor: pointer;
    position: relative;
    width: 80px;
    height: 50px;
    margin: 20px;
}
.arrow_right div, .arrow_left div {
    position: relative;
    top: 31px;
    width: 42px;
    height: 5px;
    background-color: #337AB7;
    box-shadow: 0 3px 5px rgba(0, 0, 0, .2);
    left:0;
    display: block;
}
.arrow_right div::after, .arrow_left div::after  {
    content: '';
    position: absolute;
    width: 25px;
    height: 5px;
    top: -7px;
    right: -7px;
    background-color: #337AB7;
    transform: rotate(45deg);
}
.arrow_left div::after{
    top: -7px;
    left: -7px;
    background-color: #337AB7;
    transform: rotate(-45deg);
}
.arrow_right div::before,.arrow_left div::before{
    content: '';
    position: absolute;
    width: 25px;
    height: 5px;
    top: 7px;
    right: -7px;
    background-color: #337AB7;
    box-shadow: 0 3px 5px rgba(0, 0, 0, .2);
    transform: rotate(-45deg);
}
.arrow_left div::before{
    transform: rotate(45deg);
    top: 7px;
    left: -7px;
}
.arrow_right:hover,.arrow_left:hover {
    animation: arrows 1s linear infinite;
}
@keyframes arrows {
    0% {
        left:0;
    }
    50% {
        left:9px;
    }
    100% {
        left:0;
    }
}
</style>
