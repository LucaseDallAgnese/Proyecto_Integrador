// Jenkinsfile
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
    stage('Checkout') {
        steps {
            echo "Clonando el repositorio..."
            cleanWs() 
            git branch: 'Master', credentialsId: GIT_CREDENTIAL_ID, url: GIT_REPO_URL
        }
    }
    
    stage('Build Assets') {
        steps {
            echo "Instalando dependencias de Node.js y construyendo assets..."
            sh '/bin/bash -c "npm install --force"' 
            sh '/bin/bash -c "npm run build"'
        }
    }

    stage('Deploy') {
        steps {
            echo "Sincronizando archivos con el servidor web..."
            sshagent([WEB_SERVER_CREDENTIAL_ID]) {
                // Sincroniza todo con rsync
                sh "rsync -avz -e 'ssh -o StrictHostKeyChecking=no' --exclude='.git/' --exclude='node_modules/' --exclude='resources/' ./ ${WEB_SERVER}:${PROJECT_PATH}/"
            }
        }
    }

    // Etapa 4: Comandos finales (Remoto en el servidor web)
    stage('Post-Deploy') {
        steps {
            echo "Ejecutando comandos finales en el servidor web..."
            sshagent([WEB_SERVER_CREDENTIAL_ID]) {
                
                // ✨ PASO 1: PERMISOS TEMPORALES (Permite a Composer escribir)
                // Le da permiso 777 (escritura total) al usuario actual (ubuntu) antes de Composer.
                sh """
                    ssh -o StrictHostKeyChecking=no ${WEB_SERVER} 'cd ${PROJECT_PATH} && \\
                    sudo chmod -R 777 storage bootstrap/cache'
                """
                
                // ✨ PASO 2: COMANDOS DE LARAVEL (Ejecuta composer y genera la caché)
                sh """
                    ssh -o StrictHostKeyChecking=no ${WEB_SERVER} 'cd ${PROJECT_PATH} && \\
                    composer install --no-dev --optimize-autoloader && \\
                    php artisan config:cache && \\
                    php artisan route:cache && \\
                    php artisan view:cache && \\
                    php artisan migrate --force && \\
                    php artisan storage:link'
                """

                // ✨ PASO 3: DEVOLVER LA PROPIEDAD Y PERMISOS (Seguridad)
                // Devuelve la propiedad y permisos a www-data (el usuario del servidor web).
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