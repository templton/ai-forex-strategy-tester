# Текущая задача: Реализовать GET /api/v1/strategies (пагинация) и DELETE /api/v1/strategies/{id}

## Метаданные
- **Ветка**: feature/strategy-pagination-delete
- **Проект**: api (Laravel)

## Контекст
- Уже реализованы: модель Strategy, миграция, репозиторий, сервис, DTO
- Нужно добавить два эндпоинта для работы фронтенда

## Требования

### GET /api/v1/strategies
- Поддержка пагинации через query параметры:
  - `page` (int, default = 1)
  - `limit` (int, default = 10, max = 100)
- Возвращает JSON в формате:
  {
    "success": true,
    "data": [
      {
        "id": 1,
        "description": "RSI strategy",
        "parameters": {"period": 14, "threshold": 30},
        "version": 1,
        "created_at": "2026-03-24 10:00:00",
        "updated_at": "2026-03-24 10:00:00"
      }
    ],
    "meta": {
      "current_page": 1,
      "last_page": 5,
      "per_page": 10,
      "total": 45
    },
    "message": "OK",
    "errors": []
  }

### DELETE /api/v1/strategies/{id}
- Удаляет стратегию по ID
- Возвращает 204 No Content при успешном удалении
- Если стратегия не найдена → 404 с сообщением
- Если ошибка БД → 500 с сообщением

## Структура (напоминание)
- Интерфейс репозитория: app/Contracts/Repository/Strategy/StrategyRepositoryInterface.php
- Репозиторий: app/Repository/Strategy/StrategyRepository.php
- Сервис: app/Services/StrategyService.php
- Контроллер: app/Http/Controllers/Api/V1/StrategyController.php

## Пошаговое выполнение (СИНХРОННЫЙ РЕЖИМ)

### Шаг 1: Добавить метод getPaginated в репозиторий и сервис
- [x] Добавить в StrategyRepositoryInterface.php метод getPaginated(int $page, int $limit): LengthAwarePaginator
- [x] Реализовать метод в StrategyRepository.php (использовать Eloquent paginate)
- [x] Добавить в StrategyService.php метод getStrategies(int $page, int $limit): array
  - Вызвать репозиторий
  - Преобразовать пагинатор в массив с data + meta
  - Вернуть массив для JSON ответа

**Критерии приёмки:**
- [x] Метод репозитория возвращает LengthAwarePaginator
- [x] Метод сервиса возвращает структуру { data: [], meta: {} }

➡️ **После выполнения шага:**
1. Отметить выполненные пункты
2. НЕ КОММИТИТЬ
3. ОСТАНОВИТЬСЯ и показать результат

**После моего подтверждения:**
- ✅ Если всё ок → коммит feat: add paginated method to StrategyRepository and StrategyService
- 🔄 Если нужны правки → исправить

---

### Шаг 2: Добавить метод delete в репозиторий и сервис
- [x] Добавить в StrategyRepositoryInterface.php метод delete(int $id): bool
- [x] Реализовать метод в StrategyRepository.php
- [x] Добавить в StrategyService.php метод deleteStrategy(int $id): void
  - Найти стратегию (если нет → исключение ModelNotFoundException)
  - Вызвать репозиторий для удаления
  - Вернуть void

**Критерии приёмки:**
- [x] Метод репозитория возвращает true/false
- [x] Метод сервиса выбрасывает исключение при отсутствии стратегии

➡️ **После выполнения шага:**
1. Отметить выполненные пункты
2. НЕ КОММИТИТЬ
3. ОСТАНОВИТЬСЯ и показать результат

**После моего подтверждения:**
- ✅ Если всё ок → коммит feat: add delete method to StrategyRepository and StrategyService
- 🔄 Если нужны правки → исправить

---

### Шаг 3: Добавить контроллеры и маршруты
- [x] Добавить в StrategyController.php метод index(Request $request): JsonResponse
  - Получить page и limit из запроса (default: page=1, limit=10)
  - Вызвать $this->service->getStrategies($page, $limit)
  - Вернуть успешный ответ с data и meta
- [x] Добавить в StrategyController.php метод destroy(int $id): JsonResponse
  - Вызвать $this->service->deleteStrategy($id)
  - Вернуть ответ 204 (без тела)
  - Обработать ModelNotFoundException → 404
- [x] Добавить роуты в routes/api.php:
  - GET /api/v1/strategies → StrategyController@index
  - DELETE /api/v1/strategies/{id} → StrategyController@destroy

**Критерии приёмки:**
- [x] GET /api/v1/strategies?page=1&limit=10 возвращает пагинированный список
- [x] DELETE /api/v1/strategies/1 удаляет стратегию и возвращает 204
- [x] DELETE с несуществующим id возвращает 404

➡️ **После выполнения шага:**
1. Отметить выполненные пункты
2. НЕ КОММИТИТЬ
3. ОСТАНОВИТЬСЯ и показать результат

**После моего подтверждения:**
- ✅ Если всё ок → коммит feat: add GET and DELETE endpoints for strategies
- 🔄 Если нужны правки → исправить

---

### Шаг 4: Обновить тесты
- [x] Добавить тесты в tests/Feature/Api/Strategy/StrategyTest.php:
  - test_can_get_paginated_strategies() — проверка структуры ответа
  - test_can_delete_strategy() — проверка удаления
  - test_delete_nonexistent_strategy_returns_404() — проверка ошибки

**Критерии приёмки:**
- [x] Все тесты проходят

➡️ **После выполнения шага:**
1. Отметить выполненные пункты
2. НЕ КОММИТИТЬ
3. ОСТАНОВИТЬСЯ и показать результат

**После моего подтверждения:**
- ✅ Если всё ок → коммит test: add tests for paginated list and delete
- 🔄 Если нужны правки → исправить

---

## Финальный чеклист
- [x] GET /api/v1/strategies работает с пагинацией
- [x] DELETE /api/v1/strategies/{id} работает
- [x] Тесты проходят
- [x] Swagger обновлён (если используется)

## Статистика выполнения (заполняется агентом после каждого шага)
После завершения каждого шага добавь в этот раздел:

### Шаг 1
- Создано/изменено файлов: 3
- Добавлено строк кода: 56
- Выполнено пунктов: 5/5
- Потрачено токенов (оценка): ~1400

### Шаг 2
- Создано/изменено файлов: 3
- Добавлено строк кода: 16
- Выполнено пунктов: 5/5
- Потрачено токенов (оценка): ~900

### Шаг 3
- Создано/изменено файлов: 2
- Добавлено строк кода: 42
- Выполнено пунктов: 6/6
- Потрачено токенов (оценка): ~1200

### Шаг 4
- Создано/изменено файлов: 1
- Добавлено строк кода: 71
- Выполнено пунктов: 2/2
- Потрачено токенов (оценка): ~1000