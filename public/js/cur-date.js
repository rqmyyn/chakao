function getCurrentDateTime() {
  var today = new Date();
  var year = today.getFullYear();
  var month = String(today.getMonth() + 1).padStart(2, "0"); // เพิ่ม 0 ข้างหน้าถ้าหลักเดียว
  var day = String(today.getDate()).padStart(2, "0"); // เพิ่ม 0 ข้างหน้าถ้าหลักเดียว
  var hours = String(today.getHours()).padStart(2, "0"); // เพิ่ม 0 ข้างหน้าถ้าหลักเดียว
  var minutes = String(today.getMinutes()).padStart(2, "0"); // เพิ่ม 0 ข้างหน้าถ้าหลักเดียว
  var seconds = String(today.getSeconds()).padStart(2, "0"); // เพิ่ม 0 ข้างหน้าถ้าหลักเดียว
  return (
    year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds
  );
}
