<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo"></a></p>

<div align="center">   
    <h1>X.md</h1>
    <h3>Twitter/X Clone using the TALL stack</h3>
    <p color="gray">Tailwind, Alpine.JS, Laravel, Livewire</p>
</div>

## Deploy usando docker-compose em uma instância EC2 da AWS


### Instância EC2

- Adicionar regras de entrada no grupo de segurança da instância, para assim acessar o MinIO:
	- ![Pasted image 20240524194451](https://github.com/thomz2/tall-twitter-clone/assets/82160387/daed0f07-d881-4423-a049-6df39411ab5d)
### Instalando coisas na maquina
- ##### Docker Engine
	- `for pkg in docker.io docker-doc docker-compose docker-compose-v2 podman-docker containerd runc; do sudo apt-get remove $pkg; done`
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
		# ```
	- ```sudo apt-get install docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin```
	- Teste: `sudo docker run hello-world`
- ##### Docker Compose
	- ```
	sudo apt-get update
	sudo apt-get install docker-compose-plugin
			# ```
- ##### Git
	- `sudo apt-get install git`
	
### Depois de instalar
- `git clone -b docker-compose https://github.com/thomz2/tall-twitter-clone.git`
- `cd tall-twitter-clone/`
- `cp .env.example .env`
- `nano .env`
	- Colocar credenciais da AWS para funcionamento do DynamoDB: ![Pasted image 20240524192522](https://github.com/thomz2/tall-twitter-clone/assets/82160387/a9342ffb-8952-407b-9eda-8e546ab6802f)
	- As credenciais do MinIO já estão definidas com base no docker-compose.yaml
- `sudo docker compose up --build -d`
- `sudo docker compose exec app composer install`
- `sudo docker compose exec app php artisan key:generate`
- `sudo docker compose exec app php artisan migrate`
	- se não der certo: `sudo docker compose exec app php artisan migrate:fresh`
- `sudo docker compose exec app php artisan config:clear`

## Todo

#### [x] user auth<br>
#### [x] user config<br>
#### [x] search input<br>
#### [x] likes logic<br>
#### [x] profile page<br>
#### [x] mobile responsivity<br>
#### [x] followers logic<br>
#### [x] better UI<br>
#### [x] Dockerfile and docker-compose<br>
#### [x] MINIO storage<br>
#### [x] AWS EC2 docker-compose deploy (markdown explaining in portuguese)<br>
#### [x] AWS non-relational database for crud logs (DynamoDB)<br>
#### [ ] Kubernetes based deploy<br>
