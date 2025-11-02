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
                        
                        # ✨ REINICIO FINAL: Usamos 'service' para mayor compatibilidad de shell ✨
                        sudo service php8.2-fpm restart && 
                        sudo service nginx restart &&
                        
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

### 2. Tarea Manual Final (Si Aún Falla)

Si este *pipeline* falla de nuevo con "Unit not found" o "Failed to restart", la **única solución** es que el *driver* de MySQL sea cargado manualmente en tu EC2:

**Opción de Falla del Driver:**
1.  **Conéctate a tu EC2.**
2.  **Reinicia el servidor EC2 completo** (ya que el `systemctl` está roto y un reinicio completo fuerza la carga de los *drivers*).
    ```bash
    sudo reboot
    
