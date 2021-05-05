<?php
    try
    {
        $connection = new PDO('pgsql:host=localhost;port=5432;user=postgres;dbname=task2_db');
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }

    function add_to_db($xml_text)
    {
        global $connection;
        foreach($xml_text->books as $xml)
        {
            $query = $connection->prepare("INSERT INTO books (name, author, pagecount, country) 
                VALUES ('$xml->name', '$xml->author', '$xml->pagecount','$xml->country')");
            try
            {
                $query->execute();
                echo "Данные записаны".PHP_EOL;
            }
            catch(PDOException $e)
            {
                echo $e->getMessage().PHP_EOL;
            }
        }
       get_db();
    }
    function get_db()
    {
        global $connection;
        $query = $connection->prepare('SELECT name, author,pagecount,country from books');
        try
        {
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            $json_data = json_encode($result);
            file_put_contents('output.json',$json_data);
        }
        catch (PDOException $e)
        {
            echo $e->getMessage().PHP_EOL;
        }
    }
?>