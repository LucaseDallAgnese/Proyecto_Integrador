// Jenkinsfile
pipeline {
    agent any // Ejecutar en el servidor de Jenkins (tu PC)

    // Variables de entorno que debes CAMBIAR
    environment {
        // Usuario y IP de tu SERVIDOR WEB (el de la app)
        WEB_SERVER = 'ubuntu@3.91.53.151'
        // El ID de la credencial SSH para el servidor web que creaste en Jenkins
        WEB_SERVER_CREDENTIAL_ID = 'webserver-ssh'
        // La ruta en el servidor web donde se desplegará el proyecto
        PROJECT_PATH = '/var/www/html/terastore'
        // ¡¡¡CAMBIA ESTO por la URL SSH de tu repo!!!
        GIT_REPO_URL = 'git@github.com:LucaseDallAgnese/Proyecto_Integrador.git'
        // El ID de la credencial de GitHub que creaste en Jenkins
        GIT_CREDENTIAL_ID = 'github-deploy-key'
    }

    stages {
        // Etapa 1: Clonar el código desde GitHub
        stage('Checkout') {
            steps {
                echo "Clonando el repositorio..."
                // Borra el espacio de trabajo anterior para un build limpio
                cleanWs() 
                // Clona el repo usando la credencial
                git credentialsId: GIT_CREDENTIAL_ID, url: GIT_REPO_URL
            }
        }

        // Etapa 2: Sincronizar los archivos con el servidor web
        stage('Deploy') {
            steps {
                echo "Sincronizando archivos con el servidor web..."
                // Usar 'sshagent' con la credencial del servidor web
                sshagent([WEB_SERVER_CREDENTIAL_ID]) {
                    // rsync es más rápido que scp. Sincroniza todo excepto .git y node_modules
                    sh "rsync -avz -e 'ssh -o StrictHostKeyChecking=no' --exclude='.git/' --exclude='node_modules/' ./ ${WEB_SERVER}:${PROJECT_PATH}/"
                }
            }
        }

        // Etapa 3: Comandos finales (en el servidor web)
        // Aquí instalamos dependencias y corremos migraciones REMOTAMENTE
        stage('Post-Deploy') {
            steps {
                echo "Ejecutando comandos finales en el servidor web..."
                sshagent([WEB_SERVER_CREDENTIAL_ID]) {
                    // Comandos que se ejecutan REMOTAMENTE en el servidor web
                    sh """
                        ssh -o StrictHostKeyChecking=no ${WEB_SERVER} 'cd ${PROJECT_PATH} && \\
                        composer install --no-dev --optimize-autoloader && \\
                        npm install && \\
                        npm run build && \\
                        sudo chown -R www-data:www-data storage bootstrap/cache && \\
                        sudo chmod -R 775 storage bootstrap/cache && \\
                        php artisan config:cache && \\
                        php artisan route:cache && \\
                        php artisan view:cache && \\
                        php artisan migrate --force && \\
                        php artisan storage:link'
                    """
                }
            }
        }
    }
    
    post {
        // Al finalizar, sin importar si falla o no
        always {
            echo "Limpiando el espacio de trabajo..."
            cleanWs()
        }
    }
}