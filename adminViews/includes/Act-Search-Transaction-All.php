<?php
//connection to database
include 'connection.php';

$records_per_page = 10; // number of records per page
////////////////////////////////////////////////////////////////////////////////////////////
if (isset($_POST["alltransquery"])) {
        $search = mysqli_real_escape_string($con, $_POST["alltransquery"]);
        $query = "SELECT * FROM `all_transaction` 
        WHERE transaction_num LIKE '%" . $search . "%'
        OR transaction_name   LIKE '%" . $search . "%' 
        OR Category           LIKE '%" . $search . "%' 
        OR transaction_email  LIKE '%" . $search . "%' 
        OR confirmed_by       LIKE '%" . $search . "%' 
        OR transaction_date   LIKE '%" . $search . "%' ";
} 
else {
    $query = "SELECT COUNT(*) as total_records FROM `all_transaction` ORDER BY transaction_num";
    $result = mysqli_query($con, $query);

    $total_rows = mysqli_fetch_array($result);
    $total_pages = ceil($total_rows["total_records"] / $records_per_page);
    
    if (isset($_POST["page"])) {
        $page = $_POST["page"];
    } else {
        $page = 1;
    }
    $start_from = ($page - 1) * $records_per_page;
    $query = "SELECT * FROM `all_transaction` ORDER BY transaction_num LIMIT $start_from, $records_per_page";
}

$result = mysqli_query($con, $query);
if (mysqli_num_rows($result) > 0) {
    $AllTransaction_table ='<table class="table">
    <thead>
      <tr>
      <th scope="col">Transaction No.</th>
      <th scope="col">Full Name</th>
      <th scope="col">Category</th>
      <th scope="col">Recipient Email</th>
      <th scope="col">Date</th>
      <th scope="col">Confirmed by</th>
      <th scope="col">Details</th>
      </tr>
    </thead>
    <tbody>';
    while($row=mysqli_fetch_assoc($result)){
          $Transaction_ID = $row['transaction_num'];
          $transaction_name =	$row['transaction_name'];
          $Category = $row['Category'];
          $R_email = $row['transaction_email'];
          $transaction_date = $row['transaction_date'];
          $confirm = $row['confirmed_by'];
        $AllTransaction_table .= '  <tr>
                                        <td>'.$Transaction_ID.'</td>
                                        <td>'.$transaction_name.'</td>
                                        <td>'.$Category.'</td>
                                        <td>'.$R_email.'</td>
                                        <td>'.$transaction_date.'</td>
                                        <td>'.$confirm.'</td>
                                        <td><button id="btn-view-trans" class="btn-view-trans btn btn-primary" name="view_button" onclick="view_details_trans(\''.$Transaction_ID.'\',\''.$Category.'\' )"><i class="fa-solid fa-eye"></i></button></td>
                                    <tr>';
                                    
}
$AllTransaction_table .= '</tbody></table>';
   // Add the pagination links
  $query = "SELECT COUNT(*) as total_records FROM `all_transaction`";
  $total_pages_result = mysqli_query($con, $query);
  $total_rows = mysqli_fetch_array($total_pages_result);
  $total_pages = ceil($total_rows["total_records"] / $records_per_page);
  $page = 1;
  $pagination = '<nav aria-label="Page navigation">
<ul class="pagination">';
if($page > 1){
  $pagination .= '<li class="page-item"><a class="page-link" onclick="Get_All_Transaction_Table('.($page - 1).')">Previous</a></li>';
  }
  
  // Page numbers
  for ($i = 1; $i <= $total_pages; $i++) {
  $pagination .= '<li class="page-item"><a class="page-link" onclick="Get_All_Transaction_Table('.$i.')">'.$i.'</a></li>';
  }
  
  // Next button
  if($page < $total_pages) {
  $pagination .= '<li class="page-item"><a class="page-link" onclick="Get_All_Transaction_Table('.($page + 1).')">Next</a></li>';
  }
  
  $pagination .= '</ul></nav>';
  // Concatenate the pagination links and the table
  $AllTransaction_table =  $AllTransaction_table . $pagination;

  echo $AllTransaction_table;
} else {
  echo 'Data Not Found ';
}
?>  <div class="download">
<form action="../PDF/pdf_gen_all_transaction.php" method="POST" target="_blank">
    <button type="submit" name="btn_pdf" class="btn btn-success" target="_blank"><i class="fa-solid fa-download"></i> Download PDF</button>
</form> 
</div>
<!--FOR SHOW MODAL-->
<div class="modal fade" id="other_receipt_Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable">
<div class="modal-content">
<div class="modal-header">
<h1 class="modal-title fs-5" id="exampleModalLabel">Transaction Details</h1>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id=""></button>
</div>
<div class="modal-body ps-5 pe-5">

<span hidden>transaction number</span>
<input id="modal_transno" hidden>
<span hidden>category</span>
<input id="modal_category" hidden>

<div id="Receipt-division"></div>

</div>
<div class="modal-footer">
<button type="button" class="btn btn-primary" id="others-submit-confirmed"hidden>Resend Receipt</button>
</div>
</div>
</div>
</div>
<!--FOR SHOW End-->

<script>
function view_details_trans(transno, category){
$("#modal_transno").val(transno);
$("#modal_category").val(category);

var transaction_id = $("#modal_transno").val();
var category = $("#modal_category").val();

// var transaction_id = $(this).data("transno");
//  var category = $(this).data("category");
$.ajax({
type: "POST",
url: "adminViews/includes/Act-view_all_transaction_assoc.php",
data: { transaction_id: transaction_id, category: category },
success: function(data) {
    $("#Receipt-division").html(data);
}
});
$("#other_receipt_Modal").modal("show");
}

</script>