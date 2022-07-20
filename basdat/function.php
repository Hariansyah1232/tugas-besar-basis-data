<?php

$conn = mysqli_connect("localhost","root","","ian");



//session_start();

//tambah data pesanan
if(isset($_POST['addnewdata'])){
    $namapemesan = $_POST['namapemesan'];
    $nik = $_POST['nik'];
    $alamatpemesan = $_POST['alamatpemesan'];
    $namamobil = $_POST['namamobil'];
    $jenismobil = $_POST['jenismobil'];
    $hargaperhari = $_POST['hargaperhari'];

    $addtotable = mysqli_query ($conn, "insert into stock (namapemesan, nik, alamatpemesan, namamobil, jenismobil, hargaperhari ) values('$namapemesan', '$nik', '$alamatpemesan', '$namamobil', '$jenismobil', '$hargaperhari')");
    if($addtotable){
        header('location: index.php');
    }else{
        echo 'gagal';
        header('location:index.php');
    }
};


//data pembelian
if(isset($_POST['tambahkeluar'])){
    $namamobil = $data['namamobil'];
    $hargaperhari = $data['hargaperhari'];
    $jenismobil = $data['jenismobil'];
    $namapemesan = $data['namapemesan'];
    $iddatarental = $data['iddatarental'];
    

    $addtotable = mysqli_query ($conn, "insert into datarental (namamobil, hargaperhari, jenismobil, namapemesan) values('$namamobil','$hargaperhari','$jenismobil','$namapemesan')");
    if($addtotable){
        header('location: keluar.php');
    }else{
        echo 'gagal';
        header('location:keluar.php');
    }
};

if(isset($_POST['tambahpembayaran'])){
    $namamobil = $_POST['namamobil'];
    $jenismobil = $_POST['jenismobil'];
    $hargaperhari = $_POST['hargaperhari'];

    $addtotable = mysqli_query ($conn, "insert into pembayaran (namamobil, jenismobil, hargaperhari ) values('$namamobil', '$jenismobil', '$hargaperhari')");
    if($addtotable){
        header('location: masuk.php');
    }else{
        echo 'gagal';
        header('location:masuk.php');
    }
};


if(isset($_POST['datakeluar'])){
    $datanya = $_POST['datanya'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $cekstocksekarang = mysqli_query($conn, "select * from stock where idtoko='$datanya'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $stocksekarang = $ambildatanya['jumlah'];
    $tambahkanstocksekarangdenganquantity = $stocksekarang-$qty;

    $addtokeluar = mysqli_query($conn, "insert into keluar (idtoko, penerima, qty) values('$datanya','$penerima', $qty)");
    $updatestockmasuk = mysqli_query($conn, "update stock set jumlah='$tambahkanstocksekarangdenganquantity'where idtoko='$datanya'");
    if($addtokeluar&&$updatestockmasuk){
        header('location:keluar.php');
    }else {
        echo 'gagal';
        header('loation:keluar.php');
    }
}
if(isset($_POST['editmobil'])){
    $idpembayaran = $_POST['idpembayaran'];
    $namamobil = $_POST['namamobil'];
    $jenismobil = $_POST['jenismobil'];
    $hargaperhari = $_POST['hargaperhari'];

    $update = mysqli_query($conn," update pembayaran set namamobil='$namamobil', jenismobil='$jenismobil', hargaperhari='$hargaperhari' where idpembayaran='$idpembayaran'");
    if($update){
        header('location:masuk.php');
    } else {
        echo 'gagal';
        header('location:masuk.php');
    }
}

if(isset($_POST['hapusdata'])){
    $idpembayaran = $_POST['idpembayaran'];
   
    $hapus = mysqli_query($conn,"delete from pembayaran where idpembayaran ='$idpembayaran'"); 
   if($hapus){
       header('location:masuk.php');
   }else{
    echo 'gagal';
    header('loation:masuk.php');
   }
    
};


// edit data
if(isset($_POST['editdata'])){
    $idrental = $_POST['idrental'];
    $namapemesan = $_POST['namapemesan'];
    $nik = $_POST['nik'];
    $alamatpemesan = $_POST['alamatpemesan'];
    $namamobil = $_POST['namamobil'];
    $jenismobil = $_POST['jenismobil'];
    $hargaperhari = $_POST['hargaperhari'];

    $update = mysqli_query($conn," update stock set namapemesan='$namapemesan', nik='$nik', alamatpemesan='$alamatpemesan', namamobil='$namamobil', jenismobil='$jenismobil', hargaperhari='$hargaperhari' where idrental='$idrental'");
    if($update){
        header('location:index.php');
    } else {
        echo 'gagal';
        header('location:index.php');
    }
}

//hapus data

if(isset($_POST['hapusdata'])){
    $idrental = $_POST['idrental'];
   
    $hapus = mysqli_query($conn,"delete from stock where idrental ='$idrental'"); 
   if($hapus){
       header('location:index.php');
   }else{
    echo 'gagal';
    header('loation:index.php');
   }
    
};

//edit datamasuk

if(isset($_POST['updatedatamasuk'])){
    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
   
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idteam='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtyskrg = $qtynya['qty'];


   if($qty>$qtyskrg){
       $selisih = $qty-$qtyskrg;
       $kurangin = $stockskrg - $selisih;
       $kuranginstocknya = mysqli_query($conn, "update stock set lapangan='$kurangin' where idteam='$idb'");
       $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
         if($kuranginstocknya&&$updatenya){
             header('location:masuk.php');
         }else{
             echo'gagal';
             header('location:masuk.php');
         }
   }else{
    $selisih = $qty-$qtyskrg;
    $kurangin = $stockskrg + $selisih;
    $kuranginstocknya = mysqli_query($conn, "update stock set stock='$kurangin' where idteam='$idb'");
    $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
      if($kuranginstocknya&&$updatenya){
          header('location:masuk.php');
      }else{
          echo'gagal';
          header('location:masuk.php');
      }
   }
    
}

//hapus data masuk


if(isset($_POST['hapusdatamasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['qty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "select * from stock where idteam='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stock = $data['stock'];

    $selisih = $stock-$qty;
   
    $update = mysqli_query($conn,"update stock set lapangan='$selisih' where idteam ='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'"); 
   if($update&&$hapusdata){
       header('location:masuk.php');
   }else{
    echo 'gagal';
    header('loation:masuk.php');
   }
    
};

?>