@extends('layouts.app')

@section('title', 'Gestion des Catégories - Tilda Recipes')
@section('page-title', 'Gestion des Catégories')

@section('page-actions')
    <a href="{{ route('categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Nouvelle Catégorie
    </a>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-tags me-2"></i>
            Liste des Catégories ({{ $categories->total() }})
        </h5>
    </div>
    
    <div class="card-body p-0">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Nom</th>
                            <th>ID</th>
                            <th>Recettes</th>
                            <th>Créée le</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td>
                                    @if($category->imageUrl)
                                        <img src="{{ $category->imageUrl }}" alt="{{ $category->name }}" 
                                             class="category-image" 
                                             onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAiIGhlaWdodD0iNTAiIHZpZXdCb3g9IjAgMCA1MCA1MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjUwIiBoZWlnaHQ9IjUwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yNSAyNUMzMi43MjkzIDI1IDM5IDMxLjI3MDcgMzkgMzlDMzkgNDYuNzI5MyAzMi43MjkzIDUzIDI1IDUzQzE3LjI3MDcgNTMgMTEgNDYuNzI5MyAxMSAzOUMxMSAzMS4yNzA3IDE3LjI3MDcgMjUgMjUgMjVaIiBmaWxsPSIjOUNBM0FGIi8+CjxwYXRoIGQ9Ik0yNSAzMkMyNy4yMDkxIDMyIDI5IDMzLjc5MDkgMjkgMzZDMjkgMzguMjA5MSAyNy4yMDkxIDQwIDI1IDQwQzIyLjc5MDkgNDAgMjEgMzguMjA5MSAyMSAzNkMyMSAzMy43OTA5IDIyLjc5MDkgMzIgMjUgMzJaIiBmaWxsPSJ3aGl0ZSIvPgo8L3N2Zz4K'">
                                    @else
                                        <div class="category-image bg-light d-flex align-items-center justify-content-center">
                                            <i class="fas fa-tag text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                </td>
                                <td>
                                    <code class="small">{{ $category->categoryId }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $category->recipes()->count() }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $category->created_at->format('d/m/Y H:i') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('categories.show', $category->categoryId) }}" 
                                           class="btn btn-outline-info" 
                                           title="Voir les détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('categories.edit', $category->categoryId) }}" 
                                           class="btn btn-outline-warning" 
                                           title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-danger" 
                                                title="Supprimer"
                                                onclick="confirmDelete('{{ $category->categoryId }}', '{{ $category->name }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($categories->hasPages())
                <div class="card-footer">
                    {{ $categories->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune catégorie trouvée</h5>
                <p class="text-muted">Commencez par créer votre première catégorie.</p>
                <a href="{{ route('categories.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Créer une catégorie
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Confirmer la suppression
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer la catégorie <strong id="categoryName"></strong> ?</p>
                <p class="text-muted small">Cette action est irréversible.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>
                        Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete(categoryId, categoryName) {
    document.getElementById('categoryName').textContent = categoryName;
    document.getElementById('deleteForm').action = `/categories/${categoryId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}
</script>
@endsection
