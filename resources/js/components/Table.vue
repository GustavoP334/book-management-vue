<template>
    <div>
        <table class="min-w-full table-auto border-collapse text-sm text-gray-800">
            <thead>
                <tr class="bg-gray-200 border-b">
                <th class="px-4 py-2 text-left">Título</th>
                <th class="px-4 py-2 text-left">Descrição</th>
                <th class="px-4 py-2 text-left">Autor</th>
                <th class="px-4 py-2 text-left">Data publicação</th>
                <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="livro in livros" :key="livro.id" class="border-b bg-gray-50 hover:bg-gray-100">
                <td class="px-4 py-2">{{ livro.titulo }}</td>
                <td class="px-4 py-2">{{ livro.descricao }}</td>
                <td class="px-4 py-2">{{ livro.autor.nome }}</td>
                <td class="px-4 py-2">{{ formatDate(livro.data_publicacao) }}</td>
                <td class="px-4 py-2">
                    <div class="flex gap-2">
                        <button type="button" class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300 cursor-pointer"
                        @click="editarLivro(livro)">
                            Editar
                        </button>
                        <button @click="deletarLivro(livro.id)" type="button" class="px-4 py-2 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 transition duration-300 cursor-pointer">
                            Excluir
                        </button>
                    </div>
                </td>
                </tr>
            </tbody>
        </table>
        <div class="flex items-center justify-center space-x-4">
            <button
                type="button" 
                class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300 cursor-pointer"
                :class="{'opacity-50 cursor-not-allowed': this.currentPage <= 1}" 
                @click="changePage(this.currentPage - 1)" :disabled="this.currentPage <= 1">
                Anterior
            </button>
            <button
                type="button" 
                class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition duration-300 cursor-pointer"
                :class="{'opacity-50 cursor-not-allowed': this.currentPage >= this.lastPage}" 
                @click="changePage(this.currentPage + 1)" :disabled="this.currentPage >= this.lastPage">
                Próximo
            </button>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: {
            livro: Object
        },
        data() {
            return {
                livros: [],
                currentPage: 0,
                lastPage: 0
            };
        },
        mounted() {
            this.buscarLivros();
        },
        methods: {
            async buscarLivros(page = 1) {
                const response = await axios.get(`/api/get-livros?page=${page}`);
                
                this.livros = response.data.data;
                this.currentPage = response.data.current_page;
                this.lastPage = response.data.last_page;
            },
            changePage(page) {
                if (page > 0 && page <= this.lastPage) {
                    this.buscarLivros(page);
                }
            },
            async deletarLivro(id) {
                await axios.delete(`/api/deleta-livro/${id}`);
                this.buscarLivros();
            },
            formatDate(date) {
                const d = new Date(date);
                return d.toLocaleDateString('pt-BR');
            },
            editarLivro(livro) {
                this.$emit('editar-livro', livro);
            }
        }
    };
</script>