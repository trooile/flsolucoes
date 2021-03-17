<html lang="pt">

    <nav class="navbar navbar-expand-lg sticky-top navbar-fixed-top">
        
        <div id="sidenav" class="sidenav">
            <a href="/main/about.php">About</a>
            <a href="/main/services.php">Services</a>
            <a href="/main/contact.php">Contact</a>
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        </div>

        <button class="btn btn-mdb-color" role="button" style="font-size:25px ;cursor:pointer; color:#FFFFFF" onclick="openNav()"><span class="glyphicon glyphicon-menu-hamburger"></span></button>

        <div class="container-fluid">
        <!-- <a class="navbar-brand" href="../index.php"><img src="/../images/logo.png" class="w-20 p-3"></a> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav me-auto  mb-5 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="../index.php" aria-disabled="true">
                    Home
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/../tutorials/tutorials.php" tabindex="-1" aria-disabled="true">
                    Tutorials
                </a>
            </li>
            </ul>
            <li class="nav-item dropdown justify-content-right">
                <a class="nav-link dropdown-toggle" id="account-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Account
                </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="nav-item" style="color:#000033" href="/../account/create-account-step1.php">
                    New Account
                </a>
                <a class="nav-item" style="color:#000033" href="/../account/login.php">
                    Login
                </a>
            </div>
            </li>
        </div>
        </div>
    </nav>

</html>

<script>

    function openNav() {
        document.getElementById("sidenav").style.width = "150px";
    }

    function closeNav() {
        document.getElementById("sidenav").style.width = "0";
    }

</script>