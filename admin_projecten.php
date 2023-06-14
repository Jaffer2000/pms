<?php include("config/db_config.php");

session_start();
// Als de admin niet is ingelogd verwijzen we door naar de inlogpagina
if (!isset($_SESSION['loggedinadmin'])) {
  header('Location: loginadmin.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Innovision Solutions</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel="stylesheet" href="style.css">

    <script src="https://kit.fontawesome.com/dd43f5ad90.js" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sen:wght@400;700;800&display=swap" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="/img/icon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <div class="schermfoutoverlay">
        <h1>Je bekijkt de PMS in een formaat dat nog niet wordt ondersteund.</h1>
        <p>Schaal je scherm bij of gebruik een ander apparaat om de applicatie te gebruiken.</p>
    </div>

    <div class="app-container">
        <div class="app-header">
            <div class="app-header-left">

                <?php 

$sql = "SELECT * FROM project WHERE project_status!='Afgerond' AND project_status!='Gestopt' ORDER BY projectnaam;";

$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

$sql = "SELECT * FROM `project` WHERE project_status='Bezig';";

$bezig = mysqli_query($conn, $sql);
$resultBezig = mysqli_num_rows($bezig);


$sql = "SELECT * FROM `project` WHERE project_status='Factuur';";

$factuur = mysqli_query($conn, $sql);
$resultFactuur = mysqli_num_rows($factuur);


$sql = "SELECT * FROM `project` WHERE project_status='In Afwachting' OR project_status='On Hold' ORDER BY projectnaam;";

$afwachting = mysqli_query($conn, $sql);
$resultAfwachting = mysqli_num_rows($afwachting);


$sql = "SELECT * FROM `project` WHERE project_status='Wacht op start';";

$wachtopstart = mysqli_query($conn, $sql);
$resultWachtopstart = mysqli_num_rows($wachtopstart);

$sql = "SELECT * FROM `project` WHERE project_status='Initiatie';";

$initiatie = mysqli_query($conn, $sql);
$resultInitiatie = mysqli_num_rows($initiatie);

$sql = "SELECT * FROM `project` WHERE project_status='On Hold';";

$hold = mysqli_query($conn, $sql);
$resultHold = mysqli_num_rows($hold);

$sql = "SELECT * FROM `project` WHERE project_status='Gestopt';";

$gestopt = mysqli_query($conn, $sql);
$resultGestopt = mysqli_num_rows($gestopt);

$sql = "SELECT * FROM `project` WHERE project_status='Afgerond' ORDER BY projectnaam;";

$Afgerond = mysqli_query($conn, $sql);
$resultAfgerond = mysqli_num_rows($Afgerond);

// Zoekresultaat

$searchresult = $_GET['search'] ?? '';

$sql = "SELECT * FROM `project` WHERE `projectnaam` LIKE '%".$searchresult."%' OR `projectleider` LIKE '%".$searchresult."%' OR `klant` LIKE '%".$searchresult."%' OR `projectleden` LIKE '%".$searchresult."%';";

$resultzoekopdracht = mysqli_query($conn, $sql);
$resultNummerZoek = mysqli_num_rows($resultzoekopdracht);

?>

                <svg class="logo"
                    style="fill-rule:nonzero;clip-rule:evenodd;stroke-linecap:round;stroke-linejoin:round;"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1249.04 346.81">
                    <defs />
                    <clipPath id="ArtboardFrame">
                        <rect height="329.98" width="1244.84" x="0" y="0" />
                    </clipPath>
                    <g clip-path="url(#ArtboardFrame)" id="Layer-1" vectornator:layerName="Layer 1">
                        <path
                            d="M223.764 6.91761C218.599 6.97934 214.201 8.63636 214.201 8.63636C214.201 8.63639 172.968 19.8548 109.107 68.0739C72.9605 95.3671-1.15798 155.899 0.0137299 179.636C0.464264 188.766 36.8958 217.671 88.3887 254.886C139.989 292.179 212.045 321.511 212.045 321.511C212.045 321.511 235.345 327.9 239.482 314.761C244.88 297.62 231.545 292.386 231.545 292.386L202.482 278.324C202.483 278.324 241.382 221.685 240.982 164.293C240.583 106.9 200.982 48.7301 200.982 48.7301L231.232 34.9801C231.233 34.9801 245.579 28.3294 238.389 14.8864C234.934 8.42844 228.928 6.85587 223.764 6.91761ZM167.232 69.1676C167.232 69.1676 173.283 72.2978 177.232 78.0739C181.182 83.8499 183.076 92.2613 183.076 92.2614C183.076 92.2614 126.78 129.579 126.576 170.73C126.338 218.811 182.42 248.668 182.42 248.668C182.42 248.668 180.023 253.796 176.795 258.105C173.567 262.415 169.514 265.855 169.514 265.855C169.514 265.855 41.9825 188.794 41.9825 175.043C41.9825 158.009 167.233 69.1676 167.232 69.1676ZM196.107 122.699C196.107 122.699 200.42 133.1 200.42 170.73C200.42 199.326 196.107 218.761 196.107 218.761C196.107 218.761 162.736 194.79 162.701 170.73C162.672 150.566 196.107 122.699 196.107 122.699Z"
                            fill="#ffffff" fill-rule="nonzero" opacity="1" stroke="none" />
                        <path
                            d="M297.542 259.638C295.642 260.445 295.099 261.521 295.642 263.405C302.158 282.777 320.076 289.504 338.81 289.504C360.801 289.504 383.335 280.624 383.335 255.602C383.335 214.435 314.104 231.655 314.104 209.861C314.104 195.87 329.85 192.91 339.896 192.91C349.67 192.91 360.801 195.87 365.96 207.44C367.046 209.054 368.403 209.592 369.76 209.054L380.349 204.749C382.249 203.942 382.792 202.328 381.978 200.982C374.104 181.341 357.815 175.421 339.353 175.421C316.819 175.421 295.913 186.184 295.099 209.861C296.185 251.566 364.602 231.924 364.602 256.14C364.602 269.593 348.312 272.284 338.267 272.284C328.493 272.284 317.09 269.055 311.66 258.023C310.846 256.409 309.488 255.871 307.588 256.14L297.542 259.638ZM453.655 175.426C421.89 175.426 397.186 195.058 397.186 232.458C397.186 269.857 421.89 289.489 453.655 289.489C485.42 289.489 510.124 269.857 510.124 232.458C510.124 195.058 485.42 175.426 453.655 175.426ZM453.655 193.176C477.547 193.176 491.124 208.511 491.124 232.458C491.124 256.404 477.547 271.739 453.655 271.739C429.763 271.739 416.186 256.404 416.186 232.458C416.186 208.511 429.763 193.177 453.655 193.176ZM545.419 158.184C545.419 156.301 544.333 155.225 542.433 155.225L529.401 155.225C527.5 155.225 526.414 156.301 526.414 158.184L526.414 283.315C526.414 285.199 527.5 286.275 529.401 286.275L542.433 286.275C544.333 286.275 545.419 285.199 545.419 283.315L545.419 158.184ZM650.76 235.691C650.76 264.481 631.484 271.745 617.095 271.745C602.705 271.745 583.429 264.481 583.429 235.691L583.429 181.61C583.429 179.726 582.343 178.65 580.442 178.65L567.411 178.65C565.51 178.65 564.424 179.726 564.424 181.61L564.424 235.691C564.424 270.669 586.687 289.504 617.095 289.504C647.502 289.504 669.765 270.669 669.765 235.691L669.765 181.61C669.765 179.726 668.679 178.65 666.779 178.65L653.747 178.65C651.846 178.65 650.76 179.726 650.76 181.61L650.76 235.691ZM729.494 195.87L759.088 195.87C760.988 195.87 762.074 194.794 762.074 192.91L762.074 181.61C762.074 179.726 760.988 178.65 759.088 178.65L729.494 178.65L710.49 178.65L680.896 178.65C678.996 178.65 677.91 179.726 677.91 181.61L677.91 192.91C677.91 194.794 678.996 195.87 680.896 195.87L710.49 195.87L710.49 283.315C710.49 285.199 711.576 286.275 713.476 286.275L726.508 286.275C728.408 286.275 729.494 285.199 729.494 283.315L729.494 195.87ZM793.568 181.61C793.568 179.726 792.482 178.65 790.581 178.65L777.549 178.65C775.649 178.65 774.563 179.726 774.563 181.61L774.563 283.315C774.563 285.199 775.649 286.275 777.549 286.275L790.581 286.275C792.482 286.275 793.568 285.199 793.568 283.315L793.568 181.61ZM865.78 175.426C834.015 175.426 809.311 195.058 809.311 232.458C809.311 269.857 834.015 289.489 865.78 289.489C897.545 289.489 922.249 269.857 922.249 232.458C922.249 195.058 897.545 175.426 865.78 175.426ZM865.78 193.176C889.672 193.176 903.249 208.511 903.249 232.458C903.249 256.404 889.672 271.739 865.78 271.739C841.888 271.739 828.311 256.404 828.311 232.458C828.311 208.511 841.888 193.177 865.78 193.176ZM1022.17 283.315C1022.17 285.199 1023.25 286.275 1025.16 286.275L1038.19 286.275C1040.09 286.275 1041.17 285.199 1041.17 283.315L1041.17 229.234C1041.17 194.256 1018.91 175.421 988.503 175.421C958.095 175.421 935.832 194.256 935.832 229.234L935.832 283.315C935.832 285.199 936.918 286.275 938.819 286.275L951.851 286.275C953.751 286.275 954.837 285.199 954.837 283.315L954.837 229.234C954.837 200.444 974.114 193.179 988.503 193.179C1002.89 193.179 1022.17 200.444 1022.17 229.234L1022.17 283.315ZM1060.18 259.638C1058.28 260.445 1057.73 261.521 1058.28 263.405C1064.79 282.777 1082.71 289.504 1101.45 289.504C1123.44 289.504 1145.97 280.624 1145.97 255.602C1145.97 214.435 1076.74 231.655 1076.74 209.861C1076.74 195.87 1092.49 192.91 1102.53 192.91C1112.31 192.91 1123.44 195.87 1128.6 207.44C1129.68 209.054 1131.04 209.592 1132.4 209.054L1142.98 204.749C1144.89 203.942 1145.43 202.328 1144.61 200.982C1136.74 181.341 1120.45 175.421 1101.99 175.421C1079.45 175.421 1058.55 186.184 1057.73 209.861C1058.82 251.566 1127.24 231.924 1127.24 256.14C1127.24 269.593 1110.95 272.284 1100.9 272.284C1091.13 272.284 1079.73 269.055 1074.3 258.023C1073.48 256.409 1072.12 255.871 1070.22 256.14L1060.18 259.638Z"
                            fill="#ffffff" fill-rule="nonzero" opacity="1" stroke="none" />
                        <path
                            d="M325.955 43.3822C325.955 41.0304 323.864 38.9398 321.512 38.9398L300.084 38.9398C297.732 38.9398 295.642 41.0304 295.642 43.3822L295.642 139.024C295.642 141.376 297.732 143.467 300.084 143.467L321.512 143.467C323.864 143.467 325.955 141.376 325.955 139.024L325.955 43.3822ZM395.71 35.804C366.704 35.804 343.969 53.3123 343.969 88.0675L343.969 139.024C343.969 141.376 346.06 143.467 348.411 143.467L369.839 143.467C372.191 143.467 374.282 141.376 374.282 139.024L374.282 88.0675C374.282 74.7403 380.292 64.8103 395.71 64.8103C410.605 64.8103 417.138 74.7403 417.138 88.0675L417.138 139.024C417.138 141.376 419.228 143.467 421.58 143.467L443.008 143.467C445.36 143.467 447.451 141.376 447.451 139.024L447.451 88.0675C447.451 53.3123 424.716 35.804 395.71 35.804ZM514.07 35.804C485.064 35.804 462.329 53.3123 462.329 88.0675L462.329 139.024C462.329 141.376 464.42 143.467 466.772 143.467L488.2 143.467C490.552 143.467 492.642 141.376 492.642 139.024L492.642 88.0675C492.642 74.7403 498.652 64.8103 514.07 64.8103C528.965 64.8103 535.498 74.7403 535.498 88.0675L535.498 139.024C535.498 141.376 537.589 143.467 539.941 143.467L561.369 143.467C563.721 143.467 565.811 141.376 565.811 139.024L565.811 88.0675C565.811 53.3123 543.076 35.804 514.07 35.804ZM631.647 35.804C600.811 35.804 576.77 54.6189 576.77 91.2033C576.77 127.788 600.811 146.603 631.647 146.603C662.482 146.603 686.523 127.788 686.523 91.2033C686.523 54.6189 662.482 35.804 631.647 35.804ZM631.647 117.596C620.671 117.596 606.821 111.325 606.821 91.2033C606.821 71.0819 620.671 64.8103 631.647 64.8103C642.622 64.8103 656.472 71.0819 656.472 91.2033C656.472 111.325 642.622 117.596 631.647 117.596ZM806.974 43.1209C807.758 41.0304 806.452 38.9398 804.361 38.9398L780.32 38.9398C777.445 38.9398 775.093 40.2464 774.048 43.1209L747.916 105.837L721.785 43.1209C720.739 40.2464 718.388 38.9398 715.513 38.9398L691.472 38.9398C689.381 38.9398 687.813 41.0304 688.859 43.1209L729.624 139.286C730.669 142.16 733.021 143.467 735.896 143.467L759.937 143.467C762.812 143.467 765.163 142.16 766.209 139.286L806.974 43.1209ZM849.291 43.3822C849.291 41.0304 847.201 38.9398 844.849 38.9398L823.421 38.9398C821.069 38.9398 818.978 41.0304 818.978 43.3822L818.978 139.024C818.978 141.376 821.069 143.467 823.421 143.467L844.849 143.467C847.201 143.467 849.291 141.376 849.291 139.024L849.291 43.3822ZM919.308 80.4893C907.548 78.3988 897.618 78.6601 897.618 70.2979C897.618 66.3782 903.106 62.7197 913.297 62.7197C920.353 62.7197 927.931 65.0716 932.112 71.0819C933.68 73.4337 935.771 74.2177 938.123 73.4337L953.802 67.1621C956.154 66.3782 957.46 63.765 956.415 61.4131C948.837 42.5983 929.499 35.0201 912.513 35.804C891.085 36.588 868.351 44.1662 868.351 70.5592C868.351 96.691 892.653 100.349 910.423 103.224C919.83 105.053 928.193 105.837 927.147 112.893C926.363 116.29 921.921 120.471 911.73 120.471C904.674 120.471 897.096 117.858 893.176 112.37C891.869 110.28 889.518 108.712 887.166 109.496L871.487 114.461C869.135 115.245 867.567 117.335 868.351 120.21C874.622 141.899 894.744 146.603 912.513 146.603C933.158 146.603 956.676 135.627 956.676 112.631C957.46 88.8515 935.771 82.5798 919.308 80.4893ZM1006.31 43.3822C1006.31 41.0304 1004.22 38.9398 1001.87 38.9398L980.44 38.9398C978.088 38.9398 975.997 41.0304 975.997 43.3822L975.997 139.024C975.997 141.376 978.088 143.467 980.44 143.467L1001.87 143.467C1004.22 143.467 1006.31 141.376 1006.31 139.024L1006.31 43.3822ZM1073.97 35.804C1043.14 35.804 1019.1 54.6189 1019.1 91.2033C1019.1 127.788 1043.14 146.603 1073.97 146.603C1104.81 146.603 1128.85 127.788 1128.85 91.2033C1128.85 54.6189 1104.81 35.804 1073.97 35.804ZM1073.97 117.596C1063 117.596 1049.15 111.325 1049.15 91.2033C1049.15 71.0819 1063 64.8103 1073.97 64.8103C1084.95 64.8103 1098.8 71.0819 1098.8 91.2033C1098.8 111.325 1084.95 117.596 1073.97 117.596ZM1192.86 35.804C1163.85 35.804 1141.12 53.3123 1141.12 88.0675L1141.12 139.024C1141.12 141.376 1143.21 143.467 1145.56 143.467L1166.99 143.467C1169.34 143.467 1171.43 141.376 1171.43 139.024L1171.43 88.0675C1171.43 74.7403 1177.44 64.8103 1192.86 64.8103C1207.75 64.8103 1214.29 74.7403 1214.29 88.0675L1214.29 139.024C1214.29 141.376 1216.38 143.467 1218.73 143.467L1240.16 143.467C1242.51 143.467 1244.6 141.376 1244.6 139.024L1244.6 88.0675C1244.6 53.3123 1221.86 35.804 1192.86 35.804Z"
                            fill="#ffffff" fill-rule="nonzero" opacity="1" stroke="none" />
                    </g>
                </svg>


                <div class="item-status" style="margin-top:-5px;">
                    <span class="status-type2"> <?php
      echo " <b>" . $datetime . "</b>";?><br>
                        Je bekijkt de <b>Admin Projectpagina</b></span>
                </div>

                <div class="search-wrapper">
                    <form action="" method="GET">
                        <input class="search-input" type="text" placeholder="Zoek in projecten..." name="search"
                            id="search" value="">
                        <button class="button-search" type="submit" name="searchnow"><i
                                class="fas fa-search"></i></button>
                    </form>
                </div>
            </div>

            <div class="app-header-right">

                <?php 
  $persoonlijkepagina = $_SESSION['name'];

    $query = "SELECT * FROM `users` WHERE `username` = '".$persoonlijkepagina."'";
    $rows = mysqli_query($conn, $query);

    while($row = mysqli_fetch_assoc($rows))
    {

      echo'<div class="dropdown" style="float:right;">';
      echo'<div class="headeraccounts">';
      echo'<img src="img/avatar.png" alt="Avatar" class="avatar">';
      echo'<h3> ' , $row["naam"] , '</h3>';
      echo'<p>' , $row["accounttype"] , '</p>';
      echo'</div>';
      echo'<div class="dropdown-content">';
      echo'<p><b>Gebruikersnaam: </b><br>', $row["username"] , '</p>';
      echo'<p><b>Accountcode: </b><br>', $row["id"] , '</p>';
      echo'<p><b>Functie: </b><br>', $row["accounttype"] , '</p><br>';

      echo'<i class="fa-solid fa-user"><a href=""> Account aanpassen</a></i><br><br>';
      echo'<i class="fa-solid fa-right-from-bracket"><a href="logout.php"> Uitloggen</a></i>';
      echo'</div></div>';
    }
  ?>

            </div>

        </div>
        <div class="app-content">
            <div class="app-sidebar">

                <a href="index.php" class="app-sidebar-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-home">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                </a>

                <a href="projects.php" class="app-sidebar-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-folder">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                </a>

                <a href="tickets.php" class="app-sidebar-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-check-square">
                        <polyline points="9 11 12 14 22 4"></polyline>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11">
                        </path>
                    </svg>
                </a>

                <a href="templates.php" class="app-sidebar-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-file">
                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                        <polyline points="13 2 13 9 20 9"></polyline>
                    </svg>
                </a>


                <a href="uitleen_aanvraag_formulier.php" class="app-sidebar-link">
                    <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        class="feather feather-settings" viewBox="0 0 24 24">
                        <defs />
                        <circle cx="12" cy="12" r="3" />
                        <path d="" />
                    </svg>
                </a>
                <a href="admin.php" class="app-sidebar-link">
                    <svg class="link-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        class="feather feather-settings" viewBox="0 0 24 24">
                        <defs />
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z" />
                    </svg>
                </a>


                <a class="mode-switch" title="Switch Theme">
                    <svg class="moon" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" width="24" height="24" viewBox="0 0 24 24">
                        <defs></defs>
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"></path>
                    </svg>
                </a>
            </div>



            <div class="projects-section">
                <div class="projects-section-header">
                    <p>Projecten beheren</p>

                    <div class="newprojectbutton">
                        <a href="admin.php"><button><i class="fas fa-arrow-circle-left"></i> Terug</button></a>
                        <a href="admin.php"><button><i class="fas fa-circle-plus"></i> Toevoegen</button></a>

                    </div>
                </div>
                <div class="projects-section-line">
                    <div class="projects-status">


                        <div class="item-status">
                            <form action="" method="post" class="statusformulier">
                                <div class="status-type"><span class="bezig"
                                        style="background: #E66600"><?php echo $resultInitiatie; ?></span><input
                                        type="submit" class="filterbutton" name="initiatie" value="Initiatie"
                                        style="text-overflow: ellipsis;"><i class="fa-solid fa-arrow-right"
                                        style="color:white; margin-left:6px;"></i></div>
                                <div class="status-type"><span class="bezig"
                                        style="background: #3182B5"><?php echo $resultAfwachting; ?></span><input
                                        type="submit" class="filterbutton" name="afwachting" value="In Afwachting"><i
                                        class="fa-solid fa-arrow-right" style="color:white; margin-left:6px;"></i></div>
                                <div class="status-type"><span class="bezig"
                                        style="background: #00A319;"><?php echo $resultBezig; ?></span><input
                                        type="submit" class="filterbutton" name="bezig" value="Bezig"><i
                                        class="fa-solid fa-arrow-right" style="color:white; margin-left:6px;"></i></div>
                                <!-- <div class="status-type"><span class="bezig" style="background: #B9B9B9"></span><input type="submit" class="filterbutton" name="hold" value="On hold"><i class="fa-solid fa-arrow-right" style="color:white; margin-left:6px;"></i></div> -->
                                <div class="status-type"><span class="bezig"
                                        style="background: #9B59B5"><?php echo $resultFactuur; ?></span><input
                                        type="submit" class="filterbutton" name="factuur" value="Factuur"><i
                                        class="fa-solid fa-arrow-right" style="color:white; margin-left:6px;"></i></div>
                                <div class="status-type" style="margin-right:0px;"><span class="bezig"
                                        style="background: #1D8068"><?php echo $resultAfgerond; ?></span><input
                                        type="submit" class="filterbutton" name="afgerond" value="Afgerond"></div>
                                <div class="status-type"><span class="bezig"
                                        style="background: #FF5F57"><?php echo $resultGestopt; ?></span><input
                                        type="submit" class="filterbutton" name="gestopt" value="Gestopt"></div>
                            </form>
                            <div class="status-type" style="margin-left:10px;"><span class="bezig"
                                    style="background: #FFFFFF"><?php echo $resultCheck; ?></span><a
                                    href="admin_projecten.php" class="filterbutton"><b style="margin-right:5px;"> Totaal
                                        Actief</b></a></div>
                        </div>
                    </div>

                </div>

                <div class="project-boxes jsGridView">
                    <?php

        if (isset($_POST["bezig"])) {
          $result = $bezig;
          $resultCheck = $resultBezig;
        } elseif (isset($_POST["factuur"])) {    
          $result = $factuur;
          $resultCheck = $resultFactuur;
        } elseif (isset($_POST["afwachting"])) {    
          $result = $afwachting;
          $resultCheck = $resultAfwachting;
        } elseif (isset($_POST["wos"])) {    
          $result = $wachtopstart;  
          $resultCheck = $resultWachtopstart;
        } elseif (isset($_POST["initiatie"])) {    
          $result = $initiatie;
          $resultCheck = $resultInitiatie;
        } elseif (isset($_POST["hold"])) {    
          $result = $hold;
          $resultCheck = $resultHold;
        } elseif (isset($_POST["gestopt"])) {    
          $result = $gestopt;
          $resultCheck = $resultGestopt;
        } elseif (isset($_POST["afgerond"])) {    
          $result = $Afgerond;
          $resultCheck = $resultAfgerond;
        } elseif (isset($_POST["software"])) {    
          $result = $software;
          $resultCheck = $resultSoftware;
        } elseif (isset($_POST["media"])) {    
          $result = $media;
          $resultCheck = $resultMedia;
        } elseif (isset($_POST["combinatie"])) {    
          $result = $combinatie;
          $resultCheck = $resultCombinatie;
        } elseif (isset($_POST["wouter"])) {    
          $result = $wouter;
          $resultCheck = $resultWouter;
        } elseif (isset($_POST["sander"])) {    
          $result = $sander;
          $resultCheck = $resultSander;
        } elseif (isset($_POST["vincent"])) {    
          $result = $vincent;
          $resultCheck = $resultVincent;
        } elseif (isset($_POST["gerhard"])) {    
          $result = $gerhard;
          $resultCheck = $resultGerhard;
        } elseif (isset($_POST["jesse"])) {    
          $result = $jesse;
          $resultCheck = $resultJesse;
        } elseif (isset($_GET['search'])) {
          $result = $resultzoekopdracht;
          $resultCheck = $resultNummerZoek;
        } else {
          $result = $result; 
          $resultCheck = $resultCheck;
        }

        if ($resultCheck > 0) {
          while($row = mysqli_fetch_assoc($result)) {

            if ($row['project_status'] == 'Bezig'){
              $barcolor = '#00A319';
              $BGcolor = '#B0DCB8';
              $modalcolor = '#00A319';
            }
            elseif ($row['project_status'] == 'Factuur'){
              $barcolor = '#AC3FAA';
              $BGcolor = '#D99FD8';
              $modalcolor = '#AC3FAA';
            }
            elseif ($row['project_status'] == 'In Afwachting'){
              $barcolor = '#3182B5';
              $BGcolor = '#A7C5DF';
              $modalcolor = '#3182B5';
            }
            elseif ($row['project_status'] == 'Initiatie'){
              $barcolor = '#E66600';
              $BGcolor = '#F8B682';
              $modalcolor = '#E66600';
            }
            elseif ($row['project_status'] == 'On Hold'){
              $barcolor = '#3182B5';
              $BGcolor = '#A7C5DF';
              $modalcolor = '#3182B5';
            }
            elseif ($row['project_status'] == 'Afgerond'){
              $barcolor = '#1D8068';
              $BGcolor = '#A2DBCD';
              $modalcolor = '#1D8068';
            }
            elseif ($row['project_status'] == 'Gestopt'){
              $barcolor = '#FE4A41';
              $BGcolor = '#FFAAA6';
              $modalcolor = '#FE4A41';
            }

            echo'<div class="project-box-wrapper">';
            echo'<div class="project-box" style="background-color: ', $BGcolor ,';">';
            echo'<div class="project-box-content-header" style="color: ', $barcolor ,';">';

            if ($row['project_status'] == 'Afgerond'){
              echo'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svgdone"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"/ style="fill: ',$barcolor,';"></svg>';
            } elseif ($row['project_status'] == 'On Hold'){
              echo'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svgonhold"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M224 0c17.7 0 32 14.3 32 32V62.1l15-15c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9l-49 49v70.3l61.4-35.8 17.7-66.1c3.4-12.8 16.6-20.4 29.4-17s20.4 16.6 17 29.4l-5.2 19.3 23.6-13.8c15.3-8.9 34.9-3.7 43.8 11.5s3.7 34.9-11.5 43.8l-25.3 14.8 21.7 5.8c12.8 3.4 20.4 16.6 17 29.4s-16.6 20.4-29.4 17l-67.7-18.1L287.5 256l60.9 35.5 67.7-18.1c12.8-3.4 26 4.2 29.4 17s-4.2 26-17 29.4l-21.7 5.8 25.3 14.8c15.3 8.9 20.4 28.5 11.5 43.8s-28.5 20.4-43.8 11.5l-23.6-13.8 5.2 19.3c3.4 12.8-4.2 26-17 29.4s-26-4.2-29.4-17l-17.7-66.1L256 311.7v70.3l49 49c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0l-15-15V480c0 17.7-14.3 32-32 32s-32-14.3-32-32V449.9l-15 15c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l49-49V311.7l-61.4 35.8-17.7 66.1c-3.4 12.8-16.6 20.4-29.4 17s-20.4-16.6-17-29.4l5.2-19.3L48.1 395.6c-15.3 8.9-34.9 3.7-43.8-11.5s-3.7-34.9 11.5-43.8l25.3-14.8-21.7-5.8c-12.8-3.4-20.4-16.6-17-29.4s16.6-20.4 29.4-17l67.7 18.1L160.5 256 99.6 220.5 31.9 238.6c-12.8 3.4-26-4.2-29.4-17s4.2-26 17-29.4l21.7-5.8L15.9 171.6C.6 162.7-4.5 143.1 4.4 127.9s28.5-20.4 43.8-11.5l23.6 13.8-5.2-19.3c-3.4-12.8 4.2-26 17-29.4s26 4.2 29.4 17l17.7 66.1L192 200.3V129.9L143 81c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l15 15V32c0-17.7 14.3-32 32-32z"/ style="fill: ',$barcolor,';"></svg>';
            } elseif ($row['prio'] == 'Hoog'){
              echo'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svghogeprio"><!--! Font Awesome Pro 6.2.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. --><path d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512zm0-384c13.3 0 24 10.7 24 24V264c0 13.3-10.7 24-24 24s-24-10.7-24-24V152c0-13.3 10.7-24 24-24zm32 224c0 17.7-14.3 32-32 32s-32-14.3-32-32s14.3-32 32-32s32 14.3 32 32z"/ style="fill: ',$barcolor,';"></svg>';
            }

            echo'<p class="box-content-header" style="font-size: larger; color: ',$barcolor,';"><b>' , $row['projectnaam'] , '</b></p>';
            echo'<p class="box-content-subheader">' , $row['projectleider'] , '</p>';
            echo'</div>';

            echo'<div class="box-progress-wrapper" style="color: ', $barcolor ,';">';
            echo'<p class="box-progress-text"><b>Klant: </b>' , $row['klant'] , '</p>';
            echo'<p class="box-progress-text"><b>Projectcoach: </b>' , $row['projectcoach'] , '</p>';
            echo'<p class="box-progress-text"><b>Type project: </b>' , $row['opleiding'] , '</p><br>';
            echo'<p class="box-progress-text"><b>Projectleden: </b>' , $row['projectleden'] , '</p>';
            echo'<br>';
            echo'</div>';

            echo'<div class="project-box-footer">';
            echo'<div class="statustag" style="background-color: ' , $barcolor , ';">';
            echo $row['project_status'];
            echo '</div>';
            echo'<div class="statustag" style="color: ', $barcolor ,';">';
            echo $row['administratienummer'];
            echo '</div>';
            echo '</div>';

            echo'<details><summary>';
            echo'<div class="buttonmodal" style="color: ', $barcolor ,';">';
            echo'Project bekijken / bewerken <i class="fas fa-chevron-circle-right"></i>';
            echo'</div>';
            echo'<div class="details-modal-overlay"></div>';
            echo'</summary>';

            echo'<div class="details-modal">';
            echo'<div class="details-modal-close">';
            echo'<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">';
            echo'<path fill-rule="evenodd" clip-rule="evenodd" d="M13.7071 1.70711C14.0976 1.31658 14.0976 0.683417 13.7071 0.292893C13.3166 -0.0976311 12.6834 -0.0976311 12.2929 0.292893L7 5.58579L1.70711 0.292893C1.31658 -0.0976311 0.683417 -0.0976311 0.292893 0.292893C-0.0976311 0.683417 -0.0976311 1.31658 0.292893 1.70711L5.58579 7L0.292893 12.2929C-0.0976311 12.6834 -0.0976311 13.3166 0.292893 13.7071C0.683417 14.0976 1.31658 14.0976 1.70711 13.7071L7 8.41421L12.2929 13.7071C12.6834 14.0976 13.3166 14.0976 13.7071 13.7071C14.0976 13.3166 14.0976 12.6834 13.7071 12.2929L8.41421 7L13.7071 1.70711Z" fill="white" />';
            echo'</svg></div><div class="details-modal-title">';
            echo'<form method="POST">';
            echo'<h1><b><input type="text" value="' , $row['projectnaam'] , '" name="projectnaam" class="modalboxinputtitle"></b></h1>';
            echo'<p><b>Projectleider: <input type="text" value="' , $row['projectleider'] , '" name="projectleider" class="modalboxinput"></b></p>';

            echo'<div class="details-modal-bewerkt-door">';
            echo'<p><b>Laatst gewijzigd door: </b>' , $row['bewerkt_door'] , '<br>';
            echo $row['bewerkt_datum'] , '</p>';
            echo'</div>';

            // Select voor de Prioriteit
            echo'<label for="prio"><b>Prioriteit: </b></label>';
            echo'<select id="prio" name="prio">';
            echo'<option value="' , $row['prio'] , '">' , $row['prio'] , '</option>';
            echo'<option value="Laag">Laag</option>';
            echo'<option value="Normaal">Normaal</option>';
            echo'<option value="Hoog">Hoog</option>';
            echo'</select><br>';

            // Select voor de Project status
            echo'<label for="project_status"><b>Project Status: </b></label>';
            echo'<select id="project_status" name="project_status">';
            echo'<option value="' , $row['project_status'] , '">' , $row['project_status'] , '</option>';
            echo'<option value="Bezig">Bezig</option>';
            echo'<option value="Factuur">Factuur</option>';
            echo'<option value="In Afwachting">In Afwachting</option>';
            echo'<option value="Wacht op start">Wacht op start</option>';
            echo'<option value="Initiatie">Initiatie</option>';
            echo'<option value="On Hold">On Hold</option>';
            echo'<option value="Gestopt">Gestopt</option>';
            echo'<option value="Afgerond">Afgerond</option>';
            echo'</select>';

            echo'</div><div class="details-modal-content"><p>';

            echo'<div class="modalboxes">';
            echo'<div class="modalbox">';

            // edit dropdown opleiding
            echo '<label for="opleiding"><br><b>Soort project: </b></label>';
            echo'<select id="opleiding" name="opleiding">';
            echo'<option value="' , $row['opleiding'] , '">' , $row['opleiding'] , '</option>';
            echo'<option value="Software">Software</option>';
            echo'<option value="Media">Media</option>';
            echo'<option value="Media & Software">Media & Software</option>';
            echo'</select><br>';

            echo'<p><b>Klant: </b><input type="text" value="' , $row['klant'] , '" name="klant" class="modalboxinput">';
            echo'<p><b>Projectcoach: </b><input type="text" value="' , $row['projectcoach'] , '" name="projectcoach" class="modalboxinput">';
            echo'<p><b>Telefoonnummer Klant: </b><input type="text" value="' , $row['telefoonnummer'] , '" name="telefoonnummer" class="modalboxinput">';
            echo'<p><b>Email Klant: </b><input type="text" value="' , $row['emailklant'] , '" name="emailklant" class="modalboxinput">';
            echo'<p><b>Projectleden: </b><input type="text" value="' , $row['projectleden'] , '" name="projectleden" class="modalboxinput">';
            echo'<p><b>Initiatieleider: </b><input type="text" value="' , $row['initiatieleider'] , '" name="initiatieleider" class="modalboxinput">';
            echo'<p><b>Projectnummer: </b><input type="text" value="' , $row['administratienummer'] , '" name="administratienummer" class="modalboxinput" maxlength="10" placeholder="EC-2022-00">';
            echo'<input type="hidden" value="' , $row['id'] , '" name="project_id">';
            echo'<input type="hidden" value="' , ucfirst($_SESSION['name']) , '" name="bewerkt_door">';
            echo'<input type="hidden" value="' , $time , '" name="bewerkt_datum">';

            echo'</div>';

            echo'<div class="modalbox">';

            echo'<p style="margin-bottom: 5px;"><b>Opmerkingen & Updates: </b></p>';
            echo'<textarea style="white-space:pre-wrap; width:100%;" class="modalboxinputtxtarea" maxlength="90000" value="' , $row['opmerkingen'] , '" name="opmerkingen">' , $row['opmerkingen'] , '</textarea>';
            echo'<button type="submit" name="update" value="update" class="projectstatusbutton" style="margin-left:5px; float:right;">Opslaan</button>';
            echo'<button type="submit" name="delete" value="delete" class="projectstatusbuttondelete" onclick="return confirm(\'Weet je zeker dat je dit project wilt verwijderen? Druk op OK om te verwijderen.\')"; style="float:right;">Verwijderen</button><br></form>';
            echo'</div>';

            echo'</div></div></div>';

            echo'</div>';
            echo'</div>';
          }
        } else {
          echo'<div class="project-box-wrapper">';
          echo'<h3>Geen projecten gevonden</h3>';
          echo'</div>';
        }
      ?>
                    <?php

        // Project Updaten

      if(isset($_POST['update'])) // als er op de update knop wordt gedrukt
        {
          $project_id = $_POST['project_id'];
          $klant = mysqli_real_escape_string($conn, $_POST['klant']);
          $opleiding = mysqli_real_escape_string($conn, $_POST['opleiding']);
          $prio = mysqli_real_escape_string($conn, $_POST['prio']);
          $project_status = mysqli_real_escape_string($conn, $_POST['project_status']);
          $projectnaam = mysqli_real_escape_string($conn, $_POST['projectnaam']);
          $projectleider = mysqli_real_escape_string($conn, $_POST['projectleider']);
          $projectcoach = mysqli_real_escape_string($conn, $_POST['projectcoach']);
          $telefoonnummer = mysqli_real_escape_string($conn, $_POST['telefoonnummer']);
          $emailklant = mysqli_real_escape_string($conn, $_POST['emailklant']);
          $projectleden = mysqli_real_escape_string($conn, $_POST['projectleden']);
          $initiatieleider = mysqli_real_escape_string($conn, $_POST['initiatieleider']);
          $administratienummer = mysqli_real_escape_string($conn, $_POST['administratienummer']);
          $bewerkt_door = mysqli_real_escape_string($conn, $_POST['bewerkt_door']);
          $bewerkt_datum = mysqli_real_escape_string($conn, $_POST['bewerkt_datum']);
          $opmerkingen = mysqli_real_escape_string($conn, $_POST['opmerkingen']);

          $sql = "UPDATE project SET klant='$klant', opleiding='$opleiding', projectcoach='$projectcoach', telefoonnummer='$telefoonnummer', emailklant='$emailklant', projectleider='$projectleider', projectleden='$projectleden', initiatieleider='$initiatieleider', projectnaam='$projectnaam', opmerkingen='$opmerkingen', project_status='$project_status', prio='$prio', administratienummer='$administratienummer', bewerkt_door='$bewerkt_door', bewerkt_datum='$bewerkt_datum' WHERE project.id = $project_id;";

          if ($conn->query($sql) === TRUE) {
          echo "Uploading your changes to the database...";
          echo "<meta http-equiv='refresh' content='0'>";
          } else {
          echo "We kunnen op dit moment geen verbinding maken met de server. Probeer het later nog een keer."; //<br><br><b>Error:</b><br><br>" . $conn->error;
          }

          $conn->close();
          }

        // Project Verwijderen

        if(isset($_POST['delete'])) // als er op de delete knop wordt gedrukt
        {
          $project_id = $_POST['project_id'];
          $klant = mysqli_real_escape_string($conn, $_POST['klant']);
          $opleiding = mysqli_real_escape_string($conn, $_POST['opleiding']);
          $prio = mysqli_real_escape_string($conn, $_POST['prio']);
          $project_status = mysqli_real_escape_string($conn, $_POST['project_status']);
          $projectnaam = mysqli_real_escape_string($conn, $_POST['projectnaam']);
          $projectleider = mysqli_real_escape_string($conn, $_POST['projectleider']);
          $projectcoach = mysqli_real_escape_string($conn, $_POST['projectcoach']);
          $telefoonnummer = mysqli_real_escape_string($conn, $_POST['telefoonnummer']);
          $emailklant = mysqli_real_escape_string($conn, $_POST['emailklant']);
          $projectleden = mysqli_real_escape_string($conn, $_POST['projectleden']);
          $initiatieleider = mysqli_real_escape_string($conn, $_POST['initiatieleider']);
          $administratienummer = mysqli_real_escape_string($conn, $_POST['administratienummer']);
          $bewerkt_door = mysqli_real_escape_string($conn, $_POST['bewerkt_door']);
          $bewerkt_datum = mysqli_real_escape_string($conn, $_POST['bewerkt_datum']);
          $opmerkingen = mysqli_real_escape_string($conn, $_POST['opmerkingen']);
  
          $sql = "DELETE FROM project WHERE project.id = $project_id;";
      
          if ($conn->query($sql) === TRUE) {
          echo "Project verwijderen...";
          echo "<meta http-equiv='refresh' content='0'>";
          } else {
          echo "We kunnen op dit moment geen verbinding maken met de server. Probeer het later nog een keer."; // <br><b>Error:</b><br>" . $conn->error;
          }
      
          $conn->close();
          }

      ?>
                </div>
            </div>

        </div>
        <!-- partial -->
        <script src="script/script.js"></script>

</body>

</html>