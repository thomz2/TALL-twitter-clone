<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo"></a></p>

<div align="center">   
    <h1>X.md</h1>
    <h3>Twitter/X Clone using the TALL stack</h3>
    <p color="gray">Tailwind, Alpine.JS, Laravel, Livewire</p>
</div>

Tabela de conteúdos
=================
<!--ts-->
   * [Deploy](#🌐%20Deploy%20usando%20docker-compose%20em%20uma%20instância%20EC2%20da%20AWS)
   * [Tabela de Conteudo](#tabela-de-conteudo)
   * [Instalação](#instalacao)
   * [Como usar](#como-usar)
      * [Pre Requisitos](#pre-requisitos)
      * [Local files](#local-files)
      * [Remote files](#remote-files)
      * [Multiple files](#multiple-files)
      * [Combo](#combo)
   * [Tests](#testes)
   * [Tecnologias](#tecnologias)
<!--te-->

## 🌐 Deploy usando docker-compose em uma instância EC2 da AWS

### Instância EC2
- Primeiramente criaremos uma instância EC2 com a imagem ubuntu server:<br>![image](https://github.com/thomz2/tall-twitter-clone/assets/82160387/ba9edce1-c492-45fe-88e3-fcad88039959)
- Após isso, nas configurações de rede, devemos permitir os tráfegos e clicar em editar (no primeiro passo, o tráfego ssh e http devem estar ativados):<br>![image](https://github.com/thomz2/tall-twitter-clone/assets/82160387/7c10da2a-85a0-464b-b720-305c69b3b933)
- E por fim adicionar mais regras de tráfego para conseguirmos acessar o MinIO após o deploy:<br>![image](https://github.com/thomz2/tall-twitter-clone/assets/82160387/4f4bddc5-fd68-48e3-96b7-6363680e0863)
- A instância está pronta para ser executada.
- É necessário também a criação de uma tabela no DynamoDB e um usuário no IAM (não conseguimos acessar o DynamoDB através da conta academy).

### DynamoDB
- Criaremos apenas uma tabela para armazenar os logs de CRUD e na criação o nome e a chave de partição devem ser as seguintes:<br>![image](https://github.com/thomz2/tall-twitter-clone/assets/82160387/c16c8c55-8acc-4ba0-b0ec-70a920654db6)
- Os nomes devem ser esses pois por simplicidade, colocamos os mesmos no [código fonte da aplicação](https://github.com/thomz2/tall-twitter-clone/blob/docker-compose/app/Observers/UserObserver.php)

### IAM
- Por simplicidade, criaremos um usuário no IAM com acesso total ao DynamoDB:<br>![image](https://github.com/thomz2/tall-twitter-clone/assets/82160387/f52293e6-bea2-4f62-84e7-15e165b3ff3a)

### Instalando coisas na maquina
- Após a execução da instância, entraremos na máquina e faremos a instalação do que é necessário para executar o projeto.
- ##### Docker Engine
    - [Seguiremos o passo a passo oficial para a instalação do docker.](https://docs.docker.com/engine/install/ubuntu/)
    - Esse primeiro comando irá remover possíveis pacotes conflitantes da máquina, colocamos ele aqui apenas por desencargo de consciência, visto que pode ser considerado um comando pulável já que a máquina está vazia.
	    - `for pkg in docker.io docker-doc docker-compose docker-compose-v2 podman-docker containerd runc; do sudo apt-get remove $pkg; done`
    - Após isso, setaremos o repositório apt do docker:
    	- ```# Add Docker's official GPG key:
    		sudo apt-get update
    		sudo apt-get install ca-certificates curl
    		sudo install -m 0755 -d /etc/apt/keyrings
    		sudo curl -fsSL https://download.docker.com/linux/ubuntu/gpg -o /etc/apt/keyrings/docker.asc
    		sudo chmod a+r /etc/apt/keyrings/docker.asc
    		
    		# Add the repository to Apt sources:
    		echo \
    		  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/ubuntu \
    		  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
    		  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
    		sudo apt-get update 
            ```
    - E instalamos os pacotes do mesmo:
	    - ```sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin```
	- Teste: `sudo docker run hello-world` 
- ##### Docker Compose
	- Instalação: `sudo apt-get install docker-compose-plugin`
- ##### Git
	- Instalação: `sudo apt-get install git`
	
### Depois de instalar
- Após a instalação dos recursos necessários, faremos um clone do repositório do projeto e editaremos o ambiente dele através do nano:
    - ```
         git clone -b docker-compose https://github.com/thomz2/tall-twitter-clone.git
         cd tall-twitter-clone/
         cp .env.example .env
         nano .env
      ```
- Colocaremos as credenciais da AWS para funcionamento do DynamoDB:<br>![Pasted image 20240524192522](https://github.com/thomz2/tall-twitter-clone/assets/82160387/a9342ffb-8952-407b-9eda-8e546ab6802f)
- As credenciais do MinIO e do MySQL já estão definidas com base no [docker-compose.yml](https://github.com/thomz2/tall-twitter-clone/blob/docker-compose/docker-compose.yml).
- Agora buildaremos e subiremos nossos containers:
    - `sudo docker compose up --build -d`
    - Obs.: os serviços podem estar rodando mas a configuração total só é feita quando o container `php_commands` termina sua execução.

### Configurando MinIO através de sua interface web
- Primeiramente, vamos acessar o painel do MinIO através da web, para isso, devemos acessar o link: `http://<ip_publico_instancia>:9004/login`:<br>![image](https://github.com/thomz2/tall-twitter-clone/assets/82160387/5b7dda55-9a30-4a68-9222-0e0a2ba8211d)
- Após isso, basta colocar o login e senha definidos no [docker-compose.yml](https://github.com/thomz2/tall-twitter-clone/blob/docker-compose/docker-compose.yml) e se autenticar.
- Por fim, tornaremos o nosso bucket padrão (que também já foi definido no [docker-compose.yml](https://github.com/thomz2/tall-twitter-clone/blob/docker-compose/docker-compose.yml)) público:<br>![image](https://github.com/thomz2/tall-twitter-clone/assets/82160387/9f9bed84-6f8e-40ce-9cb4-8d359169c00d)

### E assim, a aplicação está pronta para ser usada! Basta acessar o ip público da instância ou seu dns público.

## 📌 Todo

- [x] user auth<br>
- [x] user config<br>
- [x] search input<br>
- [x] likes logic<br>
- [x] profile page<br>
- [x] mobile responsivity<br>
- [x] followers logic<br>
- [x] better UI<br>
- [x] Dockerfile and docker-compose<br>
- [x] MINIO storage<br>
- [x] AWS EC2 docker-compose deploy (explanation in portuguese)<br>
- [x] AWS non-relational database for crud logs (DynamoDB)<br>
- [ ] Kubernetes based deploy (**INCOMPLETE**)<br>
- [ ] Terraform (**NOT DONE**)
