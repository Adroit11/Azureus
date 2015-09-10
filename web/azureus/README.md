azureus
=======

A Symfony project created on April 21, 2015, 7:36 pm.

###Conf

Install Composer - tick the shell menu option. Will be easier later: https://getcomposer.org/doc/00-intro.md#using-the-installer
Go to /web/azureus right click and click Composer Install or use composer install command in terminal (?)

## Instrukcja dla Patisona

1. Zainstaluj WAMP, XAMPP lub coś podobnego.
2. Stwórz baze danych o nazwie symfony
3. Ściągnij Composer. Masz tam wyżej link XD. Przy instalacji bedzie coś do zaznaczenia ze słowem shell. Zaznacz to.
4. Jak ci się zainstaluje composer i masz gita to sklonuj projekt sobie do twojego folderu od xamppa albo wamp cokolwiek masz.
5. Wejdz w folder Azureus/web/azureus. Kliknij prawym przyciskiem w folderze i wybierz Composer install lub uzyj komendy w konsoli composer install
6 Tam bedzie kilka pol do wypelnienia w tym skrypcie ale wszystkie zostaw domyslne. No chyba ze masz baze pod innym adresem niz 127.0.0.1 XD wiem ze nie masz :P
6. Jak juz ci sie skonczy instalowac projekt to w konsoli bedac w folderze Azureus/web/azureus w konsoli wpisz komende:
```php app/console doctrine:schema:update --force```
7. Wchodzisz pod link localhost/Azureus/web/azureus/web/app_dev.php 
