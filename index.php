<?php
session_start();
if (empty($_SESSION['success'])) {
    header('Location: /login.php');
    exit();
}

echo "<head>
    <link rel=\"stylesheet\" href=\"bootstrap.css\">
</head>";

echo '<h2  align="center" style="color: #ff245c">Практика №5. </h2><br/><br/>';
//
//define('HOST', 'localhost');//константа
//define('USER', 'root');//константа
//define('PASSWORD', '');//константа
//define('DATABASE', 'phploc');//константа
//
//
//$connect = mysqli_connect(HOST, USER, PASSWORD, DATABASE);
require_once('config.php');
/**
 * *Если нет таблицы создать ее
 * если есть
 * @param $connect
 * @return bool
 */
function createTable($connect)
{

    $sql = "CREATE TABLE users (user_id int(11) NOT NULL, user_name varchar(255) NOT NULL, password varchar(255) NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

    $sql2 = "ALTER TABLE users ADD PRIMARY KEY (user_id);";

    $sql3 = "ALTER TABLE users MODIFY user_id int(11) NOT NULL AUTO_INCREMENT;";

    if (mysqli_query($connect, $sql)) {
        mysqli_query($connect, $sql2);
        mysqli_query($connect, $sql3);
        return true;
    } else {
        echo "table exist";
        return false;
    }
}


/**
 * забить базу тестовыми данными
 * @param $connect
 *
 *
 * @param $count
 * количество тестовых записей
 *
 * @param bool $trunc
 * стереть все что было и заново наполнить тестовыми
 */
function autoGenerateRows($connect, $count, $trunc = false)
{
    //очистить содержимое таблицы перед вставкой
    if ($trunc) {
        $sql2 = "TRUNCATE TABLE users";
        mysqli_query($connect, $sql2);
    }

    for ($i = 1; $i <= $count; $i++) {
        $sql = "INSERT INTO users SET user_name='Login" . $i . "',password ='pass" . $i . "'";
        mysqli_query($connect, $sql);
    }

}

/**
 * (просто стало интересно как проверить)
 * проверяем есть ли такая таблица в БД
 * @param $connect
 * @param string $searchtable
 * имя таблицы которую ищем
 * @return bool
 */
function table_exist($connect, $searchtable = 'users')
{
    $sql = "SHOW TABLES FROM phploc like '" . $searchtable . "';";
    $result = mysqli_query($connect, $sql);

    while ($res[] = mysqli_fetch_assoc($result)) {
        $row = $res;
    }
    if (!empty($row)) {
        return true;
    }
    return false;
}


/**
 *
 * берем данные из таблицы
 * @param $connect
 * @param $page
 * @param $per_page
 * @return array
 */
function getArrayFromTable($connect, $page, $per_page)
{
    $begin = ($page - 1) * $per_page;

    $sql = "SELECT * FROM news LIMIT {$begin},{$per_page}"; //ASC

    $query = mysqli_query($connect, $sql);
    while ($res[] = mysqli_fetch_assoc($query)) {
        $news = $res;
    }

    return $news;
}


/**
 * @param $connect
 * @param string $name
 * @return mixed
 */
function getCountRows($connect, $name = 'news')
{

    $query1 = "SELECT COUNT(*) AS kol from {$name}";

    $res = mysqli_fetch_assoc(mysqli_query($connect, $query1));
    return $res['kol'];
}


/*Проверяем есть ли такая таблица,
 если нет то создаем таблицу users c полями user_id ->pK/autoincrement ,user_name,password
 и забиваем туда 100 тестовых записей
*/
//if (!table_exist($connect)) {
//    createTable($connect);
//    autoGenerateRows($connect, 100);
//}


$per_page = empty($_GET['per-page']) ? 15 : $_GET['per-page'];

$last_page = ceil(getCountRows($connect) / $per_page);

$page = empty($_GET['page']) || $_GET['page'] > $last_page ? 1 : $_GET['page'];


$requestArray = getArrayFromTable($connect, $page, $per_page);

if (!empty($requestArray)) {
    $head_table = array_keys($requestArray[0]);
}

?>
<div class="text-right">
    <?php
    if ($_SESSION['role'] == 'admin') {
        echo "<a href=\"cabinet.php\">В кабинет</a>";
    }
    ?>


    <a href="checkIn.php">выйти</a>
</div>
<div>
    <table style="width: 100%" class="table-bordered">
        <thead>

        <?php

        if (!empty($head_table)) {
            foreach ($head_table as $name) {
                echo "<th>$name</th>";
            }
        }

        ?>

        </thead>

        <tbody>
        <?php
        if (!empty($requestArray)) {
            foreach ($requestArray as $value) {
                echo "<tr>";
                foreach ($value as $key => $value) {
                    if ($key == 'news_id') {
                        echo "<td><a href='newsedit.php?news_id=" . $value . "'>edit</a></td>";
                    } else {
                        echo "<td>" . $value . "</td>";
                    }
                }
                echo "</tr>";
            }
        }
        ?>
        </tbody>

    </table>


</div>


<div>
    <ul class="pagination">
        <li class="prev">
            <a href="/index.php?page=1&amp;per-page=15" data-page="1">
                <span>first</span>
            </a>
        </li>
        <li class="prev <?= ($page - 1) > 0 ? '1' : 'disabled' ?>">

            <a href="/index.php?page=<?= ($page - 1) > 0 ? ($page - 1) : '1   ' ?>&amp;per-page=15"
               data-page="<?= ($page - 1) > 0 ? ($page - 1) : '1' ?>">
                <span>&laquo</span>
            </a>

        </li>

        <?php

        for ($i = $page - 2; $i <= $page + 2; $i++) {
            if ($i >= 1 && $i <= $last_page) {
                if ($i == $page) {
                    echo '<li class="active">
                        <a href="/index.php?page=' . $i . '&amp;per-page=' . $per_page . '" data-page="' . $i . '">' . $i . '</a>
                      </li>';
                } else {
                    echo '<li>
                        <a href="/index.php?page=' . $i . '&amp;per-page=' . $per_page . '" data-page="' . $i . '">' . $i . '</a>
                      </li>';
                }
            }
        }

        ?>
        <li class="next <?= ($page + 1) <= $last_page ? '' : 'disabled' ?>">
            <a href="/index.php?page=<?= ($page + 1) <= $last_page ? $page + 1 : $last_page ?>&amp;per-page=15"
               data-page="1">
                &raquo
            </a>
        </li>
        <li class="next">
            <a href="/index.php?page=<?= !empty($last_page) ? $last_page : 1 ?>&amp;per-page=15"
               data-page="9">
                last
            </a>
        </li>
    </ul>
</div>



