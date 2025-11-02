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
                    sh """
                        ssh -o StrictHostKeyChecking=no ${WEB_SERVER} 'cd ${PROJECT_PATH} && 
                        
                        # REINICIO MANUAL NECESARIO: Estas líneas solo sirven si el servicio existe.
                        sudo systemctl restart php8.2-fpm.service || true && 
                        sudo systemctl restart nginx.service || true &&
                        
                        # COMANDOS CORE DE LARAVEL
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
```

## 🚀 Plan de Cierre (¡Ahora!)

1.  **Sube este `Jenkinsfile` a GitHub.**
2.  **¡Reinicia tu EC2!** Es la forma más rápida de cargar el *driver* de MySQL.
    ```bash
    sudo reboot
    
