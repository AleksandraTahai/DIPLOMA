<template>
  <div class="modal-overlay" @click.self="close">
    <div class="modal">
      <h2>Редактировать привычку</h2>
      <input
        v-model="name"
        placeholder="Название привычки"
        class="input"
      />
      <textarea
        v-model="description"
        placeholder="Описание (необязательно)"
        class="textarea"
      />
      <div class="days">
        <label v-for="(day, index) in weekdays" :key="index">
          <input type="checkbox" :value="index" v-model="days" />
          {{ day }}
        </label>
      </div>
      <div class="actions">
        <button @click="save">💾 Сохранить</button>
        <button @click="close">❌ Отмена</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '@/api/api' 
import { useAuthStore } from '@/stores/auth' 
import { storeToRefs } from 'pinia'

const props = defineProps({
  initialHabit: Object
})
const emit = defineEmits(['updated', 'close'])

const name = ref(props.initialHabit.name)
const description = ref(props.initialHabit.description || '')
const days = ref([...props.initialHabit.days])
const weekdays = ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']

const authStore = useAuthStore()
const { token } = storeToRefs(authStore)

async function save() {
  if (!name.value.trim()) return

  const updatedHabit = {
    name: name.value.trim(),
    description: description.value.trim(),
    days: [...days.value]
  }

  try {
    await api.updateHabit(props.initialHabit.id, updatedHabit, token.value)
    emit('updated', updatedHabit) // можно также передать ID, если нужно
    close()
  } catch (err) {
    console.error('Ошибка при обновлении привычки:', err)
    alert('Не удалось обновить привычку.')
  }
}

function close() {
  emit('close')
}
</script>


<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1;
}

.modal {
  background: white;
  border-radius: 8px;
  padding: 2rem;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

.modal h2 {
  margin-bottom: 1rem;
  font-size: 18px;
  text-align: center;
}

.input,
.textarea {
  width: 100%;
  margin-bottom: 0.75rem;
  padding: 6px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.textarea {
  resize: vertical;
  min-height: 60px;
}

.days {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  font-size: 13px;
  margin-bottom: 1rem;
}

.actions {
  display: flex;
  justify-content: space-between;
}

button{
  border: none;
  padding: 3px 11px;
  border-radius: 6px;
}

button:link,
button:visited{
    text-transform: uppercase;
    text-decoration: none;
    padding: 15px 40px;
    display: inline-block;
    border-radius: 100px;
    transition: all .2s;
    position: absolute;
}

button:hover, button:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

button:active{
    transform: translateY(-1px);
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
}
</style>
