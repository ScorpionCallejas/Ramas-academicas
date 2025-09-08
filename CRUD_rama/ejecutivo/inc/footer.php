<?php
?>
        </main>
        <footer>
            <p>&copy; <?php echo date('Y'); ?> - Sistema de Gestión Académica</p>
        </footer>
    </div>
    
    <!-- Script del loader -->
    <script>
        function mostrarLoader() {
            document.getElementById('loader').style.display = 'block';
        }
        
        function ocultarLoader() {
            document.getElementById('loader').style.display = 'none';
        }
        
        // Mostrar loader al enviar formularios
        document.addEventListener('DOMContentLoaded', function() {
            var forms = document.querySelectorAll('form');
            forms.forEach(function(form) {
                form.addEventListener('submit', function() {
                    mostrarLoader();
                });
            });
        });
    </script>
</body>
</html>