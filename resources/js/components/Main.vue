<template>
  <div class="flex flex-col items-start justify-center min-h-screen p-4">
    <button
      @click="modalOpen = true"
      class="p-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition duration-300"
    >
      Adicionar Livro
    </button>

    <Modal :isOpen="modalOpen" @close="esvaziaModal">
      <h2 class="text-xl font-bold text-gray-700">Adicionar Livro</h2>
      <form @submit.prevent="registrarLivros">
        <div class="p-6">
          <input type="hidden" v-model="id">
          <img :src="`/imagem/${this.autorSelecionado}/${this.id}`"  class="mx-auto my-4 w-48 h-48 object-cover" alt="Capa do livro" v-if="this.id !== null" />
          <div class="mb-4">
              <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
              <input type="text" v-model="title" id="title" maxlength="191" required
                  class="mt-1 block w-full rounded-md border border-gray-700 text-gray-700 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          </div>
          <div class="mb-4">
              <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
              <textarea v-model="descricao" id="descricao" maxlength="191" required
                  class="mt-1 block w-full rounded-md border border-gray-700 text-gray-700 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
          </div>
          <div class="mb-4">
            <SelectAutores v-model="autorSelecionado" />
          </div>
          <div class="mb-4">
              <label for="data_publicacao" class="block text-sm font-medium text-gray-700">Data publicação</label>
              <input type="date" v-model="data_publicacao" id="data_publicacao" max="" required
                  class="mt-1 block w-full rounded-md border border-gray-700 text-gray-700 bg-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          </div>
          <div class="mb-4">
              <label for="capa" class="block text-sm font-medium text-gray-700">Capa</label>
              <input type="file" @change="handleFileUpload" id="capa" accept="image/png, image/jpeg"
                  class="mt-1 block w-full border border-gray-700 text-gray-700 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
          </div>
        </div>
        <div class="flex justify-end space-x-2 p-4 border-t">
            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 cursor-pointer">
                Salvar
            </button>
        </div>
      </form>
    </Modal>
    <Table @editar-livro="editarLivro" />
  </div>
</template>

<script>
import Modal from "./Modal.vue";
import SelectAutores from "./SelectAutores.vue";
import Table from "./Table.vue";
import axios from 'axios';

export default {
  components: {
    Modal,
    SelectAutores,
    Table,
  },
  data() {
    return {
      modalOpen: false,
      id: null,
      title: '',
      descricao: '',
      autorSelecionado: this.value || '',
      data_publicacao: '',
      capaFile: null,
      imgCapa: null,
    };
  },
  methods: {
    handleFileUpload(event) {
      this.capaFile = event.target.files[0];
    },
    async registrarLivros() {
      const formData = new FormData();
      formData.append('id', this.id);
      formData.append('title', this.title);
      formData.append('descricao', this.descricao);
      formData.append('autor', this.autorSelecionado);
      formData.append('data_publicacao', this.data_publicacao);
      formData.append('capa', this.capaFile);

      console.log(formData);
      
      axios.post('/api/registra-livros', formData, {
        headers: {
          'Content-Type':'multipart/form-data'
        }
      })
        .then(response => {
          console.log('Dados salvos com sucesso:', response.data);
          esvaziaModal()
        })
        .catch(error => {
          console.error('Erro ao salvar dados:', error);
      });
    },
    editarLivro(livro) {
      this.id = livro.id;
      this.title = livro.titulo;
      this.descricao = livro.descricao;
      this.data_publicacao = livro.data_publicacao;

      this.modalOpen = true;
      this.$nextTick(() => {
        this.autorSelecionado = livro.autor_id;
      });
    },
    esvaziaModal() {
      this.modalOpen = false;

      this.id = null;
      this.title = '';
      this.descricao = '';
      this.autorSelecionado = null;
      this.data_publicacao = '';
      this.capaFile = null;
    }
  }
};
</script>