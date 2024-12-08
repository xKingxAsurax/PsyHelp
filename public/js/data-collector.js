class DataCollector {
    constructor() {
        this.queue = [];
        this.processing = false;
        this.init();
    }

    init() {
        this.trackUserInteractions();
        this.trackErrors();
        window.addEventListener('beforeunload', () => this.flush());
    }

    trackUserInteractions() {
        document.addEventListener('click', (e) => {
            const target = e.target.closest('[data-track]');
            if (target) {
                this.logInteraction('click', {
                    element: target.dataset.track,
                    text: target.textContent.trim()
                });
            }
        });

        // Seguimiento de scroll
        let lastScrollPosition = 0;
        let scrollTimeout;
        
        window.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                const scrollPosition = window.scrollY;
                const scrollPercentage = (scrollPosition / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
                
                if (Math.abs(scrollPosition - lastScrollPosition) > 100) {
                    this.logInteraction('scroll', {
                        position: scrollPosition,
                        percentage: scrollPercentage.toFixed(2)
                    });
                    lastScrollPosition = scrollPosition;
                }
            }, 500);
        });
    }

    trackErrors() {
        window.addEventListener('error', (e) => {
            this.logError('javascript', e.message, {
                filename: e.filename,
                lineno: e.lineno,
                colno: e.colno
            });
        });
    }

    async logInteraction(type, details) {
        this.queue.push({
            type: 'interaction',
            data: {
                type,
                details,
                timestamp: new Date().toISOString()
            }
        });
        await this.processQueue();
    }

    async logError(type, message, details = {}) {
        this.queue.push({
            type: 'error',
            data: {
                type,
                message,
                details,
                timestamp: new Date().toISOString()
            }
        });
        await this.processQueue();
    }

    async processQueue() {
        if (this.processing || this.queue.length === 0) return;
        
        this.processing = true;
        
        try {
            const batch = this.queue.splice(0, 10);
            await fetch('/api/collect-data', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ events: batch })
            });
        } catch (error) {
            console.error('Error sending data:', error);
            this.queue.unshift(...batch);
        } finally {
            this.processing = false;
            if (this.queue.length > 0) {
                await this.processQueue();
            }
        }
    }

    async flush() {
        if (this.queue.length > 0) {
            await this.processQueue();
        }
    }
}

// Inicializar el recopilador de datos
window.dataCollector = new DataCollector(); 