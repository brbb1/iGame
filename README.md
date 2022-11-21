# iGame
    Приложение для розыгрыша призов

## Допущения
1. Авторизация максимально простая
2. Пароли храняться в незащищенном виде
3. Middleware в стандартном виде не дают доступа к параметрам uri, 
поэтому проверка доступности в хендлерах
4. Нет логирования

## Запуск
1. Создать .env файл с локальными переменными, за основу можно взять .env.dist
2. Запустить команду docker-compose up -d


## Описание*
1. ab -n 10000 -c 200 -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VySWQiOjF9.-aZ-fmWj6R_sG58mKbGaDiUijHH26sOupSsajQ7q548' -m POST http://localhost:8090/v1/game/draws/1/prizes

