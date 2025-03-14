<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->pageTitle ?? "Default Page Title" ?></title>
</head>
<body>
    <header>
        <nav>
            <!-- Navigation menu for secured user -->
        </nav>
    </header>
    <div class="main-content">
        <?= $this->content ?>
    </div>
    <footer>
        <!-- Footer for secured layout -->
    </footer>
</body>
</html>
