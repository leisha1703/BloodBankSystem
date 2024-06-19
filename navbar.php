<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Blood Bank System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item mr-3">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li class="nav-item mr-3">
                    <a class="nav-link" href="#">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                </li>
                <li class="nav-item mr-3">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item mr-3">
                    <a class="nav-link" href="hlogin.php">Hospital Login</a>
                </li>
                <li class="nav-item mr-3">
                    <a class="nav-link" href="hregister.php">Hospital Registration</a>
                </li>
                <li class="nav-item mr-3">
                    <a class="nav-link" href="rlogin.php">Receiver Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="rregister.php">Receiver Registration</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
