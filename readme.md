## Мое тестовое задание для компании МТС

Старался сделать все максимально кратко без лишнего кода. Чисто "описал идею". Скрипт не допсан и по хорошему его еще тестировать и писать.

Основные действия происходят в App\Http\Controllers\PaymentController.php - там я старался придерживаться некоторых правил написания кода (частично SOLID) и соблюдал правило Single Responsibilty, а также разбил все действия по методам, да бы не захломять основной метод.

Модель для работы UserPayment я немного доработал - данные инициализируются в контроллере, а все действия происходят через метод ->savePayment() (исправил, так как ->save производит сохрранение в базу).

UserWallet модифицирован не был. Он может в будущем использоваться для получения статистики по платежам, для отката платежей и так далее.

Никаких релейшенов не делал, хотя мог. В целом, если нужно описать идею, то данные действия будут лишними.

Внутри также имеются миграции для необходимых таблиц (user_wallets и user_payments). При желании можно запустить их.

Роуты не создавал.

Спасибо за интересное тестовое задание :)
