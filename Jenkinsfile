pipeline {
    agent any // El pipeline principal corre en el agente por defecto

    stages {
        stage('Checkout') {
            steps {
                echo 'Limpiando y clonando el repositorio...'
                cleanWs()
                git branch: 'Master', url: 'https://github.com/LucaseDallAgnese/Proyecto_Integrador.git'
            }
        }

        stage('Build Assets') {
            // --- ¡AQUÍ ESTÁ LA MAGIA! ---
            // Esta etapa se ejecutará dentro de un contenedor "node:18-alpine"
            agent {
                docker { image 'node:18-alpine' }
            }
            // -----------------------------
            steps {
                echo 'Instalando dependencias de Node.js y construyendo assets...'
                sh 'npm install --force'
                // Probablemente también quieras construir los assets, ¿verdad?
                // sh 'npm run build' 
            }
        }

        stage('Deploy') {
            // Esta etapa volverá a usar el agente 'any' (el principal)
            steps {
                echo 'Iniciando despliegue...'
                // Tus pasos de despliegue van aquí...
            }
        }

        // ...Tus otras etapas...
    }
    
    post {
        // ...
    }
}