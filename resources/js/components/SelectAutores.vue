<template>
  <div>
    <label for="autor" class="block text-sm font-medium text-gray-700">Autor</label>
    <select 
      id="autor" 
      v-model="autorSelecionado"
      class="mt-1 block w-full rounded-md border border-gray-700 text-gray-700 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
      required>
      <option value="" disabled>Selecione...</option>
      <option v-for="autor in autores" :key="autor.id" :value="autor.id">
        {{ autor.nome }}
      </option>
    </select>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: {
    modelValue: [String, Number], // Para Vue 3
  },
  data() {
    return {
      autores: [],
      autorSelecionado: this.modelValue || '', 
    };
  },
  watch: {
    modelValue(newValue) {
      this.autorSelecionado = newValue;
    },
    autorSelecionado(newValue) {
      this.$emit('update:modelValue', newValue);
    },
  },
  mounted() {
    this.buscarAutores();
  },
  methods: {
    async buscarAutores() {
      try {
        const response = await axios.get('api/autores');
        this.autores = response.data;
        
        if (this.modelValue && !this.autorSelecionado) {
          this.autorSelecionado = this.modelValue;
        }
      } catch (error) {
        console.error('Erro ao buscar autores:', error);
      }
    },
  },
};
</script>
