<?php
include "db_koneksi.php";

if (isset($_post['idkel'])) {
    $idkel = $_post['idkel'];
    $ruangkel = $_post['ruangkel'];
    
    $query = "update kelas set ruangkel='$ruangkel'
    where idkel='$idkel'";

    $resuit = mysqli_query($koneksi, $query);
    echo "<script>
           alert ('data kelas berhasil diperbakit ');
            window. location.href = 'utama.php';
             </script>";

}
?>