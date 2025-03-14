<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->pageTitle ?? "Login Page" ?></title>
</head>
<body>
    <header>
        <nav>
            <!-- Navigation menu for logged-out user -->
        </nav>
    </header>
    <div class="main-content">
        <?= $this->content ?>
    </div>
    <footer>
        <!-- Footer for public layout -->
    </footer>
</body>
</html>
