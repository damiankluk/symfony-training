# Symfony training

## Requirements
- GIT
- Docker
- Docksal
## Installation

Follow the steps below to install and run the project:

1. **Clone the repository**
    ```
    git clone git@github.com:damiankluk/symfony-training.git symfony-training
    ```

2. **Navigate to the project directory**
    ```
    cd symfony-training
    ```

3. **Start Docksal**
    ```
    fin project start
    ```
4. **Add project to hosts file**
   ```
   sudo nano /etc/hosts
   ```
   and add this line to the end of a file
   ```
    192.168.64.100 symfony-training.docksal
   ```
   save file 
5. **Install dependencies with Composer**
    ```
    fin composer install
    ```