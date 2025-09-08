const storedTheme = localStorage.getItem('theme') || 
        (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        
            if (storedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            }

            // Aplica sidebar colapsado antes de pintar (solo escritorio)
            if (window.innerWidth > 768 && localStorage.getItem('sidebarCollapsed') === '1') {
                // Espera a que el sidebar esté en el DOM y aplica la clase lo antes posible
                const applySidebarCollapsed = () => {
                    const sidebar = document.getElementById('sidebar');
                    if (sidebar && !sidebar.classList.contains('collapsed')) {
                        sidebar.classList.add('collapsed');
                        return true;
                    }
                    return false;
                };
                if (!applySidebarCollapsed()) {
                    // Si aún no existe, observa el DOM hasta que aparezca
                    const observer = new MutationObserver(() => {
                        if (applySidebarCollapsed()) observer.disconnect();
                    });
                    observer.observe(document.documentElement, { childList: true, subtree: true });
                }
            }