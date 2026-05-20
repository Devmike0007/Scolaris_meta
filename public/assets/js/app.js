// Application JavaScript pour Scolaris Meta VR

document.addEventListener('DOMContentLoaded', function() {
    // Éléments DOM
    const promptInput = document.getElementById('prompt-input');
    const generateBtn = document.getElementById('generate-btn');
    const loader = document.getElementById('loader');
    const resultSection = document.getElementById('result-section');
    const generatedImage = document.getElementById('generated-image');
    const vrLink = document.getElementById('vr-link');
    const newPromptBtn = document.getElementById('new-prompt');
    const historyList = document.getElementById('history-list');
    
    // Charger l'historique au démarrage
    loadHistory();
    
    // Gestionnaire pour le bouton de génération
    generateBtn.addEventListener('click', generateImage);
    
    // Gestionnaire pour la touche Entrée dans le textarea
    promptInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && e.ctrlKey) {
            e.preventDefault();
            generateImage();
        }
    });
    
    // Gestionnaire pour le bouton "Nouveau prompt"
    newPromptBtn.addEventListener('click', function() {
        resultSection.style.display = 'none';
        promptInput.value = '';
        promptInput.focus();
    });
    
    // Fonction pour générer une image
    async function generateImage() {
        const prompt = promptInput.value.trim();
        
        if (!prompt) {
            alert('Veuillez entrer un prompt avant de générer une image.');
            promptInput.focus();
            return;
        }
        
        // Afficher le loader
        loader.style.display = 'block';
        generateBtn.disabled = true;
        
        try {
            const response = await fetch('index.php?action=generate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: new URLSearchParams({
                    'prompt': prompt
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Afficher le résultat
                generatedImage.src = data.image_url;
                vrLink.href = data.vr_url;
                
                // Cacher le loader et afficher le résultat
                loader.style.display = 'none';
                resultSection.style.display = 'block';
                
                // Recharger l'historique
                loadHistory();
                
                // Faire défiler jusqu'au résultat
                resultSection.scrollIntoView({ behavior: 'smooth' });
            } else {
                throw new Error(data.error || 'Erreur lors de la génération');
            }
        } catch (error) {
            console.error('Erreur:', error);
            alert('Erreur lors de la génération de l\'image: ' + error.message);
        } finally {
            // Réactiver le bouton
            generateBtn.disabled = false;
            loader.style.display = 'none';
        }
    }
    
    // Fonction pour charger l'historique
    async function loadHistory() {
        try {
            const response = await fetch('index.php?action=history');
            const data = await response.json();
            
            if (data.success && data.prompts.length > 0) {
                updateHistoryList(data.prompts);
            }
        } catch (error) {
            console.error('Erreur lors du chargement de l\'historique:', error);
        }
    }
    
    // Fonction pour mettre à jour la liste d'historique
    function updateHistoryList(prompts) {
        historyList.innerHTML = '';
        
        prompts.forEach(prompt => {
            const historyItem = document.createElement('div');
            historyItem.className = 'history-item';
            
            const date = new Date(prompt.created_at);
            const formattedDate = date.toLocaleDateString('fr-FR', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            historyItem.innerHTML = `
                <div class="prompt-text">${escapeHtml(prompt.prompt)}</div>
                <div class="prompt-meta">
                    <span class="date">${formattedDate}</span>
                    <a href="../vr/scene.html?image=${encodeURIComponent(prompt.image_url)}" target="_blank" class="btn-small">
                        <i class="fas fa-eye"></i> Voir en VR
                    </a>
                </div>
            `;
            
            historyList.appendChild(historyItem);
        });
    }
    
    // Fonction pour échapper le HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Animation pour le bouton de génération
    generateBtn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
    });
    
    generateBtn.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
    });
    
    // Focus automatique sur le champ prompt
    if (!promptInput.value) {
        promptInput.focus();
    }
    
    // Gestion des messages d'erreur
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('error')) {
        alert(urlParams.get('error'));
    }
});

// Fonction utilitaire pour formater les dates
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}