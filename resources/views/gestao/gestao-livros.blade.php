@extends('app')

@section('title', 'Gestão de Livros')

@section('imports')
    <script src="{{ asset('js/gestao-livros.js') }}"></script>
@endsection

@section('content')
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#livro">
        Adicionar Livro
    </button>

    @component('layouts.modal', ['id' => 'livro', 'title' => 'Registrar Livros'])
        <form method="POST" action="{{ route('registra-livros') }}" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" name="title" id="title" placeholder="Título" maxlength="191" required>
                    <label for="title">Título</label>
                </div>
                <div class="form-floating mb-2">
                    <textarea class="form-control" placeholder="Descrição" name="descricao" id="descricao" maxlength="191" required></textarea>
                    <label for="descricao">Descrição</label>
                </div>
                <select class="form-select mb-2" name="autor" aria-label="Default select example" required>
                    <option selected disabled>Selecione...</option>
                    @foreach ($autores as $autor)
                        <option value="{{ $autor->id }}">{{ $autor->nome }}</option>"
                    @endforeach
                </select>
                <div class="form-floating mb-2">
                    <input type="date" class="form-control" name="data_publicacao" id="data_publicacao" placeholder="Data" max="{{ date('Y-m-d') }}" required>
                    <label for="data_publicacao">Data publicação</label>
                </div>
                <div class="input-group mb-4">
                    <input type="file" class="form-control" name="capa" accept="image/png, image/jpeg" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </form>
    @endcomponent
    
    @component('layouts.modal', ['id' => 'edita-livro', 'title' => 'Editar Livros'])
        <form method="POST" action="{{ route('editar-livro') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <input type="hidden" class="form-control" id="id" name="id" required>
                <div class="d-flex justify-content-center mb-2">
                    <img src="{{ route('imagem.show', ['idAutor' => 0, 'idLivro' => 0]) }}" style="object-fit: fill; width: 200px; height: 200px;" id="imgCapa" alt="Imagem">
                </div>
                <div class="form-floating mb-2">
                    <input type="text" class="form-control" name="title" id="title" placeholder="Título" maxlength="191" required>
                    <label for="title">Título</label>
                </div>
                <div class="form-floating mb-2">
                    <textarea class="form-control" placeholder="Descrição" name="descricao" id="descricao" maxlength="191" required></textarea>
                    <label for="descricao">Descrição</label>
                </div>
                <select class="form-select mb-2" id="autor" name="autor" aria-label="Default select example" required>
                    <option selected disabled>Selecione...</option>
                    @foreach ($autores as $autor)
                        <option value="{{ $autor->id }}">{{ $autor->nome }}</option>"
                    @endforeach
                </select>
                <div class="form-floating mb-2">
                    <input type="date" class="form-control" name="data_publicacao" id="data_publicacao" placeholder="Data" max="{{ date('Y-m-d') }}" required>
                    <label for="data_publicacao">Data publicação</label>
                </div>
                <div class="input-group mb-4">
                    <input type="file" class="form-control" name="capa" accept="image/png, image/jpeg" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </form>
    @endcomponent

    <table class="table table-dark table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Descrição</th>
                <th>Autor</th>
                <th>Data publicação</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($livros as $livro)
                <tr>
                    <td>{{ $livro->titulo }}</td>
                    <td>{{ $livro->descricao }}</td>
                    <td>{{ $livro->autor->nome }}</td>
                    <td>{{ date('d/m/Y', strtotime($livro->data_publicacao)) }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edita-livro" 
                            data-bs-values="{{ json_encode($livro) }}">
                                Editar
                            </button>
                            <form action="{{ route('deleta-livro', ['id' => $livro->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </div>
                    </td>    
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $livros->links() }}
    </div>
@endsection