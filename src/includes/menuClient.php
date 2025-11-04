<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
nav{
    display: flex;
    justify-content: space-around;
    width: 100%;
    padding: 10px;
    position: fixed;
    bottom: 0;
    left: 0;
}

nav .icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    cursor: pointer;
}

nav a {
    color: #888888;
    text-decoration: none;
}
</style>
</head>
<body>
    <nav>
        <a href="admin.php">
          <div class="icon">
            <img src="../../src/assets/category.png" alt="">
            <p>Dashboard</p>
          </div>
        </a>
        <a href="#">
          <div class="icon">
            <img src="../../src/assets/message.png" alt="">
            <p>Mensagens</p>
          </div>
        </a>
        <a href="#">
            <div class="icon">
                <img src="../../src/assets/" alt="">
                <p>Conta</p>
            </div>
        </a>
        <a href="../../pages/auth/logout.php">
          <div class="icon">
            <img src="../../src/assets/logout.png" alt="">
            <p>Logout</p>
          </div>
        </a>
    </nav>
</body>
</html>