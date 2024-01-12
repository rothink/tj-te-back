# Passo a passo back - report

- Clonar repositório
  >
        git clone https://github.com/rothink/tj-te-back.git


- Entrar no repositório clonado
  >
        cd tj-te-back


- Subir os serviços com docker
  >
        docker-compose up --build -d


- Install migration
  >
        docker exec -it test_back php artisan migrate:fresh  --seed

- Executar os testes
  >
        docker exec -it test_back php artisan test

        
