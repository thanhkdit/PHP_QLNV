  <div id="footer">
     <p>
      &copy; Copyright <a href="http://google.com">Training with live project</a>. All Rights Reserved.
     </p>
 </div>
 <script>
 function showContract(str) {
   var input = document.getElementById("contract-select");
   input.value=String(str);
 }
 function showDepartment(str) {
   var input = document.getElementById("department-select");
   input.value=String(str);
 }
 function showLevel(str) {
   var input = document.getElementById("level-select");
   input.value=String(str);
 }
 function showPosition(str) {
   var input = document.getElementById("position-select");
   input.value=String(str);
 }
 function showEmployee(str) {
   var input = document.getElementById("employee-select");
   input.value=String(str);
 }
 function showBonusInfo(str) {
   var input = document.getElementById("bonus-select");
   input.value=String(str);
 }
 function showFineInfo(str) {
   var input = document.getElementById("fine-select");
   input.value=String(str);
 }
 function showYear(str) {
   var input = document.getElementById("year-select");
   input.value=String(str);
 }
 function checkContract() {
   var contractId = $("#add-contractId").val();
   $.get("check_contract.php",
         {
           contractId: contractId
         },
         function(data){
           console.log(data);
          if(data=='taken'){
          	$('#add-contractId').removeClass("success");
          	$('#add-contractId').addClass("error");
          }
          if(data=='not_taken'){
          	$('#add-contractId').removeClass("error");
          	$('#add-contractId').addClass("success");
          }
   });
 }
 function checkPosition() {
   var positionId = $("#add-positionId").val();
   $.get("check_position.php",
         {
           positionId: positionId
         },
         function(data){
          if(data=='taken'){
          	$('#add-positionId').removeClass("success");
          	$('#add-positionId').addClass("error");
          }
          if(data=='not_taken'){
          	$('#add-positionId').removeClass("error");
          	$('#add-positionId').addClass("success");
          }
   });
 }
 function checkEmployee() {
   var employeeId = $("#add-employeeId").val();
   $.get("check_employee.php",
         {
           employeeId: employeeId
         },
         function(data){
          if(data=='taken'){
          	$('#add-employeeId').removeClass("success");
          	$('#add-employeeId').addClass("error");
          }
          if(data=='not_taken'){
          	$('#add-employeeId').removeClass("error");
          	$('#add-employeeId').addClass("success");
          }
   });
  }
  function checkDepartment() {
    var departmentId = $("#add-departmentId").val();
    $.get("check_department.php",
          {
            departmentId: departmentId
          },
          function(data){
           if(data=='taken'){
           	$('#add-departmentId').removeClass("success");
           	$('#add-departmentId').addClass("error");
           }
           if(data=='not_taken'){
           	$('#add-departmentId').removeClass("error");
           	$('#add-departmentId').addClass("success");
           }
    });
   }
   function checkLevel() {
     var levelId = $("#add-levelId").val();
     $.get("check_level.php",
           {
             levelId: levelId
           },
           function(data){
            if(data=='taken'){
            	$('#add-levelId').removeClass("success");
            	$('#add-levelId').addClass("error");
            }
            if(data=='not_taken'){
            	$('#add-levelId').removeClass("error");
            	$('#add-levelId').addClass("success");
            }
     });
    }
 </script>

</body>
</html>
