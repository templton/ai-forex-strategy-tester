# Текущая задача: Создать API для сохранения стратегии (POST /api/v1/strategies)

## Ограничения для экономии токенов
- НЕ анализируй существующие файлы, если это не указано явно
- НЕ ищи примеры реализации в других контроллерах/сервисах
- Следуй строго описанию в этом документе
- Создавай минимальный код, без избыточных комментариев

## Контекст (файлы доступны по запросу)
- `ARCHITECTURE.md` — структура проекта
- `API.md` — формат ответов API
- `CODE_RULES.md` — стиль кода

## Ключевые требования (из правил)
- Формат ответа (используй без поиска примеров):
  ```json
  {
    "success": true,
    "data": {...},
    "message": "Strategy created successfully",
    "errors": []
  }
- Бизнес-логика в сервисах, контроллеры только вызывают
- Валидация через Form Request
- Репозитории покрыты интерфейсами (суффикс `Interface`)
- DTO для передачи данных между слоями
- Тесты для каждого нового метода
- Все интерфейсы хранятся в папке app/Contracts. Потом вложенная папка Repository - для репозиториев.
  Далее вложенная папка с именем репозитория (`Strategy`) и уже в ней сам интерфейс репозитория
- В папке с интерфейсом лежат DTO, которыми этот интерфейс оперирует (вложенная папка Dto)
- Репозитории хранятся по такой структуре (репозитория для таблицы `Strategy`) `app/Repository/Strategy/StrategyRepository.php`
- Аналогично папка с сервисами (пример для сервиса с именем `Strategy`) `app/Services/StrategyService.php`
- Все `Form Request` так же лежат в именованных папках с именем контроллера. Например, для контроллера `StrategyController`
  для метода `store` соответствует класс - `app/Http/Requests/Strategy/StrategyStoreRequest.php` (Request обязательный суффикс именования)

---

### Шаг 1: Модель, миграция, интерфейс репозитория, DTO
- [x] Создать модель `app/Models/Strategy.php`
    - Поля: `id`, `description` (text), `parameters` (json), `version` (integer, default 1), `created_at`, `updated_at`
- [x] Создать миграцию `create_strategies_table`
- [x] Создать `CreateStrategyDto.php` (readonly)
    - Поля: `description` (string), `parameters` (array)
- [x] Создать `StrategyDto.php` (readonly)
    - Поля: `id` (int), `description` (string), `parameters` (array), `version` (int), `createdAt` (string), `updatedAt` (string)
- [x] Запусти миграции
- [x] Создать интерфейс репозитория `StrategyRepositoryInterface.php`
    - Метод `create(CreateStrategyDto $dto): Strategy`
- [x] Создать репозиторий `StrategyRepository.php` (реализует интерфейс)
    - Метод `create(CreateStrategyDto $dto): Strategy` (сохраняет модель, возвращает Eloquent модель)

**Критерии приёмки:**
- [x] Таблица создаётся, поля соответствуют
- [x] DTO имеют корректные типы
- [x] Интерфейс и репозиторий соответствуют контракту

➡️ **После выполнения шага:**
1. Отметить выполненные пункты
2. **НЕ КОММИТИТЬ**
3. ОСТАНОВИТЬСЯ и показать результат

**После моего подтверждения:**
- ✅ Если всё ок → коммит `feat: add Strategy model, migration, repository interface, DTOs and repository`
- 🔄 Если нужны правки → исправить, затем снова показать

---

### Шаг 2: Сервис и маппер
- [x] Создать маппер `app/Mappers/StrategyMapper.php`
    - Метод `toDto(Strategy $model): StrategyDto` (преобразует модель в DTO)
- [x] Создать сервис `StrategyService.php`
    - Конструктор принимает `StrategyRepositoryInterface`
    - Метод `createStrategy(CreateStrategyDto $dto): StrategyDto`
        - Вызывает репозиторий → получает модель
        - Маппит модель в `StrategyDto`
        - Возвращает DTO

**Критерии приёмки:**
- [x] Маппер правильно преобразует модель в DTO
- [x] Сервис вызывает репозиторий и возвращает DTO
- [x] В конструктор сервиса передаётся интерфейс (DI)

➡️ **После выполнения шага:**
1. Отметить выполненные пункты
2. **НЕ КОММИТИТЬ**
3. ОСТАНОВИТЬСЯ и показать результат

**После моего подтверждения:**
- ✅ Если всё ок → коммит `feat: add StrategyMapper and StrategyService`
- 🔄 Если нужны правки → исправить

---

### Шаг 3: Контроллер, роутинг, валидация
- [x] Создать Form Request `StrategyStoreRequest.php`
    - Правила: `description` (required, string), `parameters` (required, array)
- [x] Создать контроллер `app/Http/Controllers/Api/V1/StrategyController.php`
    - Конструктор принимает `StrategyService`
    - Метод `store(StrategyStoreRequest $request): JsonResponse`
        - Из `$request->validated()` создаёт `CreateStrategyDto`
        - Вызывает `$this->service->createStrategy($dto)`
        - Возвращает ответ в формате API (201 Created)
- [x] Добавить роут в `routes/api.php`: `POST /api/v1/strategies`

**Критерии приёмки:**
- [x] При запросе с неверными данными — 422 с ошибками
- [x] При корректном запросе — 201 Created с данными стратегии в формате API

➡️ **После выполнения шага:**
1. Отметить выполненные пункты
2. **НЕ КОММИТИТЬ**
3. ОСТАНОВИТЬСЯ и показать результат

**После моего подтверждения:**
- ✅ Если всё ок → коммит `feat: add StrategyController with store endpoint and validation`
- 🔄 Если нужны правки → исправить

---

### Шаг 4: Тесты
- [x] Создать `tests/Feature/Api/Strategy/StrategyTest.php`
- [x] Тест: `test_can_create_strategy()` — успешное создание, проверка структуры ответа
- [x] Тест: `test_validation_fails()` — проверка обязательных полей

**Критерии приёмки:**
- [x] Тесты проходят
- [x] Покрытие ключевых сценариев

➡️ **После выполнения шага:**
1. Отметить выполненные пункты
2. **НЕ КОММИТИТЬ**
3. ОСТАНОВИТЬСЯ и показать результат

**После моего подтверждения:**
- ✅ Если всё ок → коммит `test: add tests for strategy creation`
- 🔄 Если нужны правки → исправить

---

**Важно:** Не читай существующие файлы для поиска примеров. Вся необходимая структура описана выше.doc

Примечение. Из статистики курсора: Выполнено 10 запросов. Количество токенов ~ 2млн