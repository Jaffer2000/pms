<?php require_once("config/db_config.php");
require_once("model/UitleenAanvraag.php");
require_once("model/User.php");

$status = $_GET["status"];

session_start();
// Als de admin niet is ingelogd verwijzen we door naar de inlogpagina
if (!isset($_SESSION['loggedinadmin'])) {
  header('Location: loginadmin.php');
  exit;
}

if ($_POST != NULL) {
    $aanvraag = new UitleenAanvraag();
    if ($_POST['action'] == 'Goedkeuren') {
        $aanvraag->approveAanvraag($_POST['aanvraag_id']);
    }
    if ($_POST['action'] == 'Afkeuren') {
        $aanvraag->disapproveAanvraag($_POST['aanvraag_id']);
    }
    if ($_POST['action'] == 'Ingeleverd') {
        $aanvraag->setProductsHandedIn($_POST['aanvraag_id']);
    }
}

// Handle delete action
if (isset($_POST['action']) && $_POST['action'] == 'Verwijderen') {
    // Retrieve request ID from the form
    $aanvraagId = $_POST['aanvraag_id'];
 
    // Perform the deletion in the database
    $query = "DELETE FROM aanvragen WHERE aanvraag_id = $aanvraagId";
    $result = mysqli_query($conn, $query);
 
    // Check for errors
    if (!$result) {
        echo "Error deleting the request: " . mysqli_error($conn);
        // You may want to handle the error gracefully or redirect back to the page with an error message
    } else {
        // Redirect to the request summary page after successful deletion
        header("Location: uitleen_admin_aanvragen_overzicht.php?status=$status&page=$page");
        exit();
    }
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
    <div class="app-container">
        <div class="app-header">
            <div class="app-header-left">

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
                        Je bekijkt het <b>Uitleensysteem aanvragen overzicht</b></span>
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
                    <p>Aanvragen overzicht</p>
                    <div>
                        <?php 
                    // Check if a filter option was submitted
                    if(isset($_GET['status'])) {
                        $selectedStatus = $_GET['status'];
                        $_SESSION['selected_status'] = $selectedStatus; // Store the selected status in a session variable
                    } else {
                        // If no filter option submitted, check if there's a previously selected status in the session
                        if(isset($_SESSION['selected_status'])) {
                            $selectedStatus = $_SESSION['selected_status'];
                        } else {
                            // Default value if no filter option is selected or stored in the session
                            $selectedStatus = 'all';
                        }
                    }

                    $sql = "SELECT * FROM `aanvragen` WHERE status='0';"; // Nog beoordelen

                    $nogbeoordelen = mysqli_query($conn, $sql);
                    $resultnogbeoordelen = mysqli_num_rows($nogbeoordelen);

                    $sql = "SELECT * FROM `aanvragen` WHERE status='1';"; // Goedgekeurd

                    $goedgekeurd = mysqli_query($conn, $sql);
                    $resultgoedgekeurd = mysqli_num_rows($goedgekeurd);

                    $sql = "SELECT * FROM `aanvragen` WHERE status='2';"; // Ingeleverd

                    $ingeleverd = mysqli_query($conn, $sql);
                    $resultingeleverd = mysqli_num_rows($ingeleverd);

                    $sql = "SELECT * FROM `aanvragen` WHERE status='3';"; // Afgekeurd

                    $afgekeurd = mysqli_query($conn, $sql);
                    $resultafgekeurd = mysqli_num_rows($afgekeurd);

                    $sql = "SELECT * FROM `aanvragen`"; // alle

                    $alle = mysqli_query($conn, $sql);
                    $resultalle = mysqli_num_rows($alle);
                    ?>

                        <!-- <p>
                        <form action="uitleen_admin_aanvragen_overzicht.php" method="get" class="status-filter-form">
                            <label for="status-filter">Filter op status:</label>
                            <select name="status" id="status-filter">
                                <option class="filteropties" value="all"
                                    <?php if($selectedStatus == 'all') echo 'selected'; ?>>Alle</option>
                                <option class="filteropties" value="0"
                                    <?php if($selectedStatus == '0') echo 'selected'; ?>>Nog beoordelen</option>
                                <option class="filteropties" value="1"
                                    <?php if($selectedStatus == '1') echo 'selected'; ?>>Goedgekeurd</option>
                                <option class="filteropties" value="3"
                                    <?php if($selectedStatus == '3') echo 'selected'; ?>>Afgekeurd</option>
                                <option class="filteropties" value="2"
                                    <?php if($selectedStatus == '2') echo 'selected'; ?>>Ingeleverd</option>
                            </select>
                            <button type="submit">Filteren</button>
                        </form>
                        </p> -->
                    </div>
                    <div class="newprojectbutton">
                        <a href="uitleen_admin_producten.php"><button> Naar product beheer</button></a>
                        <a href="admin.php"><button><i class="fas fa-arrow-circle-left"></i> Terug naar admin
                                portaal</button></a>
                    </div>

                </div>

                <div class="projects-section-line">
                    <div class="projects-status">


                        <div class="item-status">
                            <form action="" method="post" class="statusformulier statusformaanvragen">
                                
                                <div class="status-type"><span class="nogbeoordelen"
                                        ><?php echo $resultnogbeoordelen ?> </span><a href="uitleen_admin_aanvragen_overzicht.php?status=0" class="filteraanvraagoverzicht" >Nog beoordelen</a><i class="fa-solid fa-arrow-right"
                                        style="color:white; margin-left:6px;"></i></div>

                                <div class="status-type"><span class="goedgekeurd"
                                       ><?php echo $resultgoedgekeurd ?> </span><a href="uitleen_admin_aanvragen_overzicht.php?status=1" class="filteraanvraagoverzicht" >Goedgekeurd</a><i
                                        class="fa-solid fa-forward-slash" style="color:white; margin-left:6px;"></i></div>

                                <div class="status-type"><span class="afgekeurd"
                                      ><?php echo $resultafgekeurd ?> </span><a href="uitleen_admin_aanvragen_overzicht.php?status=3" class="filteraanvraagoverzicht" >Afgekeurd</a><i
                                        class="fa-solid fa-arrow-right" style="color:white; margin-left:6px;"></i></div>

                                <div class="status-type"><span class="ingeleverd"
                                        ><?php echo $resultingeleverd ?> </span><a href="uitleen_admin_aanvragen_overzicht.php?status=2" class="filteraanvraagoverzicht" >Ingeleverd</a></div>
                            </form>
                            <div class="status-type alleaanvragen" style="margin-left:"><span class="alle"
                                    ><?php echo$resultalle ?></span><a href="uitleen_admin_aanvragen_overzicht.php?status=all"
                                    class="filterbutton"><b style="margin-right:5px;"> Alle</b></a></div>
                        </div>
                    </div>

                </div>
                <div class="uitleenaanvragenoverzichtaanvragen scroll">
                    <?php
    $aanvragen = new UitleenAanvraag();
    $totalAanvragen = count($aanvragen->getAllAanvragen());
    $perPage = 8;
    $totalPages = ceil($totalAanvragen / $perPage);

    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page - 1) * $perPage;
    $end = $start + $perPage;

    // Update this line to get the selected status from the query parameter
    $selectedStatus = isset($_GET['status']) ? $_GET['status'] : 'all';

    $allAanvragen = $aanvragen->getAllAanvragen();

    // Filter the requests based on the selected status
    $filteredAanvragen = ($selectedStatus === 'all') ?
        $allAanvragen :
        array_filter($allAanvragen, function ($aanvraag) use ($selectedStatus) {
            return $aanvraag['status'] === $selectedStatus;
        });

    $currentPageAanvragen = array_slice($filteredAanvragen, $start, $perPage);
    $rowCount = 0; // Counter for tracking the number of requests in a row

    foreach ($currentPageAanvragen as $aanvraag) {
        $aanvraag['datum_van'] = date("d-m-Y", strtotime($aanvraag['datum_van']));
        $aanvraag['datum_tot'] = date("d-m-Y", strtotime($aanvraag['datum_tot']));

        if ($rowCount % 4 === 0) {
            // Start a new row after every 4 requests
            echo '<div class="row">';
        }
        ?>

                    <div class="uitleenaanvraag">
                        <?php
            $naam = new User();
            $naamaanvraag = $naam->getUserUsername($aanvraag['naamaanvraag']);
            ?>
                        <h2> <?php echo $naamaanvraag ?></h2>
                        <div class="uitleenaanvraagdatums">
                            <b>Datum van: <?php echo $aanvraag['datum_van'] ?></b><br>
                            <b>Datum tot: <?php echo $aanvraag['datum_tot'] ?></b><br>
                            <b>Status: <?php echo $aanvragen->getStatusLabel($aanvraag['status']) ?> </b>
                        </div>
                        <div class="uitleenaanvraagproducten">
                            <br>
                            <b>Aangevraagde product(en):</b>
                            <?php $producten = new UitleenAanvraag();
                foreach ($producten->getAanvraagProducten($aanvraag['aanvraag_id']) as $product) { ?>
                            <div class="uitleenaanvraagproduct">
                                <b><?php echo $product[1] ?></b>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="uitleenaanvraagbuttons">
                            <form action="uitleen_admin_aanvragen_overzicht.php?status=<?php echo"$status&page=$page";?>" method="post">
                                <input type="hidden" name="aanvraag_id" value="<?php echo $aanvraag['aanvraag_id'] ?>">
                                <input type="submit" name="action" class="uitleenaanvraagbutton uitleengoedkeuren"
                                    value="Goedkeuren" onclick="return confirm('Wil je deze aanvraag goedkeuren?')">
                                <input type="submit" name="action" class="uitleenaanvraagbutton uitleenafkeuren"
                                    value="Afkeuren" onclick="return confirm('Wil je deze aanvraag afkeuren?')">
                                <input type="submit" name="action" class="uitleenaanvraagbutton uitleeningeleverd"
                                    value="Ingeleverd"
                                    onclick="return confirm('Wil je deze aanvraag als ingeleverd markeren?')">
                                <input type="submit" name="action" class="uitleenaanvraagbutton "
                                    value="Verwijderen" onclick="return confirm('Wil je deze aanvraag verwijderen?')">
                            </form>
                        </div>
                    </div>

                    <?php
        $rowCount++;

        if ($rowCount % 4 === 0 || $rowCount === count($currentPageAanvragen)) {
            // End the row after every 4 requests or at the end of requests
            echo '</div>';
        }
    }
    ?>

                    <?php
                    
            if ($totalPages > 1) {
                echo '<div class="pagination">';
            
            if ($page > 1) {
                // Include the current filter criteria in the pagination link
                echo '<a href="?page=' . ($page - 1) . '&status=' . urlencode($selectedStatus) . '" style="color: var(--main-color); margin-right:20px;"><</a>';
            } else {
                echo '<span style="color: var(--main-color); margin-right:20px; opacity: 0.5;"><</span>';
            }
                    
                        // Display the first page
                        echo '<a style="color: var(--main-color); margin-right:20px;' . ($page == 1 ? ' text-decoration: underline;' : '') . '" href="?page=1&status=' . urlencode($selectedStatus) . '">1</a>';

                    
                        // Display the ellipsis if there are more than 3 pages
                        if ($totalPages > 3) {
                            if ($page > 3) {
                                echo '<span style="margin-right:20px;">...</span>';
                            }
                            // Determine the start and end page numbers to display
                            $startPage = max(2, $page - 1); 
                            $endPage = min($totalPages - 1, $startPage + 2);
                    
                            // Display the pages within the range
                            for ($i = $startPage; $i <= $endPage; $i++) {
                                $activeClass = ($i == $page) ? 'active' : '';
                                // Include both 'page' and 'status' parameters in the pagination link
                                echo '<a style="color: var(--main-color); margin-right:20px;' . ($i == $page ? ' text-decoration: underline;' : '') . '" href="?page=' . $i . '&status=' . urlencode($selectedStatus) . '" class="' . $activeClass . '">' . $i . '</a>';
                            }
                    
                            // Display the ellipsis if there are more pages after the displayed range
                            if ($totalPages > $endPage) {
                                echo '<span style="margin-right:20px;">...</span>';
                            }
                        } else {
                            // Display all pages if there are 3 or fewer pages
                            for ($i = 2; $i <= $totalPages - 1; $i++) {
                                $activeClass = ($i == $page) ? 'active' : '';
                                echo '<a style="color: var(--main-color); margin-right:20px;' . ($i == $page ? ' text-decoration: underline;' : '') . '" href="?page=' . $i . '&status=' . urlencode($selectedStatus) . '" class="' . $activeClass . '">' . $i . '</a>';
                            }
                        }
                    
                        // Display the last page
                        echo '<a style="color: var(--main-color); margin-right:20px;' . ($page == $totalPages ? ' text-decoration: underline;' : '') . '" href="?page=' . $totalPages . '&status=' . urlencode($selectedStatus) .'">' . $totalPages . '</a>';
                    
                        if ($page < $totalPages) {
                            // Include the current filter criteria in the pagination link
                            echo '<a href="?page=' . ($page + 1) . '&status=' . urlencode($selectedStatus) . '" style="color: var(--main-color); margin-left:10px;">></a>';
                        } else {
                            echo '<span style="color: var(--main-color); margin-left:10px; opacity: 0.5;">></span>';
                        }
                        
                        echo '</div>';
                    } elseif ($totalPages == 0) {
                        echo 'Er zijn geen aanvragen.';
                    }      
        
                    ?>
                </div>
            </div>
        </div>
        <!-- partial -->
        <script src="script/script.js"></script>

        <script>
        var x = document.getElementById("myAudio");

        function playAudio() {
            x.play();
        }
        </script>
 
        <!-- Script voor de animatie bij de melding -->
        <script>
        var close = document.getElementsByClassName("closebtn");
        var i;

        for (i = 0; i < close.length; i++) {
            close[i].onclick = function() {
                var div = this.parentElement;
                div.style.opacity = "0";
                setTimeout(function() {
                    div.style.display = "none";
                }, 600);
            }
        }
        </script>
    </div>

    <?php

if (isset($_POST["nogbeoordelen"])) {
    $result = $nogbeoordelen;
    $resultCheck = $resultnogbeoordelen;
  } elseif (isset($_POST["goedgekeurd"])) {    
    $result = $goedgekeurd;
    $resultCheck = $resultgoedgekeurd;
  } elseif (isset($_POST["afgekeurd"])) {    
    $result = $afgekeurd;
    $resultCheck = $resultafgekeurd;
  } elseif (isset($_POST["ingeleverd"])) {    
    $result = $ingeleverd;
    $resultCheck = $resultingeleverd;
  } else  {
    $result = $alle; 
    $resultCheck = $resultalle;
  }

?>
</body>

</html>