@extends('layouts.app')

@section('title', $category->name . ' - Tilda Recipes')
@section('page-title', $category->name)

@section('page-actions')
    <div class="btn-group">
        <a href="{{ route('categories.edit', $category->categoryId) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>
            Modifier
        </a>
        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Retour à la liste
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                @if($category->imageUrl)
                    <img src="{{ $category->imageUrl }}" 
                         alt="{{ $category->name }}" 
                         class="img-fluid rounded mb-3" 
                         style="max-height: 200px; object-fit: cover;"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                @endif
                
                <div class="d-none" id="noImage">
                    <div class="bg-light rounded d-flex align-items-center justify-content-center mb-3" style="height: 200px;">
                        <i class="fas fa-tag fa-3x text-muted"></i>
                    </div>
                </div>
                
                <h4 class="card-title">{{ $category->name }}</h4>
                
                <div class="row text-center mt-3">
                    <div class="col-6">
                        <div class="border-end">
                            <h5 class="text-primary mb-1">{{ $category->recipes()->count() }}</h5>
                            <small class="text-muted">Recettes</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h5 class="text-success mb-1">{{ $category->created_at->diffForHumans() }}</h5>
                        <small class="text-muted">Créée</small>
                    </div>
                </div>
            </div>
            
            <div class="card-footer">
                <div class="d-grid gap-2">
                    <a href="{{ route('categories.edit', $category->categoryId) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Modifier la catégorie
                    </a>
                    <button type="button" 
                            class="btn btn-danger"
                            onclick="confirmDelete('{{ $category->categoryId }}', '{{ $category->name }}')">
                        <i class="fas fa-trash me-2"></i>
                        Supprimer
                    </button>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informations
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>ID de la catégorie :</strong><br>
                    <code class="small">{{ $category->categoryId }}</code>
                </div>
                
                <div class="mb-3">
                    <strong>Nom :</strong><br>
                    <span>{{ $category->name }}</span>
                </div>
                
                <div class="mb-3">
                    <strong>Image URL :</strong><br>
                    @if($category->imageUrl)
                        <a href="{{ $category->imageUrl }}" target="_blank" class="small text-break">
                            {{ $category->imageUrl }}
                        </a>
                    @else
                        <span class="text-muted">Aucune image</span>
                    @endif
                </div>
                
                <div class="mb-3">
                    <strong>Créée le :</strong><br>
                    <small class="text-muted">{{ $category->created_at->format('d/m/Y à H:i') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Dernière modification :</strong><br>
                    <small class="text-muted">{{ $category->updated_at->format('d/m/Y à H:i') }}</small>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-book me-2"></i>
                    Recettes de cette catégorie ({{ $recipes->total() }})
                </h5>
            </div>
            
            <div class="card-body p-0">
                @if($recipes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Titre</th>
                                    <th>Chef</th>
                                    <th>Durée</th>
                                    <th>Likes</th>
                                    <th>Créée le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recipes as $recipe)
                                    <tr>
                                        <td>
                                            @if($recipe->imageUrl)
                                                <img src="{{ $recipe->imageUrl }}" 
                                                     alt="{{ $recipe->title }}" 
                                                     class="category-image"
                                                     onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAiIGhlaWdodD0iNTAiIHZpZXdCb3g9IjAgMCA1MCA1MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjUwIiBoZWlnaHQ9IjUwIiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik0yNSAyNUMzMi43MjkzIDI1IDM5IDMxLjI3MDcgMzkgMzlDMzkgNDYuNzI5MyAzMi43MjkzIDUzIDI1IDUzQzE3LjI3MDcgNTMgMTEgNDYuNzI5MyAxMSAzOUMxMSAzMS4yNzA3IDE3LjI3MDcgMjUgMjUgMjVaIiBmaWxsPSIjOUNBM0FGIi8+CjxwYXRoIGQ9Ik0yNSAzMkMyNy4yMDkxIDMyIDI5IDMzLjc5MDkgMjkgMzZDMjkgMzguMjA5MSAyNy4yMDkxIDQwIDI1IDQwQzIyLjc5MDkgNDAgMjEgMzguMjA5MSAyMSAzNkMyMSAzMy43OTA5IDIyLjc5MDkgMzIgMjUgMzJaIiBmaWxsPSJ3aGl0ZSIvPgo8L3N2Zz4K'">
                                            @else
                                                <div class="category-image bg-light d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-utensils text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $recipe->title }}</strong>
                                        </td>
                                        <td>
                                            @if($recipe->chef)
                                                {{ $recipe->chef->name }}
                                            @else
                                                <span class="text-muted">Inconnu</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $recipe->duration }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-heart me-1"></i>
                                                {{ $recipe->likesCount }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $recipe->created_at->format('d/m/Y') }}
                                            </small>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($recipes->hasPages())
                        <div class="card-footer">
                            {{ $recipes->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucune recette dans cette catégorie</h5>
                        <p class="text-muted">Les recettes apparaîtront ici une fois créées.</p>
                    </div>
                @endif
            </div>
        </div>
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
