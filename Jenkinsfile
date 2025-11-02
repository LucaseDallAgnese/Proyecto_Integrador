pipeline {
    agent any

    // 🆕 MEJORA: Define opciones globales para el pipeline
    options {
        // Ejecuta cleanWs() al inicio del pipeline para asegurar un entorno limpio antes del Checkout
        // Esto reemplaza el 'cleanWs()' dentro del 'stage('Checkout')'
        skipDefaultCheckout()
        // Limpia el workspace después del pipeline (si falla o tiene éxito)
        // Esto reemplaza el 'cleanWs()' en el 'post { always { ... } }'
        // workspaceCleanup() 
    }

    // Variables de entorno
    environment {
        WEB_SERVER = 'ubuntu@3.151.11.146'
        WEB_SERVER_CREDENTIAL_ID = 'webserver-ssh' 
        PROJECT_PATH = '/var/www/html/terastore'
        GIT_REPO_URL = '[https://github.com/LucaseDallAgnese/Proyecto_Integrador.git](https://github.com/LucaseDallAgnese/Proyecto_Integrador.git)'
        GIT_CREDENTIAL_ID = 'github-token' 
    }

    stages {
        stage('Checkout') {
            steps {
                echo "Limpiando y clonando el repositorio..."
                cleanWs() // Dejamos el cleanWs() aquí si no se usa la directiva options
                // ⚠️ Nota: 'Master' generalmente debería ser 'main' o 'master' (minúsculas)
                git branch: 'Master', credentialsId: GIT_CREDENTIAL_ID, url: GIT_REPO_URL
            }
        }
        
        stage('Build Assets') {
            steps {
                echo "Instalando dependencias de Node.js y construyendo assets..."
                // Usar 'sh' directamente es suficiente, no siempre es necesario el '/bin/bash -c'
                sh 'npm install --force' 
                sh 'npm run build'
            }
        }

        stage('Deploy') {
            steps {
                echo "Sincronizando archivos con el servidor web..."
                sshagent([WEB_SERVER_CREDENTIAL_ID]) {
                    // Sincroniza todo con rsync, deshabilitando la preservación de permisos de grupo/dueño (chgrp/chown)
                    sh "rsync -avz --no-o --no-g --no-p -e 'ssh -o StrictHostKeyChecking=no' --exclude='.git/' --exclude='node_modules/' --exclude='resources/' ./ ${WEB_SERVER}:${PROJECT_PATH}/"
                }
            }
        }

        // Etapa 4: Comandos finales (Remoto en el servidor web)
        stage('Post-Deploy') {
            steps {
                echo "Ejecutando comandos finales en el servidor web..."
                sshagent([WEB_SERVER_CREDENTIAL_ID]) {
                    
                    // PASO 1: PERMISOS TEMPORALES 777
                    sh "ssh -o StrictHostKeyChecking=no ${WEB_SERVER} 'cd ${PROJECT_PATH} && chmod -R 777 storage bootstrap/cache'"
                    
                    // PASO 2: LARAVEL CORE (Composer, Cache, Migraciones)
                    // Se ha eliminado el comentario de Markdown y el cuerpo de la nota al inicio.
                    // Se mantiene el reinicio del servicio PHP/Nginx por si hay problemas con drivers.
                    sh """
                        ssh -o StrictHostKeyChecking=no ${WEB_SERVER} 'cd ${PROJECT_PATH} && 
                        
                        sudo systemctl restart php8.2-fpm.service || true && 
                        sudo systemctl restart nginx.service || true &&
                        
                        composer install --no-dev --optimize-autoloader && 
                        php artisan config:cache && 
                        php artisan route:cache && 
                        php artisan view:cache && 
                        php artisan migrate --force && 
                        php artisan storage:link'
                    """

                    // PASO 3: DEVOLVER LA PROPIEDAD Y PERMISOS (Seguridad)
                    sh """
                        ssh -o StrictHostKeyChecking=no ${WEB_SERVER} 'cd ${PROJECT_PATH} && 
                        sudo chown -R www-data:www-data storage bootstrap/cache && 
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