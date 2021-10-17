## Форма отправки комментариев
### Технологии :
- PHP 8.0
- HTML5
- CSS3
- JavaScript
- MySQL
### Реализовано :
- отправка формы из двух полей с данными
- проверка на заполненность полей
- сохранение введённых данных в БД
- вывод данных в виде комментариев с датами на страницу
- каждый новый комментарий находится вверху
- оповещения после попытки отправки формы, зависящие от результата :
    - "Запись успешно сохранена!" - при успешном сохранении данных (с голубой стилизацией блока оповещения)
    - "Слишком длинное сообщение!" - при отправке комментария, превышающего допустимое максимальное количество символов (с красной стилизацией блока оповещения)
    - "Заполните пустые поля!" - при попытке отправки пустой формы (с красной стилизацией блока оповещения)
- пагинация с подсветкой текущей страницы, а так же переходом назад\вперед и первую\последнюю страницу комментариев
- защита адресной строки от лишних символов в номере страницы
- автопереход на 1 страницу если в адресной строке вручную была указана в 0, на последнюю страницу, если вручную была указана выше последней
### Планируемые дополнения после изучения необходимых технологий :
- добавить счётчик оставшихся для ввода сообщения символов в textarea
- поработать над защитой при вводе некорректных символов в адресную строку
- реализовать отправку формы по нажатию Enter
