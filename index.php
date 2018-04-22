<h1>THÊM MỘT TIN TỨC MỚI</h1>
<form action="" method="post">
    <table>
        <tr>
            <th>Tiêu đề:</th>
            <td><input type="text" name="title" value=""></td>
        </tr>

        <tr>
            <th>Ngày tháng:</th>
            <td><input type="date" name="date" value=""></td>
        </tr>

        <tr>
            <th>Mô tả:</th>
            <td><input type="text" name="description" value=""></td>
        </tr>

        <tr>
            <th>Nội dung:</th>
            <td><textarea cols="30" rows="7" name="content"></textarea></td>
        </tr>
    </table>
    <button type="submit">Gửi</button>
</form>
<?php
$username = "root"; // Khai báo username
$password = "123456";      // Khai báo password
$server   = "localhost:3306";   // Khai báo server
$dbname   = "tintuc";      // Khai báo database

// Kết nối database tintuc
$connect = new mysqli($server, $username, $password, $dbname);

//Nếu kết nối bị lỗi thì xuất báo lỗi và thoát.
if ($connect->connect_error) {
    die("Không kết nối :" . $conn->connect_error);
    exit();
}

//Khai báo giá trị ban đầu, nếu không có thì khi chưa submit câu lệnh insert sẽ báo lỗi
$title = "";
$date = "";
$description = "";
$content = "";

//Lấy giá trị POST từ form vừa submit
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    if(isset($_POST["title"])) { $title = $_POST['title']; }
    if(isset($_POST["date"])) { $date = $_POST['date']; }
    if(isset($_POST["description"])) { $description = $_POST['description']; }
    if(isset($_POST["content"])) { $content = $_POST['content']; }

    //Code xử lý, insert dữ liệu vào table
    $sql = "INSERT INTO tin_xahoi (title, date, description, content)
    VALUES ('$title', '$date', '$description', '$content')";

    if ($connect->query($sql) === TRUE) {
        echo "DỮ LIỆU TIN TỨC ĐƯỢC THÊM THÀNH CÔNG: </br>";
        $sql = "SELECT title, date, description, content FROM tin_xahoi ORDER BY id DESC LIMIT 1";
        $result = $connect->query($sql);
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "Title: " . $row["title"]. " -Date: " . $row["date"]. " -Description: " . $row["description"] ." -Content: " . $row["content"]. "<br>";
                    }
        } else {
            echo "0 results";
        }
        $connect->close();
    } else {
        echo "Error: " . $sql . "<br>" . $connect->error;
        $connect->close();
    }
    // Kết nối database tintuc
    $connect = new mysqli($server, $username, $password, $dbname);

    //Nếu kết nối bị lỗi thì xuất báo lỗi và thoát.
    if ($connect->connect_error) {
        die("Không kết nối :" . $connect->connect_error);
        exit();
    }

    //Code xử lý, insert dữ liệu vào table
    $sql    = "SELECT * FROM tin_xahoi ORDER BY id DESC";
    $ket_qua = $connect->query($sql);

    //Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
    if (!$ket_qua) {
        die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
        exit();
    }
    echo "<hr>";
    //Dùng vòng lặp while truy xuất các phần tử trong table
    while ($row = $ket_qua->fetch_array(MYSQLI_ASSOC)) {
        echo "<p>ID: " . $row['id'] . "</p>";
        echo "<p>Tiêu đề: " . $row['title'] . "</p>";
        echo "<p>Ngày: " . $row['date'] . "</p>";
        echo "<p>Mô tả: " . $row['description'] . "</p>";
        echo "<p>Nội dung: " . $row['content'] . "</p>";
        echo "<hr>";
    }
}
?>

