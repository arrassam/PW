/**
 * Validation côté client pour les formulaires GameCycle
 * Validation JavaScript sans HTML5
 */

// Fonction utilitaire pour afficher les erreurs
function showError(inputId, message) {
    const input = document.getElementById(inputId);
    let errorDiv = input.nextElementSibling;
    
    // Créer le div d'erreur s'il n'existe pas
    if (!errorDiv || !errorDiv.classList.contains('error-message')) {
        errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.color = 'var(--danger)';
        errorDiv.style.fontSize = '0.85rem';
        errorDiv.style.marginTop = '0.5rem';
        input.parentNode.insertBefore(errorDiv, input.nextSibling);
    }
    
    errorDiv.textContent = message;
    input.style.borderColor = 'var(--danger)';
}

// Fonction utilitaire pour effacer les erreurs
function clearError(inputId) {
    const input = document.getElementById(inputId);
    const errorDiv = input.nextElementSibling;
    
    if (errorDiv && errorDiv.classList.contains('error-message')) {
        errorDiv.textContent = '';
    }
    input.style.borderColor = '';
}

// Validation des publications (Create & Edit)
function validatePostForm(event) {
    event.preventDefault();
    
    const title = document.getElementById('title');
    const content = document.getElementById('content');
    const status = document.getElementById('status');
    
    let isValid = true;
    
    // Validation du titre
    clearError('title');
    if (!title.value || title.value.trim() === '') {
        showError('title', '⚠️ Le titre est obligatoire');
        isValid = false;
    } else if (title.value.trim().length < 5) {
        showError('title', '⚠️ Le titre doit contenir au moins 5 caractères');
        isValid = false;
    } else if (title.value.trim().length > 200) {
        showError('title', '⚠️ Le titre ne peut pas dépasser 200 caractères');
        isValid = false;
    }
    
    // Validation du contenu
    clearError('content');
    if (!content.value || content.value.trim() === '') {
        showError('content', '⚠️ Le contenu est obligatoire');
        isValid = false;
    } else if (content.value.trim().length < 20) {
        showError('content', '⚠️ Le contenu doit contenir au moins 20 caractères');
        isValid = false;
    } else if (content.value.trim().length > 5000) {
        showError('content', '⚠️ Le contenu ne peut pas dépasser 5000 caractères');
        isValid = false;
    }
    
    // Validation du statut
    clearError('status');
    if (!status.value) {
        showError('status', '⚠️ Veuillez sélectionner un statut');
        isValid = false;
    }
    
    // Si tout est valide, soumettre le formulaire
    if (isValid) {
        event.target.submit();
    }
    
    return isValid;
}

// Validation des commentaires
function validateCommentForm(event) {
    event.preventDefault();
    
    const content = document.getElementById('comment_content');
    let isValid = true;
    
    clearError('comment_content');
    
    if (!content.value || content.value.trim() === '') {
        showError('comment_content', '⚠️ Le commentaire ne peut pas être vide');
        isValid = false;
    } else if (content.value.trim().length < 3) {
        showError('comment_content', '⚠️ Le commentaire doit contenir au moins 3 caractères');
        isValid = false;
    } else if (content.value.trim().length > 1000) {
        showError('comment_content', '⚠️ Le commentaire ne peut pas dépasser 1000 caractères');
        isValid = false;
    }
    
    if (isValid) {
        event.target.submit();
    }
    
    return isValid;
}

// Compteur de caractères en temps réel
function setupCharacterCounter(textareaId, maxLength) {
    const textarea = document.getElementById(textareaId);
    if (!textarea) return;
    
    const counter = document.createElement('div');
    counter.className = 'char-counter';
    counter.style.textAlign = 'right';
    counter.style.fontSize = '0.85rem';
    counter.style.color = 'var(--secondary)';
    counter.style.marginTop = '0.5rem';
    
    textarea.parentNode.insertBefore(counter, textarea.nextSibling);
    
    function updateCounter() {
        const length = textarea.value.length;
        counter.textContent = `${length} / ${maxLength} caractères`;
        
        if (length > maxLength) {
            counter.style.color = 'var(--danger)';
        } else if (length > maxLength * 0.9) {
            counter.style.color = 'var(--warning)';
        } else {
            counter.style.color = 'var(--secondary)';
        }
    }
    
    textarea.addEventListener('input', updateCounter);
    updateCounter();
}

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    // Attacher la validation aux formulaires de posts
    const postForms = document.querySelectorAll('form[action*="admin-post-store"], form[action*="admin-post-update"]');
    postForms.forEach(form => {
        form.addEventListener('submit', validatePostForm);
    });
    
    // Attacher la validation aux formulaires de commentaires
    const commentForms = document.querySelectorAll('form[action*="comment-store"]');
    commentForms.forEach(form => {
        form.addEventListener('submit', validateCommentForm);
    });
    
    // Ajouter les compteurs de caractères
    if (document.getElementById('title')) {
        setupCharacterCounter('title', 200);
    }
    if (document.getElementById('content')) {
        setupCharacterCounter('content', 5000);
    }
    if (document.getElementById('comment_content')) {
        setupCharacterCounter('comment_content', 1000);
    }
    
    // Désactiver la validation HTML5 native
    const allForms = document.querySelectorAll('form');
    allForms.forEach(form => {
        form.setAttribute('novalidate', 'novalidate');
    });
});