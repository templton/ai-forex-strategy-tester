# Текущая задача: Реализовать методы получения и обновления стратегии (GET /api/v1/strategies/{id}, PUT /api/v1/strategies/{id})

## Метаданные
- **Ветка**: feature/strategy-crud

## Ограничения для экономии токенов
- НЕ анализируй существующие файлы, если это не указано явно
- НЕ ищи примеры реализации в других контроллерах/сервисах
- Следуй строго описанию в этом документе
- Создавай минимальный код, без избыточных комментариев

## Ключевые требования (из правил)
- Ответ всегда в формате: {"success": true, "data": {}, "message": "OK", "errors": []}
- Бизнес-логика в сервисах, контроллеры только вызывают
- Валидация через Form Request
- Репозитории покрыты интерфейсами (суффикс Interface)
- DTO для передачи данных между слоями
- Тесты для каждого нового метода

## Структура (напоминание)
- Интерфейс репозитория: app/Contracts/Repository/Strategy/StrategyRepositoryInterface.php
- Репозиторий: app/Repository/Strategy/StrategyRepository.php
- DTO: app/Contracts/Repository/Strategy/Dto/StrategyDto.php, app/Contracts/Repository/Strategy/Dto/CreateStrategyDto.php
- DTO для обновления: app/Contracts/Repository/Strategy/Dto/UpdateStrategyDto.php
- Сервис: app/Services/StrategyService.php
- Маппер: app/Mappers/StrategyMapper.php
- Контроллер: app/Http/Controllers/Api/V1/StrategyController.php
- Form Request: app/Http/Requests/Strategy/StrategyUpdateRequest.php

---

## Пошаговое выполнение (СИНХРОННЫЙ РЕЖИМ)

### Шаг 1: Метод получения стратегии (GET)
- [ ] Добавить в StrategyRepositoryInterface.php метод find(int $id): ?Strategy
- [ ] Реализовать метод в StrategyRepository.php
- [ ] Добавить в StrategyService.php метод getStrategy(int $id): StrategyDto
    - Если стратегия не найдена → выбросить исключение ModelNotFoundException
- [ ] Добавить в StrategyController.php метод show(int $id): JsonResponse
    - Вызвать сервис
    - Вернуть ответ 200 OK с DTO в поле data
- [ ] Добавить роут в routes/api.php: GET /api/v1/strategies/{id}

**Критерии приёмки:**
- [ ] При существующей стратегии — 200 с данными
- [ ] При несуществующей — 404 с сообщением

➡️ **После выполнения шага:**
1. Отметить выполненные пункты
2. НЕ КОММИТИТЬ
3. ОСТАНОВИТЬСЯ и показать результат
4. Вывести статистику (файлы, строки кода)

**После моего подтверждения:**
- ✅ Если всё ок → коммит feat: add GET strategy endpoint
- 🔄 Если нужны правки → исправить

---

### Шаг 2: Метод обновления стратегии (PUT)
- [ ] Создать Form Request StrategyUpdateRequest.php
    - Правила: description (sometimes, string), parameters (sometimes, array)
- [ ] Создать UpdateStrategyDto.php (readonly) в app/Contracts/Repository/Strategy/Dto/
    - Поля: description (string, nullable), parameters (array, nullable)
- [ ] Добавить в StrategyRepositoryInterface.php метод update(Strategy $strategy, array $data): Strategy
- [ ] Реализовать метод в StrategyRepository.php
- [ ] Добавить в StrategyService.php метод updateStrategy(int $id, UpdateStrategyDto $dto): StrategyDto
    - Найти стратегию (если нет → исключение)
    - Обновить через репозиторий
    - Увеличить version на 1
    - Вернуть DTO
- [ ] Добавить в StrategyController.php метод update(StrategyUpdateRequest $request, int $id): JsonResponse
    - Из $request->validated() создать UpdateStrategyDto
    - Вызвать сервис
    - Вернуть ответ 200 OK с обновлённой стратегией
- [ ] Добавить роут в routes/api.php: PUT /api/v1/strategies/{id}

**Критерии приёмки:**
- [ ] При обновлении существующей стратегии — 200 с обновлёнными данными
- [ ] version увеличивается на 1
- [ ] При несуществующей — 404
- [ ] При пустом запросе — возвращается текущая стратегия (без изменений)

➡️ **После выполнения шага:**
1. Отметить выполненные пункты
2. НЕ КОММИТИТЬ
3. ОСТАНОВИТЬСЯ и показать результат
4. Вывести статистику (файлы, строки кода)

**После моего подтверждения:**
- ✅ Если всё ок → коммит feat: add PUT strategy endpoint
- 🔄 Если нужны правки → исправить

---

### Шаг 3: Тесты
- [ ] Добавить в tests/Feature/Api/Strategy/StrategyTest.php:
    - test_can_get_strategy() — успешное получение
    - test_get_nonexistent_strategy_returns_404() — 404 при отсутствии
    - test_can_update_strategy() — успешное обновление
    - test_update_nonexistent_strategy_returns_404() — 404 при обновлении отсутствующей
    - test_update_with_partial_data() — обновление только части полей
    - test_version_increments_on_update() — проверка увеличения версии

**Критерии приёмки:**
- [ ] Все тесты проходят
- [ ] Покрытие ключевых сценариев

➡️ **После выполнения шага:**
1. Отметить выполненные пункты
2. НЕ КОММИТИТЬ
3. ОСТАНОВИТЬСЯ и показать результат
4. Вывести статистику (файлы, строки кода)

**После моего подтверждения:**
- ✅ Если всё ок → коммит test: add tests for GET and PUT strategy endpoints
- 🔄 Если нужны правки → исправить

---

## Финальный чеклист
- [ ] Все 3 шага выполнены и подтверждены
- [ ] Задача отмечена в TASKS.md как ✅

## Статистика выполнения (заполняется агентом после каждого шага)
После завершения каждого шага добавь в этот раздел:

### Шаг N
- Создано/изменено файлов: X
- Добавлено строк кода: Y
- Выполнено пунктов: Z/Z
- Потрачено токенов (оценка): ~N