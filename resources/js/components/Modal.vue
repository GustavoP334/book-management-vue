<template>
    <div v-if="isOpen" class="modal-overlay fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="modal bg-white rounded-lg shadow-lg w-11/12 sm:w-1/3 p-6 relative">
        <button class="absolute top-0 right-0 p-2 text-gray-600 close-btn" @click="$emit('close')">X</button>
        <div class="modal-content">
          <slot></slot>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      isOpen: Boolean,
    },
  };
  </script>
  
<style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  
  .modal {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 300px;
    position: relative;
  }
  
  .close-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    background: red;
    color: white;
    border: none;
    padding: 5px;
    cursor: pointer;
  }
  </style>
  