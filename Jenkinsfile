// Jenkinsfile
pipeline {
    agent any 

    // Variables de entorno
    environment {
        // --- Variables de tu SERVIDOR WEB (EC2, Droplet, etc.) ---
        WEB_SERVER = 'ubuntu@3.151.11.146'
        // El ID de la credencial SSH para el servidor web (ej: ubuntu)
        WEB_SERVER_CREDENTIAL_ID = 'webserver-ssh' 
        // La ruta de despliegue en el servidor web
        PROJECT_PATH = '/var/www/html/terastore'
        
        // --- Variables del Repositorio de Código ---
        GIT_REPO_URL = 'https://github.com/LucaseDallAgnese/Proyecto_Integrador.git'
        // El ID de la credencial de GitHub
        GIT_CREDENTIAL_ID = 'github-token' 
    }

    stages {
        stage('Checkout') {
            steps {
                echo "Clonando el repositorio..."
                cleanWs() 
                git branch: 'Master', credentialsId: GIT_CREDENTIAL_ID, url: GIT_REPO_URL
            }
        }
        
        // Etapa 2: Construir los assets de frontend en Jenkins (Donde es Linux)
        stage('Build Assets') {
            steps {
                echo "Instalando dependencias de Node.js y construyendo assets..."
                
                // 1. Instalación forzada: USAMOS npm install --force (Corrige la sintaxis y el EBADPLATFORM)
                // Se mantiene el /bin/bash -c para asegurar que encuentra npm en el contenedor Docker.
                sh '/bin/bash -c "npm install --force"' 
                
                // 2. Ejecutar la construcción de Vite
                sh '/bin/bash -c "npm run build"'
            }
        }

        // Etapa 3: Sincronizar (Deploy)
        stage('Deploy') {
            steps {
                echo "Sincronizando archivos con el servidor web..."
                sshagent([WEB_SERVER_CREDENTIAL_ID]) {
                    // Sincroniza todo, excluyendo archivos de desarrollo/configuración innecesarios.
                    sh "rsync -avz -e 'ssh -o StrictHostKeyChecking=no' --exclude='.git/' --exclude='node_modules/' --exclude='resources/' ./ ${WEB_SERVER}:${PROJECT_PATH}/"
                }
            }
        }

        // Etapa 4: Comandos finales (Remoto en el servidor web)
        stage('Post-Deploy') {
            steps {
                echo "Ejecutando comandos finales en el servidor web..."
                sshagent([WEB_SERVER_CREDENTIAL_ID]) {
                    sh """
                        ssh -o StrictHostKeyChecking=no ${WEB_SERVER} 'cd ${PROJECT_PATH} && \\
                        composer install --no-dev --optimize-autoloader && \\
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
        always {
            echo "Limpiando el espacio de trabajo..."
            cleanWs()
        }
    }
}