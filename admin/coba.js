fetch('updtdata.php')
  .then(response => response.json())
  .then(data => {
      console.log("Data dari server:", data); // Cek apakah data diterima
  })
  .catch(error => console.error("Error mengambil data:", error));