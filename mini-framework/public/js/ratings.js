/**
 * Sistema de Calificación con Estrellas
 * Maneja la interacción del usuario con el sistema de rating
 */

document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('starContainer');
    
    // Verificar si existe el contenedor de estrellas
    if (!container) {
        return;
    }
    
    const labels = container.querySelectorAll('label');
    const inputs = container.querySelectorAll('input[type="radio"]');
    
    /**
     * Actualiza el color de las estrellas según la calificación
     * @param {number} rating - Número de estrellas a iluminar (1-5)
     */
    function updateStars(rating) {
        labels.forEach(label => {
            const value = parseInt(label.getAttribute('data-value'));
            if (value <= rating) {
                label.style.color = '#ffc107';
            } else {
                label.style.color = '#d4d4d4';
            }
        });
    }
    
    /**
     * Obtiene la calificación actual seleccionada
     * @returns {number} Valor de la estrella seleccionada o 0
     */
    function getCurrentRating() {
        const checkedInput = container.querySelector('input[type="radio"]:checked');
        return checkedInput ? parseInt(checkedInput.value) : 0;
    }
    
    // Inicializar con calificación existente (si hay)
    const initialRating = getCurrentRating();
    if (initialRating > 0) {
        updateStars(initialRating);
    }
    
    // Eventos en cada estrella
    labels.forEach(label => {
        
        // Evento click - Selecciona la calificación
        label.addEventListener('click', function() {
            const value = parseInt(this.getAttribute('data-value'));
            updateStars(value);
        });
        
        // Evento hover - Muestra preview de la calificación
        label.addEventListener('mouseenter', function() {
            const value = parseInt(this.getAttribute('data-value'));
            labels.forEach(l => {
                const lValue = parseInt(l.getAttribute('data-value'));
                if (lValue <= value) {
                    l.style.transform = 'scale(1.1)';
                    l.style.color = '#ffc107';
                }
            });
        });
        
        // Evento mouseleave - Restaura la calificación seleccionada
        label.addEventListener('mouseleave', function() {
            labels.forEach(l => {
                l.style.transform = 'scale(1)';
            });
            const currentRating = getCurrentRating();
            updateStars(currentRating);
        });
    });
    
    // Accesibilidad: Permitir navegación con teclado
    labels.forEach((label, index) => {
        label.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const input = document.getElementById(label.getAttribute('for'));
                if (input) {
                    input.checked = true;
                    updateStars(parseInt(input.value));
                }
            }
        });
        
        // Hacer las labels enfocables con teclado
        label.setAttribute('tabindex', '0');
    });
    
    console.log('Sistema de calificación con estrellas inicializado correctamente');
});
