# Правила разработки API

## API Routing
[Здесь задаем API маршрутизацию](../src/routes/api.php)

## Контроллеры
- Все API контроллеры находятся в директории src/app/Http/Controllers/Api/V1
- Каждый контроллер должен наследоваться от App\Http\Controllers\Controller
- Именования контроллеров {Имя контроллера}ApiController.php

## Формат ответа

```json
{
  "success": true,
  "message": "API is working properly",
  "data": {}
}
```

`success` - успешность запроса, boolean
`message` - служебное сообщение
`data` - ответ метода

## Генерация API документации
Вызвать консольную команду (обновить swagger) `php artisan docs:generate`