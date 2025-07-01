<template>
  <button
    class="icon-button"
    :disabled="disabled || status === -1 || loading"
    @click="toggle"
  >
    <img :src="iconSrc" alt="status icon" />
  </button>
</template>

<script setup>
import { computed, ref } from 'vue'
import api from '@/api/api'

const props = defineProps({
  status: {
    type: Number,
    required: true
  },
  habitId: {
    type: Number,
    required: true
  },
  date: {
    type: String, // формат YYYY-MM-DD
    required: true
  },
  token: {
    type: String,
    required: true
  },
  disabled: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['updated'])

const loading = ref(false)

async function toggle() {
  if (props.status === -1 || loading.value) return

  const newStatus = props.status === 1 ? 0 : 1

    await api.updateHabit(props.habitId, {
    status: newStatus,
    date: props.date
  }, props.token)

}

const iconSrc = computed(() => {
  const suffix = '1'
  switch (props.status) {
    case 1: return `/icons/happy${suffix}.png`
    case 0: return `/icons/neutral${suffix}.png`
    case 2: return `/icons/sad${suffix}.png`
    case -1: return `/icons/inactive${suffix}.png`
    default: return `/icons/neutral${suffix}.png`
  }
})
</script>

<style scoped>
.icon-button {
  background: none;
  border: none;
  padding: 4px;
  border-radius: 50%;
  cursor: pointer;
  width: 100px;
  height: 100px;
  transition: all 0.3s ease;
}

.icon-button:active {
  transform: rotate(10deg);
}

.icon-button:disabled {
  opacity: 0.5;
  cursor: default;
  box-shadow: none;
}

.icon-button img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}
</style>
