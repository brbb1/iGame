# iGame
    Приложение для розыгрыша призов

## Допущения
1. Авторизация максимально простая
2. Пароли хранятся в незащищенном виде
3. Middleware в стандартном виде не дают доступа к параметрам uri, 
поэтому проверка доступности в хендлерах
4. Нет логирования
5. На тестах я здался :)

## Запуск
1. Создать ```.env``` файл с локальными переменными, за основу можно взять ```.env.dist```
2. Запустить команду ```docker-compose up -d```
3. Запустить ```docker exec igame-app composer install```
4. Запуск нагрузочного тестирования
    ```ab -n 10000 -c 150 -H 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VySWQiOjF9.-aZ-fmWj6R_sG58mKbGaDiUijHH26sOupSsajQ7q548' -m POST http://localhost:8090/v1/game/draws/1/prizes```
5. Запуск команды по отправке денег ```docker exec -it igame-app apps/igame/bin/console count```, где ```count``` количество обрабатываемых записей за раз
6. Url для подключения к базе ```jdbc:mysql://localhost:3306/igame```
    

## Описание*
1. Доступные роуты:
    ```
   POST /v1/oauth/authorize - получение роута по имени и паролю, 
       параметры {"username": "user1", "password": "pass1"}
   GET /v1/game/players - получение информации игрока
   GET /v1/game/draws - получение доступных розыгрышей игрока
   POST /v1/game/draws/{id}/prizes - получить приз в рамках розыгрыша,
       если есть доступные попытки
   GET /v1/game/draws/{id}/prizes - призы в рамках одного розыгрыша
   PATCH v1/game/prizes/{type}/{id} - обновление статуса приза, 
       type бывает трех видов (money, object, points), 
       тело запроса {"status": "{status}"}, 
       статус бывает двух типов: replaced - замена на очки и declined - отказ
   ```
2. Структура проекта:
    ```
   iGame
    |-- apps - driving adapters
    |-- src
        |--IGame - domen
    |-- etc - config
   ```
3. Схема бд, сам файл с начальными данными в папке /etc/database
![img.png](img.png)
4. Основная логика находится в классах PrizeCreator и PrizeStatusChanger