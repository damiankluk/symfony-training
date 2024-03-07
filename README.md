# Symfony training

## Requirements
- Makefile
- Docker
## Installation

Follow the steps below to install and run the project:

1. **Clone the repository**
    ```
    git clone git@github.com:damiankluk/symfony-training.git symfony-training
    ```
   
2. **Go to the project directory**
    ```
    cd symfony-training
    ```
   
3. **Build docker containers**
    ```
    make build
    ```
   
4. **Set containers up**
    ```
    make up
    ```
5. **Install composer dependencies**
    ```
    make composer-install
    ```
5. **Go to the web app**
    ```
    localhost:80
    ```