/**
 * Script para el menú desplegable de usuario - VERSIÓN CORREGIDA
 * Archivo: public/js/user-menu.js
 */

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
    
    console.log('🔧 Iniciando script del menú de usuario...');
    
    // Elementos del menú
    const userMenuButton = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');
    const userMenu = document.querySelector('.user-menu');
    
    // Verificar que los elementos existen
    if (!userMenuButton) {
        console.log('⚠️ No se encontró userMenuButton');
        return;
    }
    
    if (!userDropdown) {
        console.log('⚠️ No se encontró userDropdown');
        return;
    }
    
    console.log('✅ Elementos encontrados correctamente');
    
    /**
     * Toggle del menú desplegable
     */
    function toggleUserMenu(event) {
        event.stopPropagation(); // Prevenir que el clic se propague
        
        const isOpen = userDropdown.classList.contains('show');
        
        if (isOpen) {
            closeUserMenu();
            console.log('🔽 Menú cerrado');
        } else {
            openUserMenu();
            console.log('🔼 Menú abierto');
        }
    }
    
    /**
     * Cerrar el menú
     */
    function closeUserMenu() {
        userDropdown.classList.remove('show');
        userMenuButton.classList.remove('active');
    }
    
    /**
     * Abrir el menú
     */
    function openUserMenu() {
        userDropdown.classList.add('show');
        userMenuButton.classList.add('active');
    }
    
    // Event listener para el botón del menú
    userMenuButton.addEventListener('click', toggleUserMenu);
    console.log('✅ Event listener agregado al botón');
    
    // Cerrar el menú cuando se hace clic fuera
    document.addEventListener('click', function(event) {
        if (userMenu && !userMenu.contains(event.target)) {
            closeUserMenu();
            console.log('🔽 Menú cerrado (clic fuera)');
        }
    });
    
    // Cerrar el menú al presionar Escape
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape' || event.key === 'Esc') {
            closeUserMenu();
            console.log('🔽 Menú cerrado (Escape)');
        }
    });
    
    // Cerrar el menú al hacer clic en cualquier enlace del menú
    const menuLinks = userDropdown.querySelectorAll('a');
    menuLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            closeUserMenu();
            console.log('🔽 Menú cerrado (clic en enlace)');
        });
    });
    
    console.log('✅ Menú de usuario inicializado correctamente');
});
