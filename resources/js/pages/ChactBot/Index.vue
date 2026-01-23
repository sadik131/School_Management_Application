<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import { dashboard } from '@/routes'
import { Head } from '@inertiajs/vue3'
import { ref, nextTick } from 'vue'

const breadcrumbs = [
  {
    title: 'Ask To AI',
    href: dashboard().url,
  },
]

// Chat state
const messages = ref([
  {
    from: 'ai',
    text: 'Hi 👋 I am your AI Assistant. How can I help you today?',
  },
])

const newMessage = ref('')
const chatBox = ref(null)

// Send message
const sendMessage = async () => {
  if (!newMessage.value.trim()) return

  // User message
  messages.value.push({
    from: 'user',
    text: newMessage.value,
  })

  const userText = newMessage.value
  newMessage.value = ''

  await nextTick()
  chatBox.value.scrollTop = chatBox.value.scrollHeight

  // Dummy AI response
  setTimeout(async () => {
    messages.value.push({
      from: 'ai',
      text: `🤖 AI Response: I received your message — "${userText}". This is a dummy reply for now.`,
    })

    await nextTick()
    chatBox.value.scrollTop = chatBox.value.scrollHeight
  }, 600)
}
</script>

<template>
  <Head title="Ask To AI" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="max-w-4xl mt-4 w-full mx-auto">

      <!-- Chat Container -->
      <div class="bg-white rounded-2xl shadow-xl flex flex-col h-[75vh]">

        <!-- Header -->
        <div class="px-6 py-4 border-b bg-gray-50 rounded-t-2xl">
          <h2 class="text-lg font-semibold text-gray-800">
            🤖 AI Assistant
          </h2>
          <p class="text-xs text-gray-500">
            Ask anything related to school, assignments, or system usage
          </p>
        </div>

        <!-- Messages -->
        <div
          ref="chatBox"
          class="flex-1 overflow-y-auto px-6 py-4 space-y-4 bg-gray-100"
        >
          <div
            v-for="(msg, index) in messages"
            :key="index"
            class="flex"
            :class="msg.from === 'user' ? 'justify-end' : 'justify-start'"
          >
            <div
              class="max-w-[70%] px-4 py-2 rounded-2xl text-sm shadow"
              :class="msg.from === 'user'
                ? 'bg-indigo-600 text-white rounded-br-none'
                : 'bg-white text-gray-800 rounded-bl-none'"
            >
              {{ msg.text }}
            </div>
          </div>
        </div>

        <!-- Input -->
        <div class="px-6 py-4 border-t bg-white rounded-b-2xl">
          <form @submit.prevent="sendMessage" class="flex gap-3">
            <input
              v-model="newMessage"
              type="text"
              placeholder="Type your question..."
              class="flex-1 rounded-lg border border-gray-300 px-4 py-2 text-sm
                     focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500"
            />
            <button
              type="submit"
              class="px-5 py-2 bg-indigo-600 text-white text-sm rounded-lg
                     hover:bg-indigo-700 transition"
            >
              Send
            </button>
          </form>
        </div>

      </div>

    </div>
  </AppLayout>
</template>
