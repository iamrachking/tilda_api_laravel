@extends('layouts.app')

@section('title', 'Nouvelle Catégorie - Tilda Recipes')
@section('page-title', 'Nouvelle Catégorie')

@section('page-actions')
    <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Retour à la liste
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus me-2"></i>
                    Créer une nouvelle catégorie
                </h5>
            </div>
            
            <div class="card-body">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="fas fa-tag me-1"></i>
                            Nom de la catégorie <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="Ex: Desserts, Entrées, Plats principaux..."
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-image me-1"></i>
                            Image de la catégorie
                        </label>
                        
                        <!-- Zone de drop pour l'upload -->
                        <div class="upload-zone border-2 border-dashed rounded p-4 text-center" 
                             id="uploadZone" 
                             style="border-color: #dee2e6; min-height: 120px;">
                            <div id="uploadPlaceholder">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="text-muted mb-2">Glissez-déposez votre image ici ou cliquez pour sélectionner</p>
                                <small class="text-muted">Formats acceptés: JPG, PNG, GIF, WebP (max 2MB)</small>
                            </div>
                            
                            <input type="file" 
                                   id="imageFile" 
                                   name="image" 
                                   accept="image/*" 
                                   class="d-none">
                        </div>
                        
                        <!-- Champ caché pour l'URL -->
                        <input type="hidden" id="imageUrl" name="imageUrl" value="{{ old('imageUrl') }}">
                        
                        @error('imageUrl')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Aperçu de l'image -->
                    <div class="mb-3" id="imagePreview" style="display: none;">
                        <label class="form-label">Aperçu de l'image :</label>
                        <div class="border rounded p-3 text-center position-relative">
                            <img id="previewImg" src="" alt="Aperçu" class="img-thumbnail" style="max-width: 200px;">
                            <button type="button" class="btn btn-sm btn-outline-danger position-absolute top-0 end-0 m-2" 
                                    id="removeImage" title="Supprimer l'image">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Zone de chargement -->
                    <div class="mb-3" id="uploadProgress" style="display: none;">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                 role="progressbar" style="width: 0%"></div>
                        </div>
                        <small class="text-muted">Upload en cours...</small>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Créer la catégorie
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informations
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fas fa-lightbulb me-2"></i>
                    <strong>Conseil :</strong> Choisissez un nom clair et descriptif pour votre catégorie.
                </div>
                
                <h6>Exemples de catégories :</h6>
                <ul class="list-unstyled">
                    <li><i class="fas fa-check text-success me-2"></i>Entrées</li>
                    <li><i class="fas fa-check text-success me-2"></i>Plats principaux</li>
                    <li><i class="fas fa-check text-success me-2"></i>Desserts</li>
                    <li><i class="fas fa-check text-success me-2"></i>Boissons</li>
                    <li><i class="fas fa-check text-success me-2"></i>Végétarien</li>
                    <li><i class="fas fa-check text-success me-2"></i>Végan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadZone = document.getElementById('uploadZone');
    const imageFile = document.getElementById('imageFile');
    const imageUrl = document.getElementById('imageUrl');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const uploadProgress = document.getElementById('uploadProgress');
    const removeImage = document.getElementById('removeImage');

    // Gestion du clic sur la zone d'upload
    uploadZone.addEventListener('click', function() {
        imageFile.click();
    });

    // Gestion du drag & drop
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadZone.style.borderColor = '#007bff';
        uploadZone.style.backgroundColor = '#f8f9fa';
    });

    uploadZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        uploadZone.style.borderColor = '#dee2e6';
        uploadZone.style.backgroundColor = '';
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadZone.style.borderColor = '#dee2e6';
        uploadZone.style.backgroundColor = '';
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileUpload(files[0]);
        }
    });

    // Gestion de la sélection de fichier
    imageFile.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            handleFileUpload(e.target.files[0]);
        }
    });

    // Fonction pour gérer l'upload
    function handleFileUpload(file) {
        // Validation du fichier
        if (!file.type.startsWith('image/')) {
            alert('Veuillez sélectionner un fichier image.');
            return;
        }

        if (file.size > 2 * 1024 * 1024) { // 2MB
            alert('Le fichier est trop volumineux. Taille maximale: 2MB');
            return;
        }

        // Afficher le progress
        uploadProgress.style.display = 'block';
        uploadPlaceholder.style.display = 'none';

        // Créer FormData
        const formData = new FormData();
        formData.append('image', file);

        // Upload via AJAX
        fetch('{{ route("upload.category-image") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            uploadProgress.style.display = 'none';
            
            if (data.success) {
                // Mettre à jour l'URL de l'image
                imageUrl.value = data.url;
                
                // Afficher l'aperçu
                previewImg.src = data.url;
                imagePreview.style.display = 'block';
                
                // Mettre à jour le placeholder
                uploadPlaceholder.innerHTML = `
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <p class="text-success mb-2">Image uploadée avec succès !</p>
                    <small class="text-muted">Cliquez pour changer d'image</small>
                `;
                uploadPlaceholder.style.display = 'block';
            } else {
                alert('Erreur lors de l\'upload: ' + (data.message || 'Erreur inconnue'));
                resetUploadZone();
            }
        })
        .catch(error => {
            uploadProgress.style.display = 'none';
            alert('Erreur lors de l\'upload: ' + error.message);
            resetUploadZone();
        });
    }

    // Fonction pour réinitialiser la zone d'upload
    function resetUploadZone() {
        uploadPlaceholder.innerHTML = `
            <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
            <p class="text-muted mb-2">Glissez-déposez votre image ici ou cliquez pour sélectionner</p>
            <small class="text-muted">Formats acceptés: JPG, PNG, GIF, WebP (max 2MB)</small>
        `;
        uploadPlaceholder.style.display = 'block';
        imageFile.value = '';
        imageUrl.value = '';
    }

    // Gestion de la suppression d'image
    removeImage.addEventListener('click', function() {
        imagePreview.style.display = 'none';
        resetUploadZone();
    });
});
</script>
@endsection
