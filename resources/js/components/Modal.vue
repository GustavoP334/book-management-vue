<template>
  <transition name="fade">
    <div v-if="isOpen" class="fixed inset-0 flex items-center justify-center bg-sky-500/50 z-50 p-4">
      <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg sm:max-w-2xl p-6 relative animate-fadeIn overflow-hidden max-h-[90vh] flex flex-col">
        <button 
          class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 transition duration-300" 
          @click="$emit('close')"
        >
          &times;
        </button>
        <div class="overflow-y-auto flex-1 p-2">
          <slot></slot>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    isOpen: Boolean,
  },
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

.animate-fadeIn {
  animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
  from { opacity: 0; transform: scale(0.95); }
  to { opacity: 1; transform: scale(1); }
}
</style>
