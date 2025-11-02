pipeline {
    agent any 

    // Variables de entorno
    environment {
        WEB_SERVER = 'ubuntu@3.151.11.146'
        WEB_SERVER_CREDENTIAL_ID = 'webserver-ssh' 
        PROJECT_PATH = '/var/www/html/terastore'
        GIT_REPO_URL = 'https://github.com/LucaseDallAgnese/Proyecto_Integrador.git'
        GIT_CREDENTIAL_ID = 'github-token' 
    }

    stages {
        // ... (Checkout y Build Assets no cambiaron) ...

        stage('Deploy') {
            steps {
                echo "Sincronizando archivos con el servidor web..."
                sshagent([WEB_SERVER_CREDENTIAL_ID]) {
                    // CÓDIGO CORREGIDO: Añade flags --no-o --no-g --no-p
                    sh "rsync -avz --no-o --no-g --no-p -e 'ssh -o StrictHostKeyChecking=no' --exclude='.git/' --exclude='node_modules/' --exclude='resources/' ./ ${WEB_SERVER}:${PROJECT_PATH}/"
                }
            }
        }

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
                    
                    // ✨✨ CAMBIO CRÍTICO AQUÍ: AÑADIMOS EL REINICIO ✨✨
                    sh """
                        ssh -o StrictHostKeyChecking=no ${WEB_SERVER} 'cd ${PROJECT_PATH} && \\
                        // REINICIAR LOS SERVICIOS para que PHP vea la extensión MySQL recién instalada
                        sudo service php8.2-fpm restart && \\
                        sudo service nginx restart && \\
                        // COMANDOS DE LARAVEL
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
    }
    
    post {
        always {
            echo "Limpiando el espacio de trabajo..."
            cleanWs()
        }
    }
}
