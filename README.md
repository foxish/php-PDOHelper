php-PDOHelper
=============

Base classes for all PDO-operations

For people switching from the deprecated set of mysql_* functions to the PDO set.
    database.base.php is the base-class which implements different functions.
    utilities.php contains some common functions which might be of use elsewhere as well (very generic)
    database.test.php tests the above functionality

**Step 1: Create the helper object**

    $dbObj = new SqlDatabaseHelper('database_name', 'hostname','username', 'password', 'database_protocol');

All fields are self-explanatory. database_protocol is "mysql" for mysql databases. The supported drivers can be checked using [PDO::getAvailableDrivers](http://www.php.net/manual/en/pdo.getavailabledrivers.php).

**Step 2: Use the `query()` method**

    $dbObj->query('SELECT * FROM status', Array('')); //no parameters, so empty array
    $dbObj->query('INSERT INTO status VALUES(?, ?, ?, ?...)', Array('value1', 'value2', 'value3', 'value4' ...));
    $dbObj->query('DELETE FROM status WHERE id = ?', Array('2'));

**Step 3: Retrieve and iterate through results**

In case of the SELECT statement, 

    $rows = $dbObj->getRows();
    var_dump($rows);

This fetches an associative array of rows returned
There is also `getRow($id)` which returns one row at index $id








Branch: status
A website using the above which implements calls to PDO-base class and insertion of a certain piece of data
