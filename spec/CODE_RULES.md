# Соглашения по коду (Code Style)

## 1. Общие правила
- Строгое следование **PSR-12**
- Автоматическая проверка через `./vendor/bin/phpcs`
- Автоматическое исправление через `./vendor/bin/phpcbf`

## 2. Именование
| Элемент | Стиль | Пример |
|---------|-------|--------|
| Классы | PascalCase | `StrategyController` |
| Методы | camelCase | `getStrategies()` |
| Переменные | camelCase | `$activeStrategy` |
| Свойства | camelCase | `$this->strategyName` |
| Константы | UPPER_SNAKE_CASE | `MAX_STRATEGIES` |
| Таблицы БД | snake_case (множественное) | `strategies` |
| Поля БД | snake_case | `is_active` |

## 3. Структура классов
### 3.1. Порядок в классе
```php
class StrategyController extends Controller
{
    // 1. Константы
    private const MAX_STRATEGIES = 100;

    // 2. Свойства (protected/private)
    private StrategyService $service;

    // 3. Конструктор
    public function __construct(StrategyService $service)
    {
        $this->service = $service;
    }

    // 4. Публичные методы
    public function index(): JsonResponse
    {
        // ...
    }

    // 5. Protected методы
    protected function formatResponse(array $data): array
    {
        // ...
    }

    // 6. Private методы
    private function validateStrategy(array $data): bool
    {
        // ...
    }
}
```

## 4. Документирование (DocBlocks)

### 4.1. Порядок в классе
Сложные места в коде помечай комментариями
```php
// Рекурсивный обход дерева стратегий
// $depth ограничивает глубину для избежания бесконечного цикла
private function traverseTree(array $node, int $depth = 0): array
```

### 4.2. Type hints (строго)
```php
// ✅ Правильно
public function calculate(int $a, float $b): array

// ❌ Неправильно
public function calculate($a, $b)
```

## 5. Запрещено (будет отклонено на ревью)
- dd(), var_dump(), print_r() в коде
- Закомментированный код
- Сырые SQL запросы (DB::raw())
- Логика в контроллерах
- Магические числа без констант
- Игнорирование ошибок (@ подавление)
- Длинные методы (>120 строк)
- Сложные условия без пояснений

## 6. Проверка перед коммитом (проверяй сам)
- PHP CodeSniffer `./vendor/bin/phpcs --standard=PSR12 app/`
- PHPStan (статический анализ) `./vendor/bin/phpstan analyse app/`
- Тесты `php artisan test`
