// JavaScript personalizado para Tabler

// Manejar el sidebar responsive
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.querySelector('.navbar-toggler');
    const sidebar = document.querySelector('.navbar-vertical');
    const sidebarMenu = document.querySelector('#sidebar-menu');
    
    function updateSidebarVisibility() {
        if (window.innerWidth >= 400) {
            // Desktop: sidebar siempre visible
            if (sidebar) {
                sidebar.style.display = 'block';
                sidebar.style.transform = 'translateX(0)';
                sidebar.classList.remove('show');
            }
            if (sidebarMenu) {
                sidebarMenu.classList.add('show');
                sidebarMenu.style.display = 'block';
            }
        } else {
            // Móvil: sidebar oculto por defecto
            if (sidebar) {
                sidebar.style.transform = 'translateX(-100%)';
                sidebar.classList.remove('show');
            }
        }
    }
    
    // Aplicar configuración inicial
    updateSidebarVisibility();
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            if (window.innerWidth < 400) {
                sidebar.classList.toggle('show');
                if (sidebar.classList.contains('show')) {
                    sidebar.style.transform = 'translateX(0)';
                } else {
                    sidebar.style.transform = 'translateX(-100%)';
                }
            }
        });
        
        // Cerrar sidebar al hacer clic fuera de él en móviles
        document.addEventListener('click', function(event) {
            if (window.innerWidth < 400) {
                if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                    sidebar.classList.remove('show');
                    sidebar.style.transform = 'translateX(-100%)';
                }
            }
        });
        
        // Manejar el resize de ventana
        window.addEventListener('resize', updateSidebarVisibility);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Inicializar popovers
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Manejar el sidebar en móviles
    const sidebarToggle = document.querySelector('[data-bs-target="#sidebar-menu"]');
    const sidebar = document.querySelector('.navbar-vertical');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });

        // Cerrar sidebar al hacer clic fuera
        document.addEventListener('click', function(event) {
            if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                sidebar.classList.remove('show');
            }
        });
    }

    // Auto-cerrar alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Inicializar DataTables si existen
    if (typeof $.fn.DataTable !== 'undefined') {
        $('.data-table').DataTable({
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 25,
            order: [[0, 'desc']],
            columnDefs: [
                { orderable: false, targets: -1 }
            ]
        });
    }

    // Mejorar la experiencia de usuario con animaciones suaves
    const cards = document.querySelectorAll('.card');
    cards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'transform 0.2s ease-in-out';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Manejar formularios con validación
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });

    // Confirmar eliminación
    const deleteButtons = document.querySelectorAll('[data-confirm-delete]');
    deleteButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const message = this.getAttribute('data-confirm-message') || '¿Estás seguro de que quieres eliminar este elemento?';
            
            if (confirm(message)) {
                const form = this.closest('form');
                if (form) {
                    form.submit();
                } else {
                    window.location.href = this.href;
                }
            }
        });
    });

    // Mejorar la navegación del sidebar
    const navLinks = document.querySelectorAll('.navbar-vertical .nav-link');
    navLinks.forEach(function(link) {
        if (link.href === window.location.href) {
            link.classList.add('active');
        }
    });

    // Lazy loading para imágenes
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver(function(entries, observer) {
        entries.forEach(function(entry) {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                imageObserver.unobserve(img);
            }
        });
    });

    images.forEach(function(img) {
        imageObserver.observe(img);
    });
});

// Funciones globales útiles
window.tablerUtils = {
    // Mostrar notificación toast
    showToast: function(message, type = 'info') {
        const toastContainer = document.getElementById('toast-container') || this.createToastContainer();
        const toast = this.createToast(message, type);
        toastContainer.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remover el toast del DOM después de que se oculte
        toast.addEventListener('hidden.bs.toast', function() {
            toast.remove();
        });
    },
    
    // Crear contenedor de toasts
    createToastContainer: function() {
        const container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'toast-container position-fixed top-0 end-0 p-3';
        container.style.zIndex = '9999';
        document.body.appendChild(container);
        return container;
    },
    
    // Crear toast
    createToast: function(message, type) {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        return toast;
    },
    
    // Confirmar acción
    confirm: function(message, callback) {
        if (confirm(message)) {
            callback();
        }
    },
    
    // Cargar contenido dinámicamente
    loadContent: function(url, container, callback) {
        fetch(url)
            .then(response => response.text())
            .then(html => {
                container.innerHTML = html;
                if (callback) callback();
            })
            .catch(error => {
                console.error('Error loading content:', error);
                this.showToast('Error al cargar el contenido', 'danger');
            });
    }
};
