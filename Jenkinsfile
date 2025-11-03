pipeline {
    agent any // Corre todo en el agente principal de Jenkins (donde está Docker)

    stages {
        stage('Checkout') {
            steps {
                echo 'Clonando repositorio...'
                cleanWs() // Limpia el espacio de trabajo anterior
                git branch: 'Master', url: 'https://github.com/LucaseDallAgnese/Proyecto_Integrador.git'
            }
        }

        stage('Build & Deploy') {
            steps {
                echo '1. Construyendo assets (JS/CSS)...'
                // Esto corre 'npm install' DENTRO de un contenedor node,
                // pero los archivos los guarda en el workspace actual de Jenkins.
                docker.image('node:18-alpine').inside {
                    sh 'npm install --force'
                    // Probablemente también necesites construir tus assets:
                    // sh 'npm run build' 
                }

                echo '2. Levantando la aplicación con Docker Compose...'
                // Ahora que los assets existen, levantamos los servicios.
                // -d = detached (en segundo plano)
                // --build = Reconstruye tus imágenes (ej. 'app') si el Dockerfile cambió
                sh 'docker-compose up -d --build'
            }
        }
    }

    post {
        always {
            echo 'Pipeline finalizado.'
        }
    }
}