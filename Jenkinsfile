// ... (Stages Checkout, Build Assets, Deploy no cambiaron) ...

// Etapa 4: Comandos finales (Remoto en el servidor web)
stage('Post-Deploy') {
    steps {
        echo "Ejecutando comandos finales en el servidor web..."
        sshagent([WEB_SERVER_CREDENTIAL_ID]) {
            
            // PASO 1: PERMISOS TEMPORALES 777 (Permite a Composer escribir)
            sh """
                ssh -o StrictHostKeyChecking=no ${WEB_SERVER} 'cd ${PROJECT_PATH} && \\
                chmod -R 777 storage bootstrap/cache'
            """
            
            // PASO 2: COMANDOS DE LARAVEL (REINICIO y Ejecución)
            sh """
                ssh -o StrictHostKeyChecking=no ${WEB_SERVER} 'cd ${PROJECT_PATH} && \\
                
                # ✨ AJUSTE FINAL: REINICIAR CON SYSTEMCTL (más estable que 'service')
                # 1. Intentar iniciar PHP-FPM por si está caído (systemctl start)
                sudo systemctl start php8.2-fpm.service 2>/dev/null || true && \\
                # 2. Reiniciar los servicios para cargar el driver de MySQL (systemctl restart)
                sudo systemctl restart php8.2-fpm.service && \\ 
                sudo systemctl restart nginx.service && \\ 
                
                # COMANDOS DE LARAVEL
                composer install --no-dev --optimize-autoloader && \\
                php artisan config:cache && \\
                php artisan route:cache && \\
                php artisan view:cache && \\
                php artisan migrate --force && \\
                php artisan storage:link'
            """

            // PASO 3: DEVOLVER LA PROPIEDAD Y PERMISOS (Seguridad)
            sh """
                ssh -o StrictHostKeyChecking=no ${WEB_SERVER} 'cd ${PROJECT_PATH} && \\
                sudo chown -R www-data:www-data storage bootstrap/cache && \\
                sudo chmod -R 775 storage bootstrap/cache'
            """
        }
    }
}

// ... (Post-actions) ...
