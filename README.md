# 🛡️ AdventureBoard

A web app where you can create heroes, equip them with weapons, and send them on quests... or create your own to challenge other players!  
Una aplicación web donde puedes crear héroes, equiparlos con armas y enviarlos a completar misiones... ¡o crear las tuyas para desafiar a otros jugadores!

---

## ✅ REQUIREMENTS  
## ✅ REQUISITOS

- MySQL database named: `adventureboard`  
- Base de datos MySQL con el nombre: `adventureboard`

- PHP (recommended to install via [XAMPP](https://www.apachefriends.org/es/index.html))  
- PHP (recomendado instalar con [XAMPP](https://www.apachefriends.org/es/index.html))

- Composer: [https://getcomposer.org/](https://getcomposer.org/)  
- Composer: [https://getcomposer.org/](https://getcomposer.org/)

- Node.js: [https://nodejs.org/](https://nodejs.org/es)  
- Node.js: [https://nodejs.org/es](https://nodejs.org/es)

---

## 🚀 STEPS TO RUN THE PROJECT  
## 🚀 PASOS PARA EJECUTAR EL PROYECTO

1. Clone the repository:  
   1. Clona el repositorio:

   ```bash
   git clone https://github.com/AntonioDavid333/AdventureBoard.git

2. Enter the project folder:
    2. Entra en la carpeta del proyecto:

    cd AdventureBoard

3. Install PHP dependencies with Composer:
    3. Instala las dependencias de PHP con Composer:

    composer install

4. Set up your MySQL credentials in the .env file:
    4. Configura tus credenciales de MySQL en el archivo .env:

    DB_DATABASE=adventureboard
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña

5. Run the migrations and seeders:
    5. Ejecuta las migraciones y seeders:

    php artisan migrate --seed

    This will create the necessary tables and some initial data.
    Esto creará las tablas necesarias y algunos datos iniciales.

6. Install JavaScript dependencies:
    6. Instala las dependencias de JavaScript:

    npm install

7. Start the development server (Vite):
    7. Inicia el servidor de desarrollo (Vite):

    npm run dev

8. In a separate terminal, start the Laravel server:
    8. En otra terminal, inicia el servidor de Laravel:

    php artisan serve

9. Open your browser and visit:
    9. Abre tu navegador y visita:

    http://127.0.0.1:8000


- Now you can use the application to create heroes and equip them with weapons you can purchase in the Weapons Market. You can also create quests with rewards so that other users, along with their heroes, can apply to your quest until you choose a winner.
Similarly, you can try to win quests with your own heroes and, along the way, earn loot and level up. Adventure calls!

    - Ahora puedes usar la aplicación para crear héroes y equiparlos con armas que puedes comprar en el Mercado de Armas. También puedes crear misiones con recompensas para que otros usuarios, junto con sus héroes, se postulen a tu misión hasta que elijas un ganador.
    De forma similar, puedes intentar ganar misiones con tus propios héroes y, de paso, obtener botín y subir de nivel. ¡La aventura te llama!