В рамках тестового задания необходимо создать простое PHP-приложение для работы с расписанием в небольшой вымышленной онлайн-школе языков.

База данных содержит следующую информацию:
Курсы (Английский язык, Испанский язык)
Учителя (ФИО, что преподает)
Ученики (ФИО, телефон, почта)
Расписание занятий

Задание:
Данные курсов, учителей, учеников в бд должны быть добавлены с помощью миграции.
Создать CRUD модели с использованием геттеров и сеттеров для быстрого получения данных из таблиц
Сделать страницу добавления ученика в расписание. При этом:
Сделать проверку о невозможности добавить учеников на одно и тоже время по расписанию. 
Сделать проверку о невозможности выбрать преподавателя повторно на одинаковое время (если он уже занят на другой курс)
Занятия могут проводиться с 9 утра до 18 часов ежедневно. Стандартная длительность занятия 1 час - для этого используется константа. При желании (необязательно) можно реализовать функционал, который учитывает, что занятия проводятся только по будням.
На главной странице вывести общее расписание в виде таблиц по каждому курсу на ближайшую неделю: кто с кем занимается и в какое время

Итог выполнения тестового:
Рабочее приложение на чистом PHP с двумя страницами: общая страница расписания и добавление занятия (внешний вид любой, можно использовать бутстрап)
Ссылка на GitHub веб-приложения
Файл дампа базы данных
Скринкаст экрана, где вы показываете как работает ваше приложение
