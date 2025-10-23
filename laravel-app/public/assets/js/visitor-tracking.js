/**
 * Visitor Tracking JavaScript
 * Sistema de tracking de visitantes en tiempo real
 */
class VisitorTracker {
    constructor() {
        this.sessionId = this.getSessionId();
        this.currentPage = window.location.href;
        this.pageTitle = document.title;
        this.startTime = Date.now();
        this.isVisible = !document.hidden;
        this.lastHeartbeat = Date.now();
        this.heartbeatInterval = null;
        this.pageChangeInterval = null;
        
        this.init();
    }

    init() {
        // Configurar eventos de visibilidad
        this.setupVisibilityEvents();
        
        // Configurar eventos de navegación
        this.setupNavigationEvents();
        
        // Iniciar heartbeat
        this.startHeartbeat();
        
        // Trackear tiempo de página al cargar
        this.trackPageLoad();
        
        // Trackear tiempo cuando se cierra la página
        this.setupPageUnload();
    }

    /**
     * Obtener o generar ID de sesión
     */
    getSessionId() {
        let sessionId = sessionStorage.getItem('visitor_session_id');
        if (!sessionId) {
            sessionId = 'visitor_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            sessionStorage.setItem('visitor_session_id', sessionId);
        }
        return sessionId;
    }

    /**
     * Configurar eventos de visibilidad de la página
     */
    setupVisibilityEvents() {
        document.addEventListener('visibilitychange', () => {
            this.isVisible = !document.hidden;
            
            if (this.isVisible) {
                this.startTime = Date.now();
                this.lastHeartbeat = Date.now();
            } else {
                // Enviar tiempo acumulado cuando la página se oculta
                this.sendPageTime();
            }
        });

        // También trackear cuando la ventana pierde/gana foco
        window.addEventListener('focus', () => {
            this.isVisible = true;
            this.startTime = Date.now();
            this.lastHeartbeat = Date.now();
        });

        window.addEventListener('blur', () => {
            this.isVisible = false;
            this.sendPageTime();
        });
    }

    /**
     * Configurar eventos de navegación
     */
    setupNavigationEvents() {
        // Trackear cambios de URL (para SPAs)
        let lastUrl = window.location.href;
        
        this.pageChangeInterval = setInterval(() => {
            if (window.location.href !== lastUrl) {
                this.handlePageChange(lastUrl);
                lastUrl = window.location.href;
            }
        }, 1000);

        // Trackear cambios de título
        const titleObserver = new MutationObserver(() => {
            if (document.title !== this.pageTitle) {
                this.pageTitle = document.title;
            }
        });
        
        titleObserver.observe(document.querySelector('title'), {
            childList: true,
            subtree: true
        });
    }

    /**
     * Manejar cambio de página
     */
    handlePageChange(oldUrl) {
        // Enviar tiempo de la página anterior
        this.sendPageTime(oldUrl);
        
        // Actualizar datos de la nueva página
        this.currentPage = window.location.href;
        this.pageTitle = document.title;
        this.startTime = Date.now();
        this.lastHeartbeat = Date.now();
        
        // Trackear carga de nueva página
        this.trackPageLoad();
    }

    /**
     * Iniciar heartbeat para tracking continuo
     */
    startHeartbeat() {
        this.heartbeatInterval = setInterval(() => {
            if (this.isVisible) {
                const currentTime = Date.now();
                const timeSpent = Math.floor((currentTime - this.startTime) / 1000);
                
                // Enviar heartbeat cada 30 segundos
                if (currentTime - this.lastHeartbeat >= 30000) {
                    this.sendHeartbeat(timeSpent);
                    this.lastHeartbeat = currentTime;
                }
            }
        }, 5000); // Verificar cada 5 segundos
    }

    /**
     * Enviar heartbeat al servidor
     */
    async sendHeartbeat(timeSpent) {
        try {
            const response = await fetch('/api/visitor-tracking/track-page-time', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    session_id: this.sessionId,
                    page_url: this.currentPage,
                    time_spent: timeSpent,
                    page_title: this.pageTitle
                })
            });

            if (!response.ok) {
                console.warn('Error enviando heartbeat:', response.statusText);
            }
        } catch (error) {
            console.warn('Error en heartbeat:', error);
        }
    }

    /**
     * Enviar tiempo de página al servidor
     */
    async sendPageTime(pageUrl = null) {
        const url = pageUrl || this.currentPage;
        const timeSpent = Math.floor((Date.now() - this.startTime) / 1000);
        
        if (timeSpent < 1) return; // No enviar si es menos de 1 segundo

        try {
            await fetch('/api/visitor-tracking/track-page-time', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                },
                body: JSON.stringify({
                    session_id: this.sessionId,
                    page_url: url,
                    time_spent: timeSpent,
                    page_title: this.pageTitle
                })
            });
        } catch (error) {
            console.warn('Error enviando tiempo de página:', error);
        }
    }

    /**
     * Trackear carga de página
     */
    trackPageLoad() {
        // Enviar datos iniciales de la página
        setTimeout(() => {
            this.sendPageTime();
        }, 1000);
    }

    /**
     * Configurar eventos de cierre de página
     */
    setupPageUnload() {
        // Enviar tiempo cuando se cierra la página
        window.addEventListener('beforeunload', () => {
            this.sendPageTime();
        });

        // También usar sendBeacon si está disponible (más confiable)
        window.addEventListener('pagehide', () => {
            const timeSpent = Math.floor((Date.now() - this.startTime) / 1000);
            
            if (navigator.sendBeacon) {
                const data = JSON.stringify({
                    session_id: this.sessionId,
                    page_url: this.currentPage,
                    time_spent: timeSpent,
                    page_title: this.pageTitle
                });
                
                navigator.sendBeacon('/api/visitor-tracking/track-page-time', data);
            } else {
                this.sendPageTime();
            }
        });
    }

    /**
     * Obtener estadísticas de visitantes activos
     */
    static async getActiveVisitors(minutes = 5) {
        try {
            const response = await fetch(`/api/visitor-tracking/active-visitors?minutes=${minutes}`);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error obteniendo visitantes activos:', error);
            return null;
        }
    }

    /**
     * Obtener estadísticas generales
     */
    static async getStats(days = 7) {
        try {
            const response = await fetch(`/api/visitor-tracking/stats?days=${days}`);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error obteniendo estadísticas:', error);
            return null;
        }
    }

    /**
     * Obtener páginas más visitadas
     */
    static async getTopPages(limit = 10) {
        try {
            const response = await fetch(`/api/visitor-tracking/top-pages?limit=${limit}`);
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Error obteniendo páginas top:', error);
            return null;
        }
    }

    /**
     * Destruir tracker (limpiar intervalos)
     */
    destroy() {
        if (this.heartbeatInterval) {
            clearInterval(this.heartbeatInterval);
        }
        if (this.pageChangeInterval) {
            clearInterval(this.pageChangeInterval);
        }
    }
}

// Inicializar tracker cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    // Solo inicializar si no estamos en una página de administración de tracking
    if (!window.location.pathname.includes('/admin/visitor-tracking')) {
        window.visitorTracker = new VisitorTracker();
    }
});

// Exportar para uso global
window.VisitorTracker = VisitorTracker;
