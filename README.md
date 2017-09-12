# PHP - Ajax CSV Importer
**Ajax CSV Importer** is a powerfull tool to import csv into a database (or anything else), it executes the csv **line by line**, and allows the user watch the progress. The output of each iteration is added to the console.

Code
----

You'll need to change the fields:

```php
// Set fields
$fields = ['id', 'a', 'b', 'c'];
```

So then you'll be able to access fields as variables:

```php
$result = $mysqli->query("UPDATE test SET data = $a WHERE id = $id");
```

Screenshots
----

![Screenshot 01](https://raw.githubusercontent.com/promatik/PHP-Ajax-CSV-Importer/master/screen01.png)

![Screenshot 02](https://raw.githubusercontent.com/promatik/PHP-Ajax-CSV-Importer/master/screen02.png)

License
----

MIT

